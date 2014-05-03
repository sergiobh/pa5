<div class='chamado_editar'>
	<form class="form-signin" role="form">
		<h2 class="form-signin-heading">Edição do Chamado</h2>
		<div class="form-group form_atendimento">
			<label>Permissão:</label><input type="text" id="Permissao"
				name="Permissao" readonly="readonly" class="form-control" />
		</div>
		<div class="form-group form_atendimento">
			<label>Nível do Atendimento:</label><input type="text" id="Nivel"
				name="Nivel" readonly="readonly" class="form-control" />
		</div>
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
				<button type="button"
					class="btn btn-sm btn btn btn-warning btn-block botao_transferir botao_reset">Transferir</button>
			</div>
		</div>
	</form>

	<?php $this->load->view ( 'chamado/historico' );?>

	<div id="ListaAtendimentos"></div>
	
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
			submeterForm( );
		}

		return false;
	} );

	$('#CategoriaId').change(function(){
		var CategoriaId = $(this).val();

		if(CategoriaId == ''){
			$('#TipoSolicitacaoId').html(TipoSolicitacaoDependendo);
		}
		else{
			carregaTipoSolicitacao(CategoriaId);
		}
	});

	$('.botao_transferir').click(function(){
		executarTransferencia();
	});
});

function inicializa(){
	executaPermissoes();

	/*
	/* Método está na view:
	/* chamado/observacao
	*/
	validaPermissaoObservacao();
	
	carregaStatus();
}
function submeterForm( ) {
	// Declaração de variaveis
	var Nivel = $('#Nivel').val();
	var StatusId = $("#StatusId option:selected").val();
	var TipoSolicitacaoId = $("#TipoSolicitacaoId option:selected").val();
	var PrioridadeId = $("#PrioridadeId option:selected").val();
	
	// Executa o POST usando metodo AJAX e retorando Json
	var Url				= '<?php echo BASE_URL;?>/chamado/salvarEdicao';

	var data 			= 'TicketId='+Ticket.TicketId+'&Nivel='+Nivel+'&StatusId='+StatusId+'&TipoSolicitacaoId='+TipoSolicitacaoId+'&PrioridadeId='+PrioridadeId;

	$.blockUI({ message: '<h3>Salvando os dados...</h3>' });

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
	var Url		= '<?php echo BASE_URL;?>/tipoticket/getTipoTicket';
	var data 	= 'TicketId='+Ticket.TicketId+'&StatusId='+Ticket.StatusId+'&CategoriaId='+CategoriaId;

	$.blockUI({ message: '<h3>Carregando os Tipos de Solicitação...</h3>' });

	$.ajax({
		type: "get",
		url: Url,
		data: data,
		dataType: 'json',		
		success: function(retorno){
			var Dados = "";

			if(retorno.success){
				var TipoTicket = retorno.TipoTicket;

				for(Reg in TipoTicket){
					Dados += '<option value="'+TipoTicket[Reg].TipoId+'">'+TipoTicket[Reg].Nome+'</option>';
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
	$.blockUI({ message: '<h3>Carregando os status...</h3>' });
	
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
	$.blockUI({ message: '<h3>Carregando as categorias...</h3>' });
	
	var Url = '<?php echo BASE_URL;?>/categoria/getCategorias';

	var data = 'TicketId='+Ticket.TicketId+'&StatusId='+Ticket.StatusId+'&Permissao='+Ticket.Permissao;
	
	$.ajax({
		type: "get",
		url: Url,
		data: data,
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
	$.blockUI({ message: '<h3>Carregando as prioridades...</h3>' });
	
	var Url = '<?php echo BASE_URL;?>/prioridade/getPrioridades';
	var data 	= 'Nivel='+Ticket.Nivel+'&PrioridadeId='+Ticket.PrioridadeId+'&Permissao='+Ticket.Permissao;
	
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
					buscaListaAtendimentos();
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
function buscaListaAtendimentos(){

	if(Ticket.Permissao != 'Solicitante'){
		buscaAtendimentos();
	}
	else if(Iniciando){
		populaTicket();
	}
}
function buscaAtendimentos(){
	$.blockUI({ message: '<h3>Carregando os dados dos Atendimentos...</h3>' });
	
	var Url = '<?php echo BASE_URL;?>/atendimentoticket/listar';
	var data 	= 'TicketId='+Ticket.TicketId;
	
	$.ajax({
		type: "get",
		url: Url,
		data: data,
		success: function(retorno){
			var Dados = "";

			if(retorno){
				$("#ListaAtendimentos").html(retorno);
			}
				
			if(Iniciando){
				populaTicket();
			}		
			$.unblockUI();
		},
		error: function(){
			exibeErroRecarregarPagina();
		}
	});
}
function buscaTicket(TicketId){
	$.blockUI({ message: '<h3>Carregando os dados do Chamado...</h3>' });
	
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

	if( ! (Ticket.TransferenciaNivel && Ticket.StatusId == 4)){
		$(".botao_transferir").hide();
	}
	
	/*
	/* Permissoes
	*/
	/*if(Ticket.Permissao == 'Solicitante'){
		$(".form_atendimento").hide();
	}*/
	/*else if(Ticket.Permissao == 'Atendente' || Ticket.Permissao == 'Setor'){

	}
	else if(Ticket.Permissao == 'Chefe'){

	} */
}
function populaTicket(){
	$("#Permissao").val(Ticket.Permissao);
	$("#Nivel").val(Ticket.Nivel);
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
function executarTransferencia(){
	console.log('Executar a transferência!!!');
}
</script>