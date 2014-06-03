<div class='titulo_page'>Cadastro de Ocupação</div>
<div class='ocupacao_cadastrar'>
	<form class='formulario form-signin'>
		<div class="form-group">
			<label>Paciente:</label> <select class="form-control"
				name="PacienteId" id='PacienteId' autofocus>
				<option value="">--- Selecione ---</option>
					<?php if($Pacientes){ ?>
						<?php foreach($Pacientes as $Registro) { ?>
							<option value="<?php echo $Registro->PacienteId;?>"><?php echo $Registro->Paciente;?></option>';
						<?php } ?>
					<?php } ?>
			</select>
		</div>
		<div class="form-group">
			<label>Andar:</label> <select class="form-control" name="AndarId"
				id='AndarId'>
			</select>
		</div>
		<div class="form-group">
			<label>Quarto:</label> <select class="form-control" name="QuartoId"
				id='QuartoId'>
			</select>
		</div>
		<div class="form-group">
			<label>Leito:</label> <select class="form-control" name="LeitoId"
				id='LeitoId'>
			</select>
		</div>
		<div class="form-group">
			<div class="linha_botoes">
				<button class="btn btn-sm btn btn-success btn-block botao_submit">Enviar</button>
				<button class="btn btn-sm btn btn-danger btn-block botao_reset"
					type="reset">Limpar</button>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
var validator = '';

var OptPaciente	= '<option value="">--- Selecione o paciente ---</option>';
var OptAndar 		= '<option value="">--- Selecione o andar ---</option>';
var OptQuarto 		= '<option value="">--- Selecione o quarto ---</option>';

var OptNaoSelecionado	= '<option value="">--- Selecione ---</option>';

$(document).ready(function(){

	// Função de validação
	validator = validate();

	// Preenche os options vazios
	$("#AndarId").html(OptPaciente);
	$("#QuartoId").html(OptPaciente);
	$("#LeitoId").html(OptPaciente);
	
	// Função para carregar os Andares
	$('#PacienteId').change(function(){
		getAndar($(this).val());
	});

	// Função para carregar os Quartos
	$('#AndarId').change(function(){
		getQuarto($(this).val());
	});

	// Função para carregar os Leitos
	$('#QuartoId').change(function(){
		getLeito($(this).val());
	});

	// Função para o click de cadastro
	$(".form-signin").submit( function(){
		if( validator.form() ){
			salvarOcupacao();
		}
		return false;
	});
});

function validate(){
	return $(".form-signin").validate({
		debug: true,
		rules: ( "add", {
			PacienteId: {
				required: true
			},
			AndarId: {
				required: true
			},
			QuartoId: {
				required: true
			},
			LeitoId: {
				required: true
			}
		}),
		messages: {
			PacienteId: {
	            required: "Campo obrigatório"
			},
			AndarId: {
	            required: "Campo obrigatório"
			},
			QuartoId: {
	            required: "Campo obrigatório"
			},
			LeitoId: {
	            required: "Campo obrigatório"
			}
		}
	});
}

function getAndar(PacienteId){
	$('#QuartoId').html(OptAndar);
	$('#LeitoId').html(OptAndar);

	if(PacienteId == ''){
		$('#AndarId').html(OptPaciente);
		$('#QuartoId').html(OptPaciente);
		$('#LeitoId').html(OptPaciente);
	}
	else{
		var Url		= '<?php echo BASE_URL;?>/quarto/getAndarOcupacao';
		var data 	= 'PacienteId='+PacienteId
						+'&Ocupacao=1'

		$.blockUI({ message: '<h3>Carregando os andares...</h3>' });

		$.ajax({
			type: "GET",
			url: Url,
			data: data,
			dataType: 'json',				
			success: function(retorno){
				var Dados = "";

				if(retorno.success){
					var Andares = retorno.Andares;

					for(Reg in Andares){
						Dados += '<option value="'+Andares[Reg].Andar+'">'+Andares[Reg].Andar+'</option>';
					}

					$('#AndarId').html(OptNaoSelecionado + Dados);
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
}

function getQuarto(Andar){
	$('#LeitoId').html(OptQuarto);

	if(Andar == ''){
		$('#QuartoId').html(OptAndar);
		$('#LeitoId').html(OptAndar);
	}
	else{
		var PacienteId = $('#PacienteId').val();

		var Url		= '<?php echo BASE_URL;?>/quarto/getQuartosOcupacao';
		var data 	= 'Andar='+Andar
						+'&Ocupacao=1'
						+'&PacienteId='+PacienteId;

		$.blockUI({ message: '<h3>Carregando os quartos...</h3>' });

		$.ajax({
			type: "GET",
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

					$('#QuartoId').html(OptNaoSelecionado + Dados);
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
}

function getLeito(QuartoId){
	if(QuartoId == ''){
		$('#LeitoId').html(OptQuarto);
	}
	else{
		var PacienteId = $('#PacienteId').val();


		var Url		= '<?php echo BASE_URL;?>/leito/getLeitosOcupacao';
		var data 	= 'QuartoId='+QuartoId
						+'&Ocupacao=1'
						+'&PacienteId='+PacienteId;

		$.blockUI({ message: '<h3>Carregando os leitos...</h3>' });

		$.ajax({
			type: "GET",
			url: Url,
			data: data,		
			dataType: 'json',			
			success: function(retorno){
				
				if(retorno.success){
					var Opcoes = '';

					for (var i = 0; i < retorno.leitos.length; i++) {
						Opcoes  += "<option value="+retorno.leitos[i].LeitoId+">"+retorno.leitos[i].Leito+"</option>";
					}

					$('#LeitoId').html(OptNaoSelecionado + Opcoes);
					$.unblockUI();
				}
				else{
					$('.retorno_ajax').html(retorno.msg);
					$.unblockUI();
				}
			},
			error: function(){
				$('.retorno_ajax').html('Ocorreu um erro no servidor. Favor recarregar a página!');
				$.unblockUI();
			}
		});
	}
}

function salvarOcupacao(){
	// Declaração de variaveis
	var PacienteId 		= $("#PacienteId option:selected").val();
	var LeitoId			= $("#LeitoId option:selected").val();

	// Executa o POST usando metodo AJAX e retorando Json
	var Url				= '<?php echo BASE_URL;?>/Ocupacao/salvarCadastro';

	var data 			= 'LeitoId='+LeitoId+'&PacienteId='+PacienteId;

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
						window.location = "<?php echo BASE_URL;?>/paciente/painel"
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
}
</script>