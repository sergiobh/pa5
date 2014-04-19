<div class='chamado_editar'>
	<form class="form-signin" role="form">
		<h2 class="form-signin-heading">Edição do Chamado</h2>
		<div class="form-group">
			<label>Status:</label><select id="StatusId" name="StatusId"
				class="form-control">
			</select>
		</div>
		<div class="form-group">
			<label>Categoria:</label> <select id="CategoriaId" name="CategoriaId"
				autofocus class="form-control">
			</select>
		</div>
		<div class="form-group">
			<label>Tipo de solicitação:</label> <select id="TipoSolicitacaoId"
				name="TipoSolicitacaoId" class="form-control">
			</select>
		</div>
		<div class="form-group">
			<label>Prioridade:</label><select id="PrioridadeId"
				name="PrioridadeId" class="form-control">
			</select>
		</div>
		<div class="form-group">
			<label>Data de Solicitação:</label><input id="DataSolicitacao"
				name="DataSolicitacao" type="text" class="form-control"
				readonly="readonly" />
		</div>
		<div class="form-group">
			<label>Data do Aceite:</label><input id="DataAceite"
				name="DataAceite" type="text" class="form-control"
				readonly="readonly" />
		</div>
		<div class="form-group">
			<label>Data da Previsão:</label><input id="DataPrevisao"
				name="DataPrevisao" type="text" class="form-control"
				readonly="readonly" />
		</div>
		<div class="form-group">
			<label>Data da Baixa:</label><input id="DataBaixa" name="DataBaixa"
				type="text" class="form-control" readonly="readonly" />
		</div>
		<div class="form-group">
			<label>Solicitante:</label><BR /> <input id="Solicitante"
				name="Solicitante" type="text" class="form-control"
				readonly="readonly" />
		</div>
		<div class="form-group">
			<div class="linha_botoes">
				<button class="btn btn-sm btn btn-success btn-block botao_submit">
					Enviar</button>
			</div>
		</div>
	</form>

	<?php $this->load->view ( 'chamado/historico' );?>

	<?php $this->load->view ( 'chamado/observacao' );?>

	<?php $this->load->view ( 'chamado/anexo' );?>
</div>
<script type="text/javascript">
var CategoriaSelecione = '<option value="">Categoria: (Selecione)</option>';

var TipoSolicitacaoDependendo = '<option value="">Tipo de Solicitação: (Selecione a Categoria)</option>';
var TipoSolicitacaoSelecione = '<option value="">Tipo de Solicitação: (Selecione)</option>';

var Ticket = '';
var Iniciando = true;

$( document ).ready( function( ) {	
	buscaTicket(<?php echo $TicketId;?>);

	var validator = $( ".form-signin" ).validate( {
		debug: true,
		//onsubmit: false,
		rules: ( "add", {
			selectCategoriaCadTicket: {
				required: true

			},
			tipoSolicitacao: {
				required: true
			},
		} ),
		messages: {
			selectCategoriaCadTicket: {
				required: "Campo obrigatório"

			},
			tipoSolicitacao: {
				required: "Campo obrigatório"

			}
		}
	} );
	
	$( ".form-signin" ).submit( function( ) {
		if( validator.form( ) ) {
			submerterForm( );
		}

		return false;
	} );

	$('#selectCategoriaCadTicket').change(function(){
		var CategoriaId = $(this).val();

		if(CategoriaId == ''){
			$('#tipoSolicitacao').html(TipoSolicitacaoDependendo);
		}
		else{
			carregaTipoSolicitacao(CategoriaId);
		}
	});
});

function inicializa(){
	executaPermissoes();
	
	carregaStatus();
}
function submerterForm( ) {
	// Declaração de variaveis
	var StatusId = $("#StatusId option:selected").val();
	var TipoSolicitacaoId = $("#TipoSolicitacaoId option:selected").val();
	var PrioridadeId = $("#PrioridadeId option:selected").val();
	
	// Executa o POST usando metodo AJAX e retorando Json
	var Url				= '<?php echo BASE_URL;?>/chamado/salvarEdicao';

	var data 			= 'TicketId='+Ticket.TicketId+'&StatusId='+StatusId+'&TipoSolicitacaoId='+TipoSolicitacaoId+'&PrioridadeId='+PrioridadeId;

	$.blockUI({ message: '<h2>Salvando os dados...</h2>' });

	$.ajax({
		type: "POST",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			if(retorno.success){
				$.blockUI({ message: '<h3>'+retorno.msg+'</h3>' });

				// Efetuar o redirecionamento
				setTimeout(
					function(){
						window.location = "<?php echo BASE_URL;?>/chamado/listar"
					},
					4000
				);
			}
			else{
				$.blockUI({ message: '<h3>'+retorno.msg+'</h3>' });
				setTimeout(
						function(){
							$.unblockUI();
						},
						3000
					);
			}
		},
		error: function(){
			exibeErroRecarregarPagina;
		}
	});

	return false;
}

function limpaTipoSolicitacao(){
	$('#tipoSolicitacao').html(TipoSolicitacaoDependendo);
}

// Função para carregar os Tipo de Solicitação
function carregaTipoSolicitacao(CategoriaId){
	var Url		= '<?php echo BASE_URL;?>/tiposolicitacao/getTipoSolicitacao';
	var data 	= 'CategoriaId='+CategoriaId;

	$.blockUI({ message: '<h2>Carregando os Tipos de Solicitação...</h2>' });

	$.ajax({
		type: "get",
		url: Url,
		data: data,
		dataType: 'json',		
		success: function(retorno){
			var Dados = "";

			if(retorno.success){
				var TipoSolicitacao = retorno.TipoSolicitacao;

				for(Reg in TipoSolicitacao){
					Dados += '<option value="'+TipoSolicitacao[Reg].TipoId+'">'+TipoSolicitacao[Reg].Nome+'</option>';
				}

				$('#TipoSolicitacaoId').html(TipoSolicitacaoSelecione + Dados);

				if(Iniciando){
					carregaPrioridade();
				}

				$.unblockUI();
			}
			else{
				exibeErroRecarregarPagina;
			}
		},
		error: function(){
			exibeErroRecarregarPagina;
		}
	});
}
function carregaStatus(){
	$.blockUI({ message: '<h2>Carregando os status...</h2>' });
	
	var Url = '<?php echo BASE_URL;?>/status/getStatus';
	var data 	= 'StatusId='+Ticket.StatusId+'&Permissao='+Ticket.Permissao+'&Nivel='+Ticket.Nivel;
	
	$.ajax({
		type: "get",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			var Dados = "";
	
			if(retorno.success){
				var Status = retorno.Status;
	
				for(Reg in Status){
					Dados += '<option value="'+Status[Reg].StatusId+'">'+Status[Reg].Nome+'</option>';
				}
	
				$('#StatusId').html(Dados);

				if(Iniciando){
					carregaCategorias();
				}
				
				$.unblockUI();
			}
			else{
				exibeErroRecarregarPagina;
			}
		},
		error: function(){
			exibeErroRecarregarPagina;
		}
	});
}
function carregaCategorias(){
	$.blockUI({ message: '<h2>Carregando as categorias...</h2>' });
	
	var Url = '<?php echo BASE_URL;?>/categoria/getCategorias';
	
	$.ajax({
		type: "get",
		url: Url,
		dataType: 'json',
		success: function(retorno){
			var Dados = "";
	
			if(retorno.success){
				var Categorias = retorno.Categorias;
	
				for(Reg in Categorias){
					Dados += '<option value="'+Categorias[Reg].CategoriaId+'">'+Categorias[Reg].Nome+'</option>';
				}
	
				$('#CategoriaId').html(CategoriaSelecione + Dados);

				if(Iniciando){
					carregaTipoSolicitacao(Ticket.CategoriaId);
				}
				
				$.unblockUI();
			}
			else{
				exibeErroRecarregarPagina;
			}
		},
		error: function(){
			exibeErroRecarregarPagina;
		}
	});
}
function carregaPrioridade(){
	//PrioridadeId
	$.blockUI({ message: '<h2>Carregando as prioridades...</h2>' });
	
	var Url = '<?php echo BASE_URL;?>/prioridade/getPrioridades';
	var data 	= 'PrioridadeId='+Ticket.PrioridadeId+'&Permissao='+Ticket.Permissao;
	
	$.ajax({
		type: "get",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			var Dados = "";
	
			if(retorno.success){
				var Prioridades = retorno.Prioridades;

				for(Reg in Prioridades){
					Dados += '<option value="'+Prioridades[Reg].PrioridadeId+'">'+Prioridades[Reg].Nome+'</option>';
				}
	
				$('#PrioridadeId').html(Dados);

				if(Iniciando){
					populaTicket();
				}
				
				$.unblockUI();
			}
			else{
				exibeErroRecarregarPagina;
			}
		},
		error: function(){
			exibeErroRecarregarPagina;
		}
	});
}
function buscaTicket(TicketId){
	$.blockUI({ message: '<h2>Carregando os dados do Chamado...</h2>' });
	
	var Url = '<?php echo BASE_URL;?>/chamado/carregaEditar';
	var data 	= 'TicketId='+TicketId;
	
	$.ajax({
		type: "get",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			var Dados = "";
	
			if(retorno.success){

				if(! retorno.Ticket){
					exibeErroRecarregarPagina('Usuário sem permissão para acesso!');

					setTimeout(
							function(){
								 window.location = "<?php echo BASE_URL;?>/chamado/listar";
							},
							3000
						);
					return false;
				}
				
				Ticket = retorno.Ticket;
				
				$.unblockUI();
				inicializa();
			}
			else{
				exibeErroRecarregarPagina;
			}
		},
		error: function(){
			exibeErroRecarregarPagina();
		}
	});
}
function exibeErroRecarregarPagina(Msg){
	if(Msg == ''){
		Msg = 'Ocorreu um erro no servidor. Favor recarregar a página!';
	}
	
	$.blockUI({ message: '<h3>'+Msg+'</h3>' });
	setTimeout(
			function(){
				$.unblockUI();
			},
			3000
		);
}
function executaPermissoes(){
	if(! Ticket.Permissao){
		exibeErroRecarregarPagina();
		return false;
	}

	/*
	/* Permissoes
	*/
	/*if(Ticket.Permissao == 'Chefe'){

	}
	else if(Ticket.Permissao == 'Atendente' || Ticket.Permissao == 'Setor'){

	}
	else if(Ticket.Permissao == 'Solicitante'){
		
	}*/
}
function populaTicket(){
	$('#CategoriaId option[value='+Ticket.CategoriaId+']').attr('selected','selected');
	$('#TipoSolicitacaoId option[value='+Ticket.TipoId+']').attr('selected','selected');
	$("#Solicitante").val(Ticket.Solicitente);
	$("#Atendente").val(Ticket.Atendente);
	$("#StatusId").val(Ticket.StatusId);
	$('#PrioridadeId option[value='+Ticket.PrioridadeId+']').attr('selected','selected');
	$("#SetorId").val(Ticket.SetorId);
	$("#DataAceite").val(Ticket.DH_Aceite);
	$("#DataSolicitacao").val(Ticket.DH_Solicitacao);
	$("#DataPrevisao").val(Ticket.DH_Previsao);
	$("#DataBaixa").val(Ticket.DH_Baixa);

	Iniciando = false;
}
</script>