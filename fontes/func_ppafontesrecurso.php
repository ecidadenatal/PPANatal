<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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
parse_str($_SERVER["QUERY_STRING"]);

require_once(modification("classes/db_ppafontesrecurso_classe.php"));

$clppafontesrecurso = new cl_ppafontesrecurso();

?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table height="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
  <tr>
    <td height="63" align="center" valign="top">
      <table width="35%" border="0" align="center" cellspacing="0">
        <form name="form2" method="post" action="" >
          <tr>
            <td width="4%" align="right" nowrap title="Sequencial">
              <b>Sequencial: </b>
            </td>
            <td width="96%" align="left" nowrap>
              <?
                db_input("sequencial",10,1,true,"text",1,"","chave_sequencial");
              ?>
            </td>
          </tr>
          <tr>
            <td width="4%" align="right" nowrap title="descricao">
              <b>Descri��o: </b>
            </td>
            <td width="96%" align="left" nowrap>
              <?
              db_input("descricao",50,0,true,"text",4,"","chave_descricao");
              ?>
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center">
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_ppafonterecurso.hide();">
            </td>
          </tr>
        </form>
      </table>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">
      <?

      $chave_descricao = addslashes($chave_descricao);

      if(!isset($pesquisa_chave)){
        
      	if(isset($chave_sequencial) && trim($chave_sequencial) != ""){
          $sql = $clppafontesrecurso->sql_query($chave_sequencial,"*");
        }else if(isset($chave_descricao) && (trim($chave_descricao)!="") ){
          $sql = $clppafontesrecurso->sql_query(null,"*","descricao like '$chave_descricao%'");
        }else{
          $sql = $clppafontesrecurso->sql_query(null,"*");
        }
        db_lovrot($sql,15,"()","",$funcao_js);

      }else{

        if($pesquisa_chave!=null && $pesquisa_chave!=""){

          $result = $clppafontesrecurso->sql_record($clppafontesrecurso->sql_query($pesquisa_chave,"*"));
          if($clppafontesrecurso->numrows > 0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('{$descricao}', false);</script>";
          }else{
            echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") n�o Encontrado',true,'');</script>";
          }
        }else{
          echo "<script>".$funcao_js."('',false);</script>";
        }
      }
      ?>
    </td>
  </tr>
</table>
</body>
</html>