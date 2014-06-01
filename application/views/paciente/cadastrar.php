<?php
if (! is_numeric ( $Cpf )) {
	header ( 'Location: ' . BASE_URL . '/paciente/consultar' );
	exit ();
}
?>
<div class='titulo_page'>Cadastro de Pacientes</div>
<div class='painel_pacientes'>
	<form class='formulario form-signin'>
		<div class="form-group">
			<label>Nome:</label> <input class="form-control" id='nome'
				type='text' maxlength='100' name='nome' autofocus />
		</div>
		<div class="form-group">
			<label>Plano:</label> <select class="form-control" name="tipo"
				id='tipo'>
				<option value="">--- Selecione ---</option>
				<option value="1">Apartamento</option>
				<option value="2">Enfermária</option>
			</select>
		</div>
		<div class="form-group">
			<label>Sexo:</label> <select class="form-control" name="sexo"
				id='sexo'>
				<option value="">--- Selecione ---</option>
				<option value="1">Masculino</option>
				<option value="2">Feminino</option>
			</select>
		</div>
		<div class="form-group">
			<label>CPF:</label> <input class="form-control" type='text'
				maxlength='11' name='cpf' id='cpf' value='<?php echo $Cpf;?>'
				readonly="readonly" />
		</div>
		<div class="form-group">
			<label>Logradouro:</label> <input class="form-control" type='text'
				maxlength='50' name='logradouro' id='logradouro' />
		</div>
		<div class="form-group">
			<label>Número:</label> <input class="form-control" type='text'
				maxlength='14' name='numero' id='numero' />
		</div>
		<div class="form-group">
			<label>Complemento:</label> <input class="form-control" type='text'
				maxlength='10' name='complemento' id='complemento' />
		</div>
		<div class="form-group">
			<label>Bairro:</label> <input class="form-control" type='text'
				maxlength='40' name='bairro' id='bairro' />
		</div>
		<div class="form-group">
			<label>Cidade:</label> <input class="form-control" type='text'
				maxlength='40' name='cidade' id='cidade' />
		</div>
		<div class="form-group">
			<label>Estado:</label> <input class="form-control" type='text'
				maxlength='2' name='estado' id='estado' />
		</div>
		<div class="form-group">
			<label>Contatos</label> <input class='add_telefone' type='button'
				name='adicionaTelefone' value='Adicionar' /> <input type="hidden"
				name="QtdTelefone" value="0" id="QtdTelefone">
		</div>
		<div class="form-group">
			<div class="add_contatos"></div>
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
var Telefones = [];

function validate(){
	return $(".form-signin").validate({
		debug: true,
		rules: ( "add", {
			nome: {
				required: true,
				minlength: 3,
				maxlength: 100
			},
			tipo: {
				required: true
			},
			sexo: {
				required: true
			},
			cpf: {
				required: true,
				minlength: 14,
				maxlength: 14
			},
			logradouro: {
				required: true,
				minlength: 3,
				maxlength: 50
			},
			bairro: {
				required: true,
				minlength: 3,
				maxlength: 40
			},
			cidade: {
				required: true,
				minlength: 3,
				maxlength: 40
			},
			estado: {
				required: true
			}
		}),
		messages: {
			nome: {
	            required: "Campo obrigatório",
	            minlength: "Digite pelo menos 3 caracteres",
	            maxlength: "Digite no máximo 100 caracteres"
			},
			tipo: {
	            required: "Campo obrigatório"
			},
			sexo: {
	            required: "Campo obrigatório"
			},
			cpf: {
	            required: "Campo obrigatório",
	            minlength: "Digite cpf válido",
	            maxlength: "Digite cpf válido"
			},
			logradouro: {
	            required: "Campo obrigatório",
	            minlength: "Digite pelo menos 3 caracteres",
	            maxlength: "Digite no máximo 50 caracteres"
			},
			bairro: {
	            required: "Campo obrigatório",
	            minlength: "Digite pelo menos 3 caracteres",
	            maxlength: "Digite no máximo 40 caracteres"
			},
			cidade: {
	            required: "Campo obrigatório",
	            minlength: "Digite pelo menos 3 caracteres",
	            maxlength: "Digite no máximo 40 caracteres"
			},
			estado: {
	            required: "Campo obrigatório"
			}
		}
	});
}

function AddTelefone(){
	var QtdTelefone = $("#QtdTelefone").val();
	
	QtdTelefone++;

	$("#QtdTelefone").val(QtdTelefone);

	// Adiciona o Telefone no array
	Telefones.push(QtdTelefone);

	var AddTelefone = "<div class='linha_telefone linha_telefone"+QtdTelefone+"'><div class='columnRemoveTelefone'><input class='del_telefone' onclick='DelTelefone("+QtdTelefone+")' name='DelTelefone"+QtdTelefone+"' type='button' value='Remover' /></div><div class='columnTitleTelefone'>Telefone"+QtdTelefone+":</div><div class='dadosTelefone'><input class='form-control telefone' type='text' maxlength='13' name='telefone"+QtdTelefone+"' id='telefone"+QtdTelefone+"' /></div>";
	
	$(".add_contatos").append(AddTelefone);

	$('.telefone').mask("(99)9999-9999");

	adicionaValidacao('telefone'+QtdTelefone);
}

function adicionaValidacao(campo){
    $('[name*="'+campo+'"]').each(function () {
        $(this).rules('add', {
            required: true,
			minlength: 13,
			maxlength: 13,
            messages: {
            	required: "Campo obrigatório",
        	    minlength: "Telefone inválido",
        	    maxlength: "Telefone inválido"
            }
        });
    });
}

function DelTelefone(Telefone){
	var Qtd = $(".linha_telefone").size();

	if(Qtd > 1){
		// Pego a posição do Telefone passado para deletar
		var Posicao = Telefones.indexOf(Telefone);

		// Removo a posição passada do array
		Telefones.splice(Posicao, 1);

		$(".linha_telefone"+Telefone).remove();
	}
	else{
		$('.retorno_ajax').html('Não foi possível remover, campo telefone obrigatório!');

		setTimeout(
			function(){
				$('.retorno_ajax').html('');
			},
			4000
		);

	}			
}

function salvarPaciente(){
	// Declaração de variaveis
	var Nome 			= $("#nome").val();
	var Tipo 			= $("#tipo").val();
	var Sexo 			= $("#sexo").val();
	var Cpf 			= $("#cpf").val();

	Cpf 				= Cpf.replace('.','');
	Cpf 				= Cpf.replace('.','');
	Cpf 				= Cpf.replace('-','');

	var Logradouro		= $("#logradouro").val();
	var Numero  		= $("#numero").val();
	var Complemento 	= $("#complemento").val();
	var Bairro  		= $("#bairro").val();
	var Cidade  		= $("#cidade").val();
	var Estado  		= $("#estado").val();
	var QtdTelefone 	= $("#QtdTelefone").val();
	// criar variavel para enviar o post de telefone
	var Telefone  		= [];

	// Preenche o array de telefones
	for(var i = 0; i < Telefones.length; i++){
		Telefone.push($('#telefone'+Telefones[i]).val());
	}


	// Executa o POST usando metodo AJAX e retorando Json
	var Url				= '<?php echo BASE_URL;?>/paciente/salvarCadastro';

	var data 			= 'Nome='+Nome
							+'&Tipo='+Tipo
							+'&Sexo='+Sexo
							+'&Cpf='+Cpf
							+'&Logradouro='+Logradouro
							+'&Numero='+Numero
							+'&Complemento='+Complemento
							+'&Bairro='+Bairro
							+'&Cidade='+Cidade
							+'&Estado='+Estado
							+'&Telefone='+Telefone
							+'&QtdTelefone='+QtdTelefone;

	$.blockUI({ message: '<h3>Salvando os dados...</h3>' });

	$.ajax({
		type: "POST",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			if(retorno.success){
	
				$.blockUI({ message: '<h3>'+retorno.msg+'</h3>' });

				var PacienteId = retorno.PacienteId;

				// Efetuar o redirecionamento
				setTimeout(
					function(){
						window.location = "<?php echo BASE_URL;?>/ocupacao/cadastrar/"+PacienteId
					},
					4000
				);
			}
			else{
				// Se php retornou erro irá salvar o retorno da div "retorno"
				$('.retorno_ajax').html(retorno.msg);

				// Efetuar o redirecionamento
				setTimeout(
					function(){
						window.location = "<?php echo BASE_URL;?>/paciente/consultar"
					},
					4000
				);
			}
		},
		error: function(){
			$('.retorno_ajax').html('Ocorreu um erro no servidor. Tentar novamente!');
			$.unblockUI();
		}
	});
}

$(document).ready(function(){

	// Função de validação
	validator = validate();

	$("#cpf").mask("999.999.999-99");
	
	AddTelefone();
	
	$('.add_telefone').click(function(){
		AddTelefone();				
	});

	$(".form-signin").submit( function(){
		if( validator.form() ){
			salvarPaciente();
		}
		return false;
	});	
});
</script>