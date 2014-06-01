<div class='titulo_page'>Edição de Pacientes</div>
<div class='painel_pacientes'>
	<form class='formulario form-signin'>
		<div class="form-group">
			<label>Status:</label> <select name="status" id='status'
				class="form-control" autofocus>
				<option value="1"
					<?php echo ($Paciente->Status == 1) ? 'selected="selected"' : '';?>>Presente</option>
						<?php if($Paciente->Ocupacao == 0){ ?>
							<option value="0"
					<?php echo ($Paciente->Status == 0) ? 'selected="selected"' : '';?>>Auta
					hospitalar</option>
						<?php } ?>
					</select>
		</div>
		<div class="form-group">
			<label>Nome:</label> <input class="form-control" id='nome'
				type='text' maxlength='100' name='nome'
				value="<?php echo $Paciente->Nome;?>" />
		</div>
		<div class="form-group">
			<label>Plano:</label> <select class="form-control" name="tipo"
				id='tipo'>
				<option value="">--- Selecione ---</option>
				<option value="1"
					<?php echo ($Paciente->Tipo == 1) ? 'selected="selected"' : '';?>>Apartamento</option>
				<option value="2"
					<?php echo ($Paciente->Tipo == 2) ? 'selected="selected"' : '';?>>Enfermária</option>
			</select>
		</div>
		<div class="form-group">
			<label>Sexo:</label>
			<td><select class="form-control" name="sexo" id='sexo'>
					<option value="">--- Selecione ---</option>
					<option value="1"
						<?php echo ($Paciente->Sexo == 1) ? 'selected="selected"' : '';?>>Masculino</option>
					<option value="2"
						<?php echo ($Paciente->Sexo == 2) ? 'selected="selected"' : '';?>>Feminino</option>
			</select>
		
		</div>
		<div class="form-group">
			<label>CPF:</label> <input class="form-control" type='text'
				maxlength='11' name='cpf' id='cpf'
				value='<?php echo $Paciente->Cpf;?>' readonly="readonly" />
		</div>
		<div class="form-group">
			<label>Logradouro:</label> <input class="form-control" type='text'
				maxlength='50' name='logradouro' id='logradouro'
				value='<?php echo $Paciente->Logradouro;?>' />
		</div>
		<div class="form-group">
			<label>Número:</label> <input class="form-control" type='text'
				maxlength='10' name='numero' id='numero'
				value='<?php echo $Paciente->Numero;?>' />
		</div>
		<div class="form-group">
			<label>Complemento:</label> <input class="form-control" type='text'
				maxlength='10' name='complemento' id='complemento'
				value='<?php echo $Paciente->Complemento;?>' />
		</div>
		<div class="form-group">
			<label>Bairro:</label> <input class="form-control" type='text'
				maxlength='40' name='bairro' id='bairro'
				value='<?php echo $Paciente->Bairro;?>' />
		</div>
		<div class="form-group">
			<label>Cidade:</label> <input class="form-control" type='text'
				maxlength='40' name='cidade' id='cidade'
				value='<?php echo $Paciente->Cidade;?>' />
		</div>
		<div class="form-group">
			<label>Estado:</label> <input class="form-control" type='text'
				maxlength='2' name='estado' id='estado'
				value='<?php echo $Paciente->Estado;?>' />
		</div>
		<div class="form-group">
			<label>Contatos:</label> <input class='add_telefone' type='button'
				name='add_telefone' value='Adicionar' /> <input type="hidden"
				name="QtdTelefone" value="<?php echo count($Paciente->Telefones);?>"
				id="QtdTelefone">
		</div>
		<div class="form-group">
			<div class="add_contatos"></div>
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
var validator = '';
var Telefones = [];
var TelefonesNumeros = [];

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

function inicializaTelefone(){
	for ( var Item in Telefones) {
		populaTelefone(Telefones[Item]);

		gravaNumero(Telefones[Item], TelefonesNumeros[Item]);
	}
}

function AddTelefone(){
	var QtdTelefone = $("#QtdTelefone").val();
	
	QtdTelefone++;

	$("#QtdTelefone").val(QtdTelefone);

	// Adiciona o Telefone no array
	Telefones.push(QtdTelefone);

	populaTelefone(QtdTelefone);

	$('.telefone').mask("(99)9999-9999");
}

function populaTelefone(QtdTelefone){
	var AddTelefone = "<div class='linha_telefone linha_telefone"+QtdTelefone+"'><div class='columnRemoveTelefone'><input class='del_telefone' onclick='DelTelefone("+QtdTelefone+")' name='DelTelefone"+QtdTelefone+"' type='button' value='Remover' /></div><div class='columnTitleTelefone'>Telefone"+QtdTelefone+":</div><div class='dadosTelefone'><input class='form-control telefone' type='text' maxlength='13' name='telefone"+QtdTelefone+"' id='telefone"+QtdTelefone+"' /></div>";
	
	$(".add_contatos").append(AddTelefone);

	adicionaValidacao('telefone'+QtdTelefone);
}

function gravaNumero(Posicao, Numero){
	$('#telefone'+Posicao).val(Numero);
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
						
	/*
	function AddTelefone(){
		var QtdTelefone = $("#QtdTelefone").val();

		QtdTelefone++;

		$("#QtdTelefone").val(QtdTelefone);

		// Adiciona o Telefone no array
		Telefones.push(QtdTelefone);

		var AddTelefone = "<tr class='linha_telefone linha_telefone"+QtdTelefone+"'><td>Telefone"+QtdTelefone+":</td><td><input type = 'text' maxlength = '14' name = 'telefone"+QtdTelefone+"' descricao = 'telefone"+QtdTelefone+"' class='telefone' id = 'telefone"+QtdTelefone+"' obrigatorio = 'sim' /></td><td><input class='del_telefone' onclick='DelTelefone("+QtdTelefone+")' type = 'button' value = 'Remover' /></td></tr>";

		$(".tr_botoes").before(AddTelefone);

		$('.telefone').mask("(99)9999-9999");
	}
	*/
	
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

function salvarEdicao(){
	// Declaração de variaveis
	var Status 			= $("#status").val();
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
	var Url				= '<?php echo BASE_URL;?>/paciente/salvarEdicao';

	var data 			= 	'PacienteId='+<?php echo $Paciente->PacienteId;?>
							+'&Status='+Status
							+'&Nome='+Nome
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

	$.blockUI({ message: '<h1>Salvando os dados...</h1>' });

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
						window.location = "<?php echo BASE_URL;?>/ocupacao/cadastrar";
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
						window.location = "<?php echo BASE_URL;?>/paciente/consultar";
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

	/*
	/* Inclui os telefones do banco de dados no array de telefones
	*/
	<?php if (is_array ( $Paciente->Telefones )) { ?>
		<?php foreach ( $Paciente->Telefones as $key => $Telefone ) { ?>
			Telefones.push(<?php echo $key+1;?>);
			TelefonesNumeros.push('<?php echo $Telefone;?>');
		<?php } ?>
	<?php } ?>


	// Função de validação
	validator = validate();

	$("#cpf").mask("999.999.999-99");

	// Metodo para que o javascript execute a inclusão dos telefones no layout
	inicializaTelefone();
	
	$('.add_telefone').click(function(){
		AddTelefone();				
	});

	$(".form-signin").submit( function(){
		if( validator.form() ){
			salvarEdicao();
		}
		return false;
	});
});
</script>
</div>