<?php
$Tabindex = 1;

$this->load->library ( "PermissaoLib" );
?>
<div class='menu_header'>
	<div class='menu_content'>
		<div class='botao menu_body' tabindex='<?php echo $Tabindex++;?>'
			submenu='menu<?php echo $Tabindex;?>'>
			<div class='menu_text'>Leitos</div>
			<div class='submenu menu<?php echo $Tabindex;?>'>
				<div class='submenu_containt'>
					<a href="<?php echo BASE_URL;?>">
						<div class='submenu_item submenu_primeiro'>Painel de leitos</div>
					</a> <a href="<?php echo BASE_URL;?>/leito/cadastrar">
						<div class='submenu_item'>Cadastrar</div>
					</a> <a href="<?php echo BASE_URL;?>/leito/listar">
						<div class='submenu_item'>Listar</div>
					</a>
				</div>
			</div>
		</div>

		<div class='botao menu_body' tabindex='<?php echo $Tabindex++;?>'
			submenu='menu<?php echo $Tabindex;?>'>
			<div class='menu_text'>Quartos</div>
			<div class='submenu menu<?php echo $Tabindex;?>'>
				<div class='submenu_containt'>
					<a href="<?php echo BASE_URL;?>/quarto/cadastrar">
						<div class='submenu_item submenu_primeiro'>Cadastrar</div>
					</a> <a href="<?php echo BASE_URL;?>/quarto/listar">
						<div class='submenu_item'>Listar</div>
					</a>
				</div>
			</div>
		</div>

		<div class='botao menu_body' tabindex='<?php echo $Tabindex++;?>'
			submenu='menu<?php echo $Tabindex;?>'>
			<div class='menu_text'>Pacientes</div>
			<div class='submenu menu<?php echo $Tabindex;?>'>
				<div class='submenu_containt'>
					<a href="<?php echo BASE_URL;?>/paciente/painel">
						<div class='submenu_item'>Painel de pacientes</div>
					</a> <a href="<?php echo BASE_URL;?>/paciente/consultar">
						<div class='submenu_item submenu_primeiro'>Consultar</div>
					</a>
				</div>
			</div>
		</div>

		<div class='botao menu_body' tabindex='<?php echo $Tabindex++;?>'
			submenu='menu<?php echo $Tabindex;?>'>
			<div class='menu_text'>Funcionários</div>
			<div class='submenu menu<?php echo $Tabindex;?>'>
				<div class='submenu_containt'>
					<a href="<?php echo BASE_URL;?>/funcionario/cadastrar">
						<div class='submenu_item'>Cadastrar</div>
					</a> <a href="<?php echo BASE_URL;?>/funcionario/listar">
						<div class='submenu_item submenu_primeiro'>Listar</div>
					</a>
					<?php if(PermissaoLib::checkAdmin()){ ?>
						<a href="<?php echo BASE_URL;?>/setor/cadastrar">
						<div class='submenu_item'>Cadastrar Setores</div>
					</a><a href="<?php echo BASE_URL;?>/setor/listar">
						<div class='submenu_item'>Listar Setores</div>
					</a>
					<?php } ?>
				</div>
			</div>
		</div>

		<div class='botao menu_body' tabindex='<?php echo $Tabindex++;?>'
			submenu='menu<?php echo $Tabindex;?>'>
			<div class='menu_text'>Chamados</div>
			<div class='submenu menu<?php echo $Tabindex;?>'>
				<div class='submenu_containt'>
					<a href="<?php echo BASE_URL;?>/chamado/cadastrar">
						<div class='submenu_item submenu_primeiro'>Cadastrar Tickets</div>
					</a> <a href="<?php echo BASE_URL;?>/chamado/listar">
						<div class='submenu_item'>Listar Tickets</div>
					</a> <a href="<?php echo BASE_URL;?>/ticket_xml/importar">
						<div class='submenu_item'>Importar XML</div>
					</a>
					<?php if(PermissaoLib::checkAdmin()){ ?>
					<a href="<?php echo BASE_URL;?>/categoria/cadastrar">
						<div class='submenu_item'>Cadastrar Categorias</div>
					</a><a href="<?php echo BASE_URL;?>/categorias/listar">
						<div class='submenu_item'>Listar Categorias</div>
					</a>
						<a href="<?php echo BASE_URL;?>/tipo/cadastrar">
						<div class='submenu_item'>Cadastrar Tipos</div>
					</a><a href="<?php echo BASE_URL;?>/tipo/listar">
						<div class='submenu_item'>Listar Tipos</div>
					</a>
					<?php } ?>
					
				</div>
			</div>
		</div>
	</div>
</div>