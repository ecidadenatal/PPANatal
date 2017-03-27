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

require_once (modification ( "classes/db_orcprojativmetas_classe.php" ));

$cliframe_alterar_excluir = new cl_iframe_alterar_excluir();
$clorcprojativmetas      = new cl_orcprojativmetas();

db_postmemory ( $HTTP_POST_VARS );

if (isset ( $incluir )) {
		
	db_inicio_transacao ();
	$clorcprojativmetas->sequencial   = null;
	$clorcprojativmetas->orcprojativ  = $codprojativ;
	$clorcprojativmetas->anousu       = $anousu;
	$clorcprojativmetas->meta         = $meta;
	$clorcprojativmetas->usuario      = db_getsession("DB_id_usuario");
	$clorcprojativmetas->departamento = db_getsession("DB_coddepto");
	$clorcprojativmetas->data         = date("Y-m-d",db_getsession("DB_datausu")); 
    $clorcprojativmetas->incluir ( null );
    $erro_msg = $clorcprojativmetas->erro_msg;
    if ($clorcprojativmetas->erro_status == 0) {
    	$sqlerro = true;
    }
    db_fim_transacao ( $sqlerro );
    db_msgbox($erro_msg);
	
} else if (isset ( $alterar )) {
	
	
	if (empty($meta)) {
		
	  $erro_msg = "Informe o campo descrição";
	  $sqlerro = true;
	  
	} else {
		
	  db_inicio_transacao ();
	  
	  $sSqlUpdate  = "update plugins.orcprojativmetas set meta = '{$meta}' "; 
	  $sSqlUpdate .= " where sequencial = {$sequencial} ";
	  $rsUpdate = db_query($sSqlUpdate);
	  if ($rsUpdate) {
	    $erro_msg = "Alteração realizada com sucesso";	
	  } else {
	    $erro_msg = "Operação não realizada\n".pg_last_error();
	    $sqlerro = true;
      }
      
      db_fim_transacao ( $sqlerro );
      
	}
    
    db_msgbox($erro_msg);
	
} else if (isset ( $excluir )) {
	
	db_inicio_transacao ();
    $clorcprojativmetas->excluir ( $sequencial );
    $erro_msg = $clorcprojativmetas->erro_msg;
    if ($clorcprojativmetas->erro_status == 0) {
    	$sqlerro = true;
    }
    db_fim_transacao ( $sqlerro );
    db_msgbox($erro_msg);
	
} else if (isset ( $opcao )) {
	
	$result = $clorcprojativmetas->sql_record ( $clorcprojativmetas->sql_query ( $sequencial ) );
	if ($result != false && $clorcprojativmetas->numrows > 0) {
		db_fieldsmemory ( $result, 0 );
	}
	
}

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
		$sequencial = "";
		$meta       = "";
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
      <legend> Manutenção de Metas </legend>
      <table border="0" width="100%">
        <tr>
          <td nowrap title="sequencial">
             <b>Sequencial :</b>
          </td>
          <td> 
           <?
           db_input('sequencial',6,1,true,'text',3);
           ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="Descrição da Meta">
            <b>Descrição: </b> 
          </td>
          <td>
           <? db_textarea('meta',2,50,0,true,'text',$db_opcao); ?> 
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
	      $cliframe_alterar_excluir->sql     = $clorcprojativmetas->sql_query(null,"*",null,"orcprojativ=$codprojativ and anousu = {$anousu}");
	      $cliframe_alterar_excluir->campos  ="sequencial, meta";
	      $cliframe_alterar_excluir->legenda="Metas cadastradas";
	      $cliframe_alterar_excluir->iframe_height ="160";
	      $cliframe_alterar_excluir->iframe_width ="700";
	      $cliframe_alterar_excluir->iframe_alterar_excluir(1);
         ?>
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
</script>

</body>
</html>