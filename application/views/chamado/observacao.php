<div class='chamado_editar_observacao'>
	<form class="form-signin_format form_observacao" role="form">
		<h2 class="form-signin-heading">Observações do Chamado</h2>
		<div class="form-group">
			<label>Adicionar Observação:</label>
			<textarea id="Descricao" name="Descricao" class="form-control"></textarea>
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
$( document ).ready( function( ) {
	var validator = $( ".form_observacao" ).validate( {
		debug: true,
		rules: ( "add", {
			Descricao: {
				required: true,
				minlength: 5
			}
		}),
		messages: {
			Descricao: {
				required: "Campo obrigatório",
				minlength: "Digite pelo menos 5 caracteres"

			}
		}
	} );

	$( ".form_observacao" ).submit( function( ) {
		if( validator.form( ) ) {
			submerterFormObservacao( );
		}

		return false;
	} );	
});

function submerterFormObservacao(){
	// Executa o POST usando metodo AJAX e retorando Json
	var Url				= '<?php echo BASE_URL;?>/historico/salvarObservacao';

	var Descricao = $("#Descricao").val();
	
	var data 			= 'TicketId='+Ticket.TicketId+'&Descricao='+Descricao;
	
	$.blockUI({ message: '<h2>Salvando os dados...</h2>' });

	$.ajax({
		type: "POST",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			if(retorno.success){
				$.blockUI({ message: '<h3>'+retorno.msg+'</h3>' });

				limparCamposObservacao();
				
				// Efetuar o redirecionamento
				setTimeout(
					function(){
						listarHistorico();
					},
					2000
				);
			}
			else{
				$.blockUI({ message: '<h3>'+retorno.msg+'</h3>' });
				setTimeout(
						function(){
							$.unblockUI();
						},
						2000
					);
			}
		},
		error: function(){
			exibeErroRecarregarPagina();
		}
	});

	return false;
}

function limparCamposObservacao(){
	$("#Descricao").val("");
}
</script>