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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("libs/db_liborcamento.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
?>

<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
  <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>

  <table  align="center">
    <form name="form1" method="post" action="" onsubmit="return js_verifica();">
      <tr>
         <td >&nbsp;</td>
         <td >&nbsp;</td>
      </tr>
      <tr>
         <td colspan="2">
           <?
            db_selinstit('',500,200);
           ?>
          </td>
      </tr>
      <tr>
       <td colspan=2>&nbsp;</td>
      </tr>
      <tr>
          <td nowrap title="orgao">
             <?
              db_ancora("Orgão: ","js_pesquisao40_orgao(true);",1);
             ?>
          </td>
          <td> 
            <?
              db_input('orgao',10,'',true,'text',1," onchange='js_pesquisao40_orgao(false);'");
              db_input('o40_descr',40,'',true,'text',3,'')
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="unidade">
             <?
              db_ancora("Unidade: ","js_pesquisao41_unidade(true);",1);
             ?>
          </td>
          <td> 
            <?
              db_input('unidade',10,'',true,'text',1," onchange='js_pesquisao41_unidade(false);'");
              db_input('o41_descr',40,'',true,'text',3,'')
            ?>
          </td>
        </tr>
      <tr>
        <td><b>Exercício: </b></td> 
        <td>
          <?
            $exercicio = db_getsession("DB_anousu");
            db_input('exercicio', 5, 1, true, 'text', $iOpcao); 
          ?>
        </td>
      </tr>
      <tr>
        <td colspan="2" align = "center"> 
          <input  name="emite2" id="emite2" type="button" value="Processar" onclick="js_emite();" >
        </td>
      </tr>

  </form>
    </table>
<?
  db_menu();
?>
</body>
</html>

<script>

function js_emite(){

  sUrl  = "orc2_orcestruturabasedespesa002.php";
  sUrl += "?db_selinstit="+document.form1.db_selinstit.value;
  sUrl += "&exercicio="+document.form1.exercicio.value;
  sUrl += "&orgao="+document.form1.orgao.value;
  sUrl += "&unidade="+document.form1.unidade.value;
  jan = window.open(sUrl,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
  jan.moveTo(0,0);
  
}


function js_pesquisao40_orgao(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_orcorgao','func_orcorgao.php?funcao_js=parent.js_mostraorcorgao1|o40_orgao|o40_descr','Pesquisa',true);
  }else{
     if(document.form1.orgao.value != ''){ 
        js_OpenJanelaIframe('top.corpo','db_iframe_orcorgao','func_orcorgao.php?pesquisa_chave='+document.form1.orgao.value+'&funcao_js=parent.js_mostraorcorgao','Pesquisa',false);
     }else{
       document.form1.o40_descr.value = ''; 
     }
  }
}
function js_mostraorcorgao(chave,erro){
  document.form1.o40_descr.value = chave; 
  if(erro==true){ 
    document.form1.orgao.focus(); 
    document.form1.orgao.value = ''; 
  }
}
function js_mostraorcorgao1(chave1,chave2){
  document.form1.orgao.value = chave1;
  document.form1.o40_descr.value = chave2;
  db_iframe_orcorgao.hide();
}

function js_pesquisao41_unidade(mostra) {
	  
	  if ($F('orgao') == '') {
	    
	    alert('Antes de escolher uma Unidade, informe um orgão!');
	    return false;
	    
	  } 
	  var sFiltro = 'orgao='+$F('orgao');
	  if(mostra==true){
	    js_OpenJanelaIframe('top.corpo',
	                        'db_iframe_orcunidade',
	                        'func_orcunidade.php?funcao_js=parent.js_mostraorcunidade1|o41_unidade|o41_descr&'+sFiltro,
	                        'Unidades',
	                        true
	                       );
	  }else{
	  
	     if(document.form1.unidade.value != ''){ 
	        js_OpenJanelaIframe('top.corpo',
	                            'db_iframe_orcunidade',
	                            'func_orcunidade.php?pesquisa_chave='+
	                             document.form1.unidade.value+'&funcao_js=parent.js_mostraorcunidade&'+sFiltro,
	                            'Pesquisa',
	                            false);
	     }else{
	       document.form1.o41_descr.value = ''; 
	     }
	  }
	}
	function js_mostraorcunidade(chave,erro){
	  document.form1.o41_descr.value = chave; 
	  if(erro==true){ 
	    document.form1.unidade.focus(); 
	    document.form1.unidade.value = ''; 
	  }
	}
	function js_mostraorcunidade1(chave1,chave2){
	  document.form1.unidade.value = chave1;
	  document.form1.o41_descr.value = chave2;
	  db_iframe_orcunidade.hide();
	}
</script>