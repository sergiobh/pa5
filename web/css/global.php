<?php header('Content-type: text/css');?>
<?php define('BASE_IMG',(isset($_SERVER['HTTPS']) ? 'https://' : 'http://').$_SERVER['HTTP_HOST']);?>
<?php echo "/*";?><style><?php echo "*/\n";?>
html{
	background: none repeat scroll 0 0 #E1E1E5;
}
body{
    margin: 0;
	background: url('<?php echo BASE_IMG;?>/web/imagens/site/background.png') 50% top repeat-y;
}
h2{
	font-size: 26px !important;
}
.middle{
	overflow: visible !important;
	width: 999px;
	margin: 0 auto !important;
}
.middle .header_page{
	padding-top: 20px;
	margin: 0 370px 0 370px;
	position: relative;
	z-index: 100;
}
.middle .header_page .logo{
	background: url('<?php echo BASE_IMG;?>/web/imagens/site/logo.png') no-repeat;
	width: 260px;
	height: 110px;
}
.middle .logout{
	float:right;
	margin-right: 100px;
	position: relative;
	z-index: 100;
}
.middle .logout .nome{
	float:left;
}
.middle .logout .deslogar{
	float: left;
	margin-left: 2px;
	width: 20px;
}
.middle .logout .deslogar a{
	color: #333333;
	display: block;
}
.middle .logout .deslogar a:hover,
.middle .logout .deslogar a:visited{
	color: #333333;
}
.middle .container{
    margin: 0 auto;
    min-height: 500px;
    width: 1024px;
}
.titulo_page{
	text-align: center;
	font-size: 25px;
	color: #333333;
	margin-bottom: 10px;
}

<?php /*
/* Menu
*/ ?>
.middle .menu_header{
	background: url('<?php echo BASE_IMG;?>/web/imagens/site/menu_header.png') no-repeat;
	margin: -33px 0 0 44px;
	width: 911px;
	height: 180px;
	position: relative;
	z-index: 90;
}
.middle .menu_header .menu_content{
	padding: 54px 99px 0 100px;
}
.middle .menu_header .menu_content .botao{
	display: block;
	float: left;
	/*padding: 0 14px 0 14px;*/
	height: 78px;
}
.middle .menu_header .menu_content .botao.ativo{
	background: url('<?php echo BASE_IMG;?>/web/imagens/site/menu_ativo.png') no-repeat scroll right top transparent;
}
.middle .menu_header .menu_content .botao .menu_text{
	display: block;
	cursor: pointer;
	padding: 26px 39px 30px 39px;
	/*padding-top: 26px;*/
	font-family: "Lucida Grande","Lucida Sans Unicode","Helvetica","Arial","Verdana","sans-serif";
	font-size: 14px;
	color: #333333;
}

<?php /*
/* SubMenu
*/ ?>
.menu_header .submenu{
	display: none;
	position: absolute;
	/*width: 250px;*/
	/*margin-left: -14px;*/
	/*margin-top: 72px;*/
	/*padding-top: 72px;*/
	background-color: #F7F7F7;
	/*color: #56595E;*/
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
}
.menu_header a,
.menu_header .submenu{
	color: #333333;
	text-decoration: none;
}
.menu_header .menu_body .submenu_item{
	/*padding-left: 10px;
	padding-right: 10px;*/
	padding: 7px 12px;
	border-top: 1px solid #D1D1D1;
	min-width: 140px;
}
.menu_header .menu_body .submenu_item.submenu_primeiro{
	-webkit-border-top-left-radius: 5px;
	-webkit-border-top-right-radius: 5px;
	-moz-border-radius-topleft: 5px;
	-moz-border-radius-topright: 5px;
	border-top-left-radius: 5px;
	border-top-right-radius: 5px;
	border-top: 0;
}
.menu_header .menu_body .submenu_item.submenu_ultimo{
	-webkit-border-bottom-right-radius: 5px;
	-webkit-border-bottom-left-radius: 5px;
	-moz-border-radius-bottomright: 5px;
	-moz-border-radius-bottomleft: 5px;
	border-bottom-right-radius: 5px;
	border-bottom-left-radius: 5px;
}
.menu_header .menu_body .submenu_item.item_ativo{
	background-color: #E1E1E1;
}


<?php /* Enrique conteudo do estilo.css */ ?>
.border { 
	border:#360 solid 2px;
}

a:link{
text-decoration:none
}

.vazio{
border-color:red
}


<?php /*
/* Home
*/ ?>
.home_andar{
	margin-top: 10px;
	padding-top: 10px;
	clear: both;
}
.home_andar .home_andar_item{
	margin-top: 15px;	
	font-size: 22px;
	color: #F00;
	font-weight: bold;
}
.home_andar .home_quarto{
	margin-top: 5px;
	clear: both;
}
.home_andar .home_quarto_item{
	color: blue;
	font-weight: bold;
	padding-top: 10px;
}
.home_andar .home_leito_item{
	float: left;
	width: 266px;
	height: 26px;
	text-align: center;
	margin-top: 5px;
	padding-top: 3px;
}
.home_andar .link_leito{
	color: #000;
}
.home_andar .home_leito_item.Ocupado{
	background-color: #F00;
}
.home_andar .home_leito_item.Liberado,
.home_andar .home_leito_item.Ativo{
	background-color: #0F0;
}
.home_andar .home_leito_item.Arrumacao{
	background-color: #FFFF00;
}
.home_andar .home_leito_item.Desativado{
	background-color: #C0C0C0;
}


<?php /*
/* Cadastrar e Editar
*/ ?>
.col_titulo{
	width: 150px;
}
td select{
	width: 260px;	
}
td input{
	width: 254px;
}
.botao_submit,
.botao_reset{
	width: 100px;
	margin-top: 20px;
}
.add_telefone,
.del_telefone{
	width: 100px;
}
.botao_reset,
.botao_reset{
	margin-left: 15px;
}

<?php /*
/* Campo de mensagem de erro
*/ ?>
.retorno_ajax{
	color: #F00;
}

<?php /*
/* Footer
*/ ?>
.footer{
	clear: both;
	width:800px;
	height:100px;
	margin-top: 20px;
	margin-left: 100px;
	padding-top:20px;
	background-color:#900;
	color:#FFF;
}

<?php /*
/* tabela
*/ ?>
table.tablesorter {
    background-color: #CDCDCD;
    font-family: arial;
    font-size: 14px;
    margin: 10px 0 15px;
    text-align: left;
    width: 100%;
}
table.tablesorter thead tr .header {
    background-image: url("<?php echo BASE_IMG;?>/web/imagens/site/bg.gif");
    background-position: right center;
    background-repeat: no-repeat;
    cursor: pointer;
}
table.tablesorter tfoot tr th {
    background-color: #E6EEEE;
    border: 1px solid #FFFFFF;
    font-size: 8pt;
    padding: 4px;
}
table.tablesorter thead tr .headerSortDown, table.tablesorter thead tr .headerSortUp {
    background-color: #8DBDD8;
}
table.tablesorter thead tr .headerSortUp {
    background-image: url(<?php echo BASE_IMG;?>/web/imagens/site/asc.gif); 
}
table.tablesorter thead tr .headerSortDown {
    background-image: url(<?php echo BASE_IMG;?>/web/imagens/site/desc.gif); 
}
table.tablesorter tbody td {
    background-color: #FFFFFF;
    color: #3D3D3D;
    padding: 4px;
    vertical-align: top;
}
table.tablesorter tbody tr.odd td {
    background-color: #F0F0F6;
}



/*
table tbody tr.odd td{
	background-color:#ffffcc;
}
table tbody tr.hover td{
	background-color:#a9d0f5;
}
th.headerSortUp { 
    background-image: url(<?php echo BASE_IMG;?>/web/imagens/site/asc.gif); 
    background-color: #8dbdd8; 
} 
th.headerSortDown { 
    background-image: url(<?php echo BASE_IMG;?>/web/imagens/site/desc.gif); 
    background-color: #3399FF; 
} 
th.header { 
    background-image: url(<?php echo BASE_IMG;?>/web/imagens/site/small.gif);
    cursor: pointer; 
    font-weight: bold; 
    background-repeat: no-repeat; 
    background-position: center left; 
    padding-left: 20px; 
    border-right: 1px solid #dad9c7; 
    margin-left: -1px; 
}
*/

.fancybox-skin{
	position: relative;
	z-index: 200;
}


<?php /*
/* Clear
*/ ?>
.clear{
	clear: both;
}
.clear_left{
	clear: left;
}
.clear_right{
	clear: right;
}
.quebra_linha{
  word-wrap: break-word;
}
.hide{
	display: none;
}

.tbodyChamados .botao_editar{
	float: left;
	width: 20px;
}
.tbodyChamados .botao_exportar{
	margin-left: 22px;
	width: 20px;
}

.functionario_login {
	margin-top: 120px !important;
}

.linha_botoes{
	height: 40px;
}
.chamados_listar .linha_botoes .btn{
	margin-right: 30px;
}

.ticketxml_importar .RespostaXml{
	margin: 0 auto;
    max-width: 330px;
    padding: 15px;
    font-weight: bold;
    color: #FF0000;
}


.chamados_historicos{
	margin-bottom: 40px;
}