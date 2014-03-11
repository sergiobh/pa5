<form class="form-signin" role="form">
	<h2 class="form-signin-heading">Cadastro de Quartos</h2>
	<div class="form-group">
		<input type='text' class="form-control" placeholder="Andar" required autofocus maxlength='10' id='Andar' name='Andar' />
	</div>
	<div class="form-group">
		<input type='text' class="form-control" placeholder="Identificação" required autofocus maxlength='10' id='identificacao' name='Identificação' />
	</div>
	<div class="linha_botoes">
		<button class="btn btn-sm btn btn-success btn-block botao_submit">Enviar</button>
		<button class="btn btn-sm btn btn-danger btn-block botao_reset" type="reset">Limpar</button>
	</div>
</form>
<script type="text/javascript">
		$(document).ready(function(){
		
			// Função para o click de cadastro
			$('.botao_submit').click(function(){
				// Declaração de variaveis
				var Andar 			= $("#Andar").val();
				var Identificacao 	= $("#Identificacao").val();

				// Executa o POST usando metodo AJAX e retorando Json
				var Url				= '<?php echo BASE_URL;?>/quarto/salvarCadastro';

				var data 			= 'Andar='+Andar+'&Identificacao='+Identificacao;

				$.blockUI({ message: '<h1>Salvando os dados...</h1>' });

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
									window.location = "<?php echo BASE_URL;?>/quarto/listar"
								},
								4000
							);
						}
						else{
							// Se php retornou erro irá salvar o retorno da div "retorno"
							$('.retorno_ajax').html(retorno.msg);
							$.unblockUI();
						}
					},
					error: function(){
						$('.retorno_ajax').html('Ocorreu um erro no servidor. Tentar novamente!');
						$.unblockUI();
					}
				});

				return false;
			});	
		});
	</script>