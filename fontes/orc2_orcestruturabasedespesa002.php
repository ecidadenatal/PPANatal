<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */
require_once(modification("fpdf151/pdf.php"));
require_once(modification("libs/db_stdlib.php"));
require_once(modification("libs/db_utils.php"));
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$head3 = "RELATÓRIO DE ESTRUTURAS BASE DA DESPESA";

$head6 = "Exercício: ".$exercicio;

$oPdf = new PDF();
$oPdf->Open();
$oPdf->AliasNbPages();
$oPdf->setfillcolor(235);
$oPdf->setfont('arial','b',8);
$oPdf->addpage();
$nTotal = 0;

$sWhere  = " instituicao in (".str_replace("-", ",",$db_selinstit).")";
$sWhere .= " and exercicio = {$exercicio} ";
if ($orgao != "") {
	$sWhere .= " and orcorgao = {$orgao}";
}
if ($unidade != "") {
	$sWhere .= " and orcunidade = {$unidade}";
}


$sSql = " select orcorgao, 
		         lpad(orcunidade, 2, '0') as orcunidade, 
		         o41_descr, 
		         orcorgao||'.'||lpad(orcunidade, 2, '0')||'.'||lpad(orcfuncao, 2, '0')||'.'||lpad(orcsubfuncao, 3, '0')||'.'||lpad(orcprograma, 4, '0')||'.'||lpad(orcprojativ, 4, '0') as estrutura, 
		         o55_descr 
            from plugins.orcestruturabasedespesa 
		         inner join orcunidade   on o41_anousu   = exercicio 
		                                and o41_orgao    = orcorgao 
		                                and o41_unidade  = orcunidade 
		         inner join orcprojativ  on o55_anousu   = exercicio 
		                                and o55_projativ = orcprojativ 
		                                and o55_instit   = instituicao 
	       where {$sWhere}";
$rsDados = db_query($sSql);
$iLinhas = pg_num_rows($rsDados);

for ($iInd = 0; $iInd < $iLinhas; $iInd ++) {
	
	$oDados =  db_utils::fieldsMemory($rsDados, $iInd);
	
	$sIdUnidade = $oDados->instituicao."-".$oDados->orgao."-".$oDados->unidade;
	if ($sHashUnidade != $sIdUnidade) {
		
		$oPdf->cell(180,5,$oDados->orcorgao."/".$oDados->orcunidade." - ".$oDados->o41_descr,"",1,"L",0);
		
	}
	$sHashUnidade = $sIdUnidade;
	
	if ($oPdf->gety() > $oPdf->h - 30 || $iInd == 0) {
	
		$oPdf->setfont('arial','b',8);
		$oPdf->cell(40,5,"Estrutural","",0,"C",1);
		$oPdf->cell(150,5,"Descrição","",1,"L",1);
		$oPdf->setfont('arial','',8);
	
	}
	
	$oPdf->setfont('arial','',8);
	$oPdf->cell(40,5,$oDados->estrutura,"",0,"C",0);
	$oPdf->cell(150,5,$oDados->o55_descr,"",1,"L",0);

}
$oPdf->Output();
?>