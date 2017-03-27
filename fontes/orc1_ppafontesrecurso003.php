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

require_once(modification("libs/db_stdlib.php"));
require_once(modification("libs/db_conecta_plugin.php"));
require_once(modification("libs/db_sessoes.php"));
require_once(modification("dbforms/db_funcoes.php"));

db_postmemory($_POST);

$db_botao = false;
$db_opcao = 33;

$oPPAFontesRecurso = new cl_ppafontesrecurso();

if (isset($excluir)) {

  $db_opcao = 3;
	
  db_inicio_transacao();
  $oPPAFontesRecurso->excluir($sequencial);
  db_fim_transacao();
  
} else if(isset($chavepesquisa)) {
   
   $sSql   = $oPPAFontesRecurso->sql_query($chavepesquisa);
   $result = $oPPAFontesRecurso->sql_record($sSql);
   db_fieldsmemory($result,0);
   
   $db_opcao = 3;
   $db_botao = true;
   
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
    <center>
	<?
	include("forms/db_frmppafontesrecurso.php");
	?>
    </center>
<?
db_menu();
?>
</body>
</html>
<?
if (isset($excluir)) {
	
  if ($oPPAFontesRecurso->erro_status=="0") {
    $oPPAFontesRecurso->erro(true,false);
  } else {
    $oPPAFontesRecurso->erro(true,true);
  }
  
}

if ($db_opcao==33) {
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>