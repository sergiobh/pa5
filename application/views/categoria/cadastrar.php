<div id="cadCategoria" class="float espacoPadding">
	<form id="formCategoria" role="form" class="form-signin">
		<h2 class="form-signin-heading">&nbsp;Cadastrar Categoria</h2>
		<BR />
		<div class="form-group">

			<label>Nome:</label><input type="text" id="inputCadCategoria"
				name="inputCadCategoria" class="form-control" maxlength="50"
				placeholder="Descrição da Categoria" />
		</div>
		<div class="form-group">
			<div class="linha_botoes">
				<button class="btn btn-sm btn btn-success btn-block botao_submit">
					Enviar</button>
				<button class="btn btn-sm btn btn-danger btn-block botao_reset"
					type="reset">Limpar</button>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
$(document).ready(function(){
	var validator = $("#formCategoria").validate({
		debug: true,
		rules: ( "add", {
			inputCadCategoria: {
				required: true,
				minlength: 3,
				maxlength: 50
			}
		}),
		messages: {
			inputCadCategoria:{
	            required: "Campo obrigatório",
	            minlength: "Digite pelo menos 3 caracteres",
	            maxlength: "Digite no máximo 50 caracteres"
	        }
		}
	});
	
	$( "#formCategoria" ).submit( function() {
		if( validator.form() ) {
			submeterFormCategoria();
		}

		return false;
	});
});

function submeterFormCategoria(){
	$.blockUI({ message: '<h3>Salvando os dados...</h3>' });

	var Nome = $("#inputCadCategoria").val();
	
	var Url = '<?php echo BASE_URL;?>/categoria/salvarCadastro';
	var data = 'Nome='+Nome; 
	
	$.ajax({
		type: "post",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			$.blockUI({ message: '<h3>'+ retorno.msg +'</h3>' });
			
			setTimeout(
					function(){
						if(retorno.success){
							window.location = "<?php echo BASE_URL;?>/categoria/listar"
						}
						else{
							$.unblockUI();
						}
					},
					2000
				);
		},
		error: function(){
			$.blockUI({ message: '<h3>Ocorreu um erro no servidor. Favor recarregar a página!</h3>' });
			
			setTimeout(
				function(){
					window.location = "<?php echo BASE_URL;?>/categoria/listar"
				},
				3000
			);
		}
	});
}
</script>