<?
/*
 * E-cidade Software Publico para Gestao Municipal
 * Copyright (C) 2014 DBSeller Servicos de Informatica
 * www.dbseller.com.br
 * e-cidade@dbseller.com.br
 *
 * Este programa e software livre; voce pode redistribui-lo e/ou
 * modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 * publicada pela Free Software Foundation; tanto a versao 2 da
 * Licenca como (a seu criterio) qualquer versao mais nova.
 *
 * Este programa e distribuido na expectativa de ser util, mas SEM
 * QUALQUER GARANTIA; sem mesmo a garantia implicita de
 * COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 * PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 * detalhes.
 *
 * Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 * junto com este programa; se nao, escreva para a Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 * 02111-1307, USA.
 *
 * Copia da licenca no diretorio licenca/licenca_en.txt
 * licenca/licenca_pt.txt
 */
require_once (modification ( "libs/db_stdlib.php" ));
require_once (modification ( "libs/db_utils.php" ));
require_once (modification ( "libs/db_conecta_plugin.php" ));
require_once (modification ( "libs/db_sessoes.php" ));
require_once (modification ( "dbforms/db_funcoes.php" ));
require_once (modification ("dbforms/db_classesgenericas.php"));

$cliframe_alterar_excluir        = new cl_iframe_alterar_excluir();
$clorcprojativdetalhamentorecursos  = new cl_orcprojativdetalhamentorecursos();

db_postmemory ( $HTTP_POST_VARS );

if (isset ( $incluir )) {
		
	db_inicio_transacao ();
	$clorcprojativdetalhamentorecursos->sequencial      = null;
	$clorcprojativdetalhamentorecursos->orcprojativ     = $codprojativ;
	$clorcprojativdetalhamentorecursos->anousu          = $anousu;
	$clorcprojativdetalhamentorecursos->ppafonterecurso = $ppafonterecurso;
	$clorcprojativdetalhamentorecursos->valor           = $valor;
    $clorcprojativdetalhamentorecursos->incluir ( null );
    $erro_msg = $clorcprojativdetalhamentorecursos->erro_msg;
    if ($clorcprojativdetalhamentorecursos->erro_status == 0) {
    	$sqlerro = true;
    }
    db_fim_transacao ( $sqlerro );
    db_msgbox($erro_msg);
	
} else if (isset ( $alterar )) {
	
	
	db_inicio_transacao ();
	
	$clorcprojativdetalhamentorecursos->orcprojativ     = $codprojativ;
	$clorcprojativdetalhamentorecursos->anousu          = $anousu;
	$clorcprojativdetalhamentorecursos->ppafonterecurso = $ppafonterecurso;
	$clorcprojativdetalhamentorecursos->valor           = $valor;
    $clorcprojativdetalhamentorecursos->alterar ( $sequencial );
    $erro_msg = $clorcprojativdetalhamentorecursos->erro_msg;
    if ($clorcprojativdetalhamentorecursos->erro_status == 0) {
    	$sqlerro = true;
    }
    
    db_fim_transacao ( $sqlerro );
    
    db_msgbox($erro_msg);
	
} else if (isset ( $excluir )) {
	
	db_inicio_transacao ();
    $clorcprojativdetalhamentorecursos->excluir ( $sequencial );
    $erro_msg = $clorcprojativdetalhamentorecursos->erro_msg;
    if ($clorcprojativdetalhamentorecursos->erro_status == 0) {
    	$sqlerro = true;
    }
    db_fim_transacao ( $sqlerro );
    db_msgbox($erro_msg);
	
} else if (isset ( $opcao )) {
	
	$result = $clorcprojativdetalhamentorecursos->sql_record ( $clorcprojativdetalhamentorecursos->sql_query ( $sequencial ) );
	if ($result != false && $clorcprojativdetalhamentorecursos->numrows > 0) {
		db_fieldsmemory ( $result, 0 );
	}
	
}

$result_valor_global = $clorcprojativdetalhamentorecursos->sql_record ( $clorcprojativdetalhamentorecursos->sql_query ( null, "sum(valor) as valor_global", "", "anousu = {$anousu} and orcprojativ = {$codprojativ}" ) );
db_fieldsmemory($result_valor_global, 0);

if (isset($db_opcaoal)) {

	$db_opcao=33;
	$db_botao=false;

} else if(isset($opcao) && $opcao=="alterar") {

	$db_botao=true;
	$db_opcao = 2;

} else if(isset($opcao) && $opcao=="excluir") {

	$db_opcao = 3;
	$db_botao=true;

} else {

	$db_opcao = 1;
	$db_botao=true;
	if(isset($novo) || isset($alterar) ||   isset($excluir) || (isset($incluir) && $sqlerro==false ) ){
		$sequencial       = "";
		$ppafonterecurso  = "";
		$descricao        = "";
		$valor            = "";
	}

}

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript"	src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript"	src="scripts/prototype.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
<table align="center" style="padding-top: 25px;" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td>
    <form name="form1" method="post" action="">
     <input type="hidden" name="codprojativ" value="<?=$codprojativ?>">
     <fieldset>
      <legend> Manutenção de Recursos </legend>
      <table border="0" width="100%">
        <tr>
          <td nowrap title="sequencial">
             <b>Sequencial :</b>
          </td>
          <td> 
           <?
           db_input('sequencial',10,1,true,'text',3);
           ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="Fonte de Recurso">
            <? db_ancora("Fonte de Recurso","js_pesquisa_ppafonterecurso(true);",$db_opcao); ?>
          </td>
          <td> 
           <?
           db_input('ppafonterecurso',10,1,true,'text',$db_opcao,"onchange='js_pesquisa_ppafonterecurso(false)'");
           db_input('descricao',40,1,true,'text',3);
           ?>
          </td>
        </tr>        
        <tr>
          <td nowrap title="Valor do Recurso">
            <b>Valor: </b> 
          </td>
          <td>
           <? db_input('valor',10,4,true,'text',$db_opcao); ?> 
          </td>
        </tr>
      </table>
      </fieldset>  
     
      <table width="100%">
        <tr>
          <td align="center">
            <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?>  >
            <input name="novo" type="button" id="cancelar" value="Novo" onclick="js_cancelar();" <?=($db_opcao==1||isset($db_opcaoal)?"style='visibility:hidden;'":"")?> >
          </td>
        </tr>
      </table>
      
      <table>
        <tr>
         <td valign="top"  align="center">  
         <?
	      $chavepri= array("sequencial"=>@$sequencial);
	      $cliframe_alterar_excluir->chavepri=$chavepri;
	      $cliframe_alterar_excluir->sql     = $clorcprojativdetalhamentorecursos->sql_query(null,"*, (select descricao from plugins.ppafontesrecurso where sequencial = ppafonterecurso) as descricao",null,"orcprojativ=$codprojativ and anousu = {$anousu}");
	      $cliframe_alterar_excluir->campos  ="sequencial, descricao, valor";
	      $cliframe_alterar_excluir->legenda="Recursos Detalhados";
	      $cliframe_alterar_excluir->iframe_height ="160";
	      $cliframe_alterar_excluir->iframe_width ="700";
	      $cliframe_alterar_excluir->iframe_alterar_excluir(1);
         ?>
         </td>
        </tr>
        <tr>
          <td>
            <b> Valor Global: <?=db_formatar($valor_global, "f")?></b>
          </td>
        </tr>
      </table>
    </form>
  </td>
 </tr>
</table>

<script>
function js_cancelar(){
  var opcao = document.createElement("input");
  opcao.setAttribute("type","hidden");
  opcao.setAttribute("name","novo");
  opcao.setAttribute("value","true");
  document.form1.appendChild(opcao);
  document.form1.submit();
}

function js_pesquisa_ppafonterecurso(mostra){
  if (mostra==true) {
    js_OpenJanelaIframe('','db_iframe_ppafonterecurso','func_ppafontesrecurso.php?funcao_js=parent.js_mostrappafonterecurso1|sequencial|descricao','Pesquisa',true);
  } else {
    if (document.form1.ppafonterecurso.value != '') {
      js_OpenJanelaIframe('','db_iframe_ppafonterecurso','func_ppafontesrecurso.php?pesquisa_chave='+document.form1.ppafonterecurso.value+'&funcao_js=parent.js_mostrappafonterecurso','Pesquisa',false);
    } else {
      document.form1.ppafonterecurso.value='';
    }  
  }
}

function js_mostrappafonterecurso (chave,erro) {
  document.form1.descricao.value = chave; 
  if(erro==true){ 
	document.form1.ppafonterecurso.value = '';
    document.form1.ppafonterecurso.focus(); 
  }
}

function js_mostrappafonterecurso1 (chave1,chave2) {
  db_iframe_ppafonterecurso.hide();
  document.form1.ppafonterecurso.value = chave1;
  document.form1.descricao.value = chave2;
}
</script>

</body>
</html>