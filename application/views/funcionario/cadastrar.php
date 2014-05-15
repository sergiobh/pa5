<div id="cadFuncionarios" class="float espacoPadding borda ">
	<form id="formFuncionarios" role="form"
		class="form-signin form-signin_func">
		
		<div class="form-group">
			<h3 class="glyphicon glyphicon-th-large">FUNCIONÁRIO</h3><br /><BR />
			<label>Nome:</label> <input type="text" id="inputNomeFunc" autofocus
				name="inputNomeFunc" class="form-control" titulo="Nome"
				placeholder="Nome" />
		</div>
		<div class="form-group">
			<label>CPF:</label> <input type="text" id="inputCpfFunc"
				name="inputCpfFunc" class="form-control" titulo="CPF"
				placeholder="CPF" maxlength="11" />
		</div>
		<div class="form-group">
			<label>Senha:</label> <input type="password" maxlength="8"
				id="inputsenhaFunc" name="inputsenhaFunc" class="form-control"
				titulo="Senha" placeholder="Senha" /><br />
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
	var validator = $(".form-signin_func").validate({
		debug: true,
		rules: ( "add", {
			inputNomeFunc: {
				required: true,
				minlength: 3,
				maxlength: 50
			},
			inputCpfFunc: {
				required: true,
				minlength: 11,
				maxlength: 11,
			},
			inputsenhaFunc: {
				required: true,
				minlength: 6,
				maxlength: 8
			}
		}),
		messages: {
			inputNomeFunc:{
	            required: "Campo obrigatório",
	            minlength: "Digite pelo menos 3 caracteres",
	            maxlength: "Digite no máximo 50 caracteres"
	        },
	        selectSetorFunc:{
	        	required: "Campo obrigatório",
	        },
	        selectInputFunc: {
	            required: "Campo obrigatório",
	            
			},
			inputCpfFunc:{
	            required: "Campo obrigatório",
	            minlength: "Digite pelo menos 11 caracteres",
	            maxlength: "Digite pelo menos 11 caracteres",
	        },
	        inputsenhaFunc:{
	            required: "Campo obrigatório",
	            minlength: "Digite pelo menos 6 caracteres",
	            maxlength: "Digite no máximo 8 caracteres"
	        }
		}
	});

	$( ".form-signin_func" ).submit( function( ) {
		if( validator.form( ) ) {
			submerterFormFunc();
		}

		return false;
	});
});

function submerterFormFunc() {
	// Declaração de variaveis
	var Nome 	= $("#inputNomeFunc").val();
	var Cpf		= $("#inputCpfFunc").val();
	var Senha = $("#inputsenhaFunc").val();
	
	// Executa o POST usando metodo AJAX e retorando Json
	var Url				= '<?php echo BASE_URL;?>/funcionario/salvarCadastro';

	var data 			= 'Nome='+Nome+'&Cpf='+Cpf+'&Senha='+Senha;

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
						window.location = "<?php echo BASE_URL;?>/funcionario/listar"
					},
					4000
				);
			}
			else{
				$('.retorno_ajax').html(retorno.msg);
				$.unblockUI();
			}
		},
		error: function(){
			$('.retorno_ajax').html('Ocorreu um erro no servidor. Tentar novamente!');
			$.unblockUI();
		}
	});
}
</script>