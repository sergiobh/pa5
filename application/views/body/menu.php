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
						<div class='submenu_item submenu_primeiro'>Painel de pacientes</div>
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
						<div class='submenu_item submenu_primeiro'>Cadastrar Funcionários</div>
					</a> <a href="<?php echo BASE_URL;?>/funcionario/listar">
						<div class='submenu_item'>Listar Funcionários</div>
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
					</a><a href="<?php echo BASE_URL;?>/categoria/listar">
						<div class='submenu_item'>Listar Categorias</div>
					</a> <a href="<?php echo BASE_URL;?>/tipoticket/cadastrar">
						<div class='submenu_item'>Cadastrar Tipos</div>
					</a><a href="<?php echo BASE_URL;?>/tipoticket/listar">
						<div class='submenu_item'>Listar Tipos</div>
					</a><a href="<?php echo BASE_URL;?>/dashboard/dashtickets">
						<div class='submenu_item'>Dashboard Tickets</div>
					</a>
					<?php } ?>
					
				</div>
			</div>
		</div>
		
		<div class='botao menu_body' tabindex='<?php echo $Tabindex++;?>'
			submenu='menu<?php echo $Tabindex;?>'>
			<div class='menu_text'>Mudanças</div>
			<div class='submenu menu<?php echo $Tabindex;?>'>
				<div class='submenu_containt'>
					<a href="<?php echo BASE_URL;?>/mudanca/cadastrar">
						<div class='submenu_item submenu_primeiro'>Cadastrar Mudanças</div>
					</a> <a href="<?php echo BASE_URL;?>/mudanca/listar">
						<div class='submenu_item'>Listar Mudanças</div>
					</a>
					<?php if(PermissaoLib::checkAdmin()){ ?>
						<a href="<?php echo BASE_URL;?>/comite/gerenciar">
							<div class='submenu_item'>Gerenciar Comite</div>
						</a><a href="<?php echo BASE_URL;?>/migrar_ticket/listar">
							<div class='submenu_item'>Migrar Ticket</div>
						</a>
					<?php } ?>
					
				</div>
			</div>
		</div>
		
	</div>
</div>