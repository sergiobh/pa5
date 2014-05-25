<div class='mudanca_editar'>
	<form class="form-signin" role="form">
		<h2 class="form-signin-heading">Edição da Mudança</h2>
		<div class="form-group form_atendimento">
			<label>Nome:</label><input type="text" id="Nome" name="Nome"
				readonly="readonly" class="form-control" />
		</div>
		<div class="form-group">
			<label>Descrição da Mudança:</label>
			<textarea id="descricaoMudanca" name="descricaoMudanca" type="text"
				value="" class="form-control" placeholder="Descrição da Mudança"></textarea>
		</div>
		<div class="form-group">
			<label>Prioridade:</label> <select id="Prioridade"
				name="Prioridade" class="form-control">
			</select>
		</div>
		<div class="form-group">
			<label>Autorização:</label> <select id="Autorizacao"
				name="Autorização" class="form-control">
			</select>
		</div>
		<div class="form-group">
			<label>Avaliação:</label> <select id="Avaliacao" name="Avaliacao"
				class="form-control">
			</select>
		</div>
		<div class="form-group form_atendimento">
			<label>Data Solicitacao:</label><input type="text"
				id="DH_Solicitacao" name="DH_Solicitacao" readonly="readonly"
				class="form-control" />
		</div>
		<div class="form-group form_atendimento">
			<label>Solicitante:</label><input type="text" id="Solicitante"
				name="Solicitante" readonly="readonly" class="form-control" />
		</div>
		<div class="form-group">
			<div class="linha_botoes">
				<button class="btn btn-sm btn btn-success btn-block botao_submit">
					Enviar</button>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
var PrioridadeSelecione = '<option value="">Prioridade: (Selecione)</option>';
var AvaliacaoSelecione = '<option value="">Avaliação: (Selecione)</option>';
var AutorizacaoSelecione = '<option value="">Autorização: (Selecione)</option>';


var Mudanca = '';
var Iniciando = true;

$( document ).ready( function( ) {	
	buscaMudanca(<?php echo $MudancaId;?>);

	var validator = $( ".form-signin" ).validate( {
		debug: true,
		rules: ( "add", {
			Nome: {
				required: true,
				minlength: 5
			},
			descricaoMudanca: {
				required: true,
				minlength: 5
			},
			Prioridade: {
				required: true
			},
			Autorizacao: {
				required: true
			}, 
			Avaliacao: {
				required: true
			} 
		} ),
		messages: {
			Nome: {
				required: "Campo obrigatório",
				minlength: "Digite pelo menos 5 caracteres"
			},
			descricaoMudanca: {
				required: "Campo obrigatório",
				minlength: "Digite pelo menos 5 caracteres"
			},
			Prioridade: {
				required: "Campo obrigatório"
			},
			Autorizacao: {
				required: "Campo obrigatório"
			},
			Avaliacao: {
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
});

function inicializa(){
	
	populaMudanca();
}

function submeterForm( ) {
	// Declaração de variaveis
	var Nivel = $('#Nivel').val();
	var StatusId = $("#StatusId option:selected").val();
	var TipoSolicitacaoId = $("#TipoSolicitacaoId option:selected").val();
	var PrioridadeId = $("#PrioridadeId option:selected").val();
	
	// Executa o POST usando metodo AJAX e retorando Json
	var Url				= '<?php echo BASE_URL;?>/chamado/salvarEdicao';

	var data 			= 'MudancaId='+Mudanca.MudancaId+'&Nivel='+Nivel+'&StatusId='+StatusId+'&TipoSolicitacaoId='+TipoSolicitacaoId+'&PrioridadeId='+PrioridadeId;

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

function carregaPrioridade(){
	var Url		= '<?php echo BASE_URL;?>/prioridade/getPrioridades';
	var data 	= 'RestringePlanejada=1';

	$.blockUI({ message: '<h3>Carregando os Tipos de Solicitação...</h3>' });

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

				$('#Prioridade').html(Dados);

				carregaAutorizacao();
				
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

function carregaAutorizacao(){
	var Url		= '<?php echo BASE_URL;?>/mudanca/getAutorizacoes';

	$.blockUI({ message: '<h3>Carregando os Tipos de Solicitação...</h3>' });

	$.ajax({
		type: "get",
		url: Url,
		dataType: 'json',		
		success: function(retorno){
			var Dados = "";

			if(retorno.success){
				var Autorizacoes = retorno.Autorizacoes;

				for(Reg in Autorizacoes){
					Dados += '<option value="'+Autorizacoes[Reg].AutorizacaoId+'">'+Autorizacoes[Reg].Nome+'</option>';
				}

				$('#Autorizacao').html(Dados);

				carregaAvaliacao();
				
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

function carregaAvaliacao(){
	$.blockUI({ message: '<h3>Carregando as avaliações...</h3>' });
	
	var Url = '<?php echo BASE_URL;?>/mudanca/getAvaliacoes';
	var data 	= 'AutorizacaoId='+Mudanca.AutorizacaoDesenvolvimento;
	
	$.ajax({
		type: "get",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			var Dados = "";
	
			if(retorno.success){
				var Avaliacoes = retorno.Avaliacoes;
	
				for(Reg in Status){
					Dados += '<option value="'+Avaliacoes[Reg].AvaliacaoId+'">'+Avaliacoes[Reg].Nome+'</option>';
				}
	
				$('#Avaliacao').html(Dados);

				$.unblockUI();
			}
			else{
				// Limpa a div pai da avaliação
				$('#Avaliacao').parent().html('');
			}

			populaMudanca();
		},
		error: function(){
			exibeErroRecarregarPagina;
		}
	});
}

function buscaMudanca(MudancaId){
	$.blockUI({ message: '<h3>Carregando os dados do Chamado...</h3>' });
	
	var Url = '<?php echo BASE_URL;?>/mudanca/carregaEditar';
	var data 	= 'MudancaId='+MudancaId;
	
	$.ajax({
		type: "get",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			if(retorno.success){
				if(! retorno.Mudanca){
					exibeErroRecarregarPagina();

					setTimeout(
							function(){
								 window.location = "<?php echo BASE_URL;?>/mudanca/listar";
							},
							3000
						);
					return false;
				}
				
				Mudanca = retorno.Mudanca;
				
				$.unblockUI();

				carregaPrioridade();
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

function populaMudanca(){
	$("#Nome").val(Mudanca.Nome);
	$("#descricaoMudanca").html(Mudanca.Descricao);
	$('#PrioridadeId option[value='+Mudanca.PrioridadeId+']').attr('selected','selected');
	$('#Autorizacao option[value='+Mudanca.AutorizacaoDesenvolvimento+']').attr('selected','selected');	
	$('#Avaliacao option[value='+Mudanca.Avaliacao+']').attr('selected','selected');
	$("#DH_Solicitacao").val(Mudanca.DH_Solicitacao);
	$("#Solicitante").val(Mudanca.Usuario);
	
	Iniciando = false;
}
</script>