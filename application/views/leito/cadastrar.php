<form class="form-signin" role="form">
	<h2 class="form-signin-heading">Cadastro de Leitos</h2>
	<div class="form-group">
		<label>Andar:</label> <select class="form-control" name='AndarId'
			id='AndarId' autofocus></select>
	</div>
	<div class="form-group">
		<label>Quarto:</label> <select class="form-control" name='quartoid'
			id='QuartoId'></select>
	</div>
	<div class="form-group">
		<label>Identificação:</label> <input type='text' class="form-control"
			placeholder="Identificação" maxlength='10' id='Identificacao'
			name='identificacao' />
	</div>
	<div class="form-group">
		<div class="retorno_ajax"></div>
	</div>
	<div class="form-group">
		<div class="linha_botoes">
			<button class="btn btn-sm btn btn-success btn-block botao_submit">Enviar</button>
			<button class="btn btn-sm btn btn-danger btn-block botao_reset">Limpar</button>
		</div>
	</div>
</form>
<script type="text/javascript">
var AndarSelecione = '<option value="">Andar: (Selecione)</option>';

var QuartoDependendo = '<option value="">Quarto: (Selecione o Andar)</option>';
var QuartoSelecione = '<option value="">Quarto: (Selecione)</option>';
 

$(document).ready(function(){

	// Reset
	$('.botao_reset').click(function(){
		$('#Identificacao').val('');
		carregaQuartos();
		$('#AndarId').val('');

		return false;
	});
	
	// Funçao para carregar os Andares
	carregaAndares();
	carregaQuartos();
	
	// Função para carregar os Quartos
	$('#AndarId').change(function(){
		if($(this).val() == ''){
			$('#QuartoId').html(QuartoSelecione);
		}
		else{
			var Andar 	= $(this).val();

			var Url		= '<?php echo BASE_URL;?>/quarto/getQuartos';
			var data 	= 'Andar='+Andar;

			$.blockUI({ message: '<h1>Carregando os quartos...</h1>' });

			$.ajax({
				type: "get",
				url: Url,
				data: data,
				dataType: 'json',		
				success: function(retorno){
					var Dados = "";

					if(retorno.success){
						var Quartos = retorno.Quartos;

						for(Reg in Quartos){
							Dados += '<option value="'+Quartos[Reg].QuartoId+'">'+Quartos[Reg].Quarto+'</option>';
						}

						$('#QuartoId').html(QuartoSelecione + Dados);
						$.unblockUI();
					}
					else{
						$('.retorno_ajax').html('Ocorreu um erro no servidor. Favor recarregar a página!');
						$.unblockUI();
					}
				},
				error: function(){
					$('.retorno_ajax').html('Ocorreu um erro no servidor. Favor recarregar a página!');
					
					setTimeout(
						function(){
							$.unblockUI();
						},
						4000
					);
				}
			});
		}
	});

	var validator = $(".form-signin").validate({
		debug: true,
		//onsubmit: false,
		rules: ( "add", {
			AndarId: {
				required: true
			},
			quartoid: {
				required: true
			},
			identificacao: {
				required: true,
				minlength: 3,
				maxlength: 10
			}
		}),
		messages: {
			AndarId:{
	            required: "Campo obrigatório"
	        },
	        quartoid: {
	            required: "Campo obrigatório",
			},
	        identificacao: {
	            required: "Campo obrigatório",
	            minlength: "Digite pelo menos 3 caracteres",
	            maxlength: "Digite no máximo 10 caracteres"
	        }	
		}
	});

	$(".form-signin").submit(function () {
	    if (validator.form()) {
	        submerterForm();
	    }

	    return false;
	});
});

// Função para o click de cadastro
function submerterForm(){

	// Declaração de variaveis
	var Identificacao 	= $("#Identificacao").val();
	var QuartoId		= $("#QuartoId option:selected").val();

	// Executa o POST usando metodo AJAX e retorando Json
	var Url				= '<?php echo BASE_URL;?>/leito/salvarCadastro';

	var data 			= 'QuartoId='+QuartoId+'&Identificacao='+Identificacao;

	$.blockUI({ message: '<h1>Salvando os dados...</h1>' });

	$.ajax({
		type: "POST",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			if(retorno.success){
				// Se retorno do php Deu OK
				//$('.retorno').html(retorno.msg);
	
				$.blockUI({ message: '<h3>'+retorno.msg+'</h3>' });

				// Efetuar o redirecionamento
				setTimeout(
					function(){
						window.location = "<?php echo BASE_URL;?>/leito/listar"
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
};

function carregaQuartos(){
	$('#QuartoId').html(QuartoDependendo);
}

function carregaAndares(){
	$.blockUI({ message: '<h1>Carregando os andares...</h1>' });
	
	var Url = '<?php echo BASE_URL;?>/quarto/getAndar';
	
	$.ajax({
		type: "get",
		url: Url,
		dataType: 'json',
		success: function(retorno){
			var Dados = "";
	
			if(retorno.success){
				var Andares = retorno.Andares;
	
				for(Reg in Andares){
					Dados += '<option value="'+Andares[Reg].Andar+'">'+Andares[Reg].Andar+'</option>';
				}
	
				$('#AndarId').html(AndarSelecione + Dados);
				$.unblockUI();
			}
			else{
				
				$('.retorno_ajax').html('Ocorreu um erro no servidor. Favor recarregar a página!');
				$.unblockUI();
			}
		},
		error: function(){
			$('.retorno_ajax').html('Ocorreu um erro no servidor. Favor recarregar a página!');
			$.unblockUI();
		}
	});
}
</script>