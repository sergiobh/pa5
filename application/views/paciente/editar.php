<div class='titulo_page'>Edição de Pacientes</div>
<div class = 'painel_pacientes'>
	<form class='formulario form-signin'>
		
		<div class="form-group">
			<label>Status:</label>
			<select name="status" descricao = "status" id='status' obrigatorio = 'sim' class="form-control">
						<option value="1" <?php echo ($Paciente->Status == 1) ? 'selected="selected"' : '';?>>Presente</option>
						<?php if($Paciente->Ocupacao == 0){ ?>
							<option value="0" <?php echo ($Paciente->Status == 0) ? 'selected="selected"' : '';?>>Auta hospitalar</option>
						<?php } ?>
					</select>
		</div>
		
		<div class="form-group">
			<label>Nome:</label>
				<input class="form-control" id = 'nome' type = 'text' maxlength = '100' name = 'nome' descricao = 'nome' obrigatorio = 'sim' value="<?php echo $Paciente->Nome;?>" />
		</div>
		
		<div class="form-group">
			<label>Plano:</label>
			<select class="form-control" name="tipo" descricao = "plano" id='tipo' obrigatorio = 'sim'>
						<option value="-1">--- Selecione ---</option>
						<option value="1" <?php echo ($Paciente->Tipo == 1) ? 'selected="selected"' : '';?>>Apartamento</option>
						<option value="2" <?php echo ($Paciente->Tipo == 2) ? 'selected="selected"' : '';?>>Enfermária</option>
					</select>
		</div>
		
		<div class="form-group">
			<label>Sexo:</label>
			<td>
					<select class="form-control" name="sexo" id='sexo' descricao = "sexo" obrigatorio = 'sim'>
						<option value="-1">--- Selecione ---</option>
						<option value="1" <?php echo ($Paciente->Sexo == 1) ? 'selected="selected"' : '';?>>Masculino</option>
						<option value="2" <?php echo ($Paciente->Sexo == 2) ? 'selected="selected"' : '';?>>Feminino</option>
					</select>
		</div>
		
		<div class="form-group">
			<label>CPF:</label>
			<input class="form-control" type = 'text' maxlength = '11' name = 'cpf' id='cpf' descricao = 'cpf' obrigatorio = 'sim' value='<?php echo $Paciente->Cpf;?>' />
		</div>
		
		<div class="form-group">
			<label>Logradouro:</label>
			<input class="form-control" type = 'text' maxlength = '50' name = 'logradouro' id='logradouro' descricao = 'logradouro' obrigatorio = 'sim' value='<?php echo $Paciente->Logradouro;?>' />
		</div>
		<div class="form-group">
			<label>Número:</label>
			<input class="form-control" type = 'text' maxlength = '10' name = 'numero' id='numero' descricao = 'numero' obrigatorio = 'sim' value='<?php echo $Paciente->Numero;?>' />
		</div>
		<div class="form-group">
			<label>Complemento:</label>
			<input class="form-control" type = 'text' maxlength = '10' name = 'complemento' id='complemento' descricao = 'complemento' obrigatorio = 'nao' value='<?php echo $Paciente->Complemento;?>' />
		</div>
		<div class="form-group">
			<label>Bairro:</label>
			<input class="form-control" type = 'text' maxlength = '40' name = 'bairro' id='bairro' descricao = 'bairro' obrigatorio = 'sim' value='<?php echo $Paciente->Bairro;?>' />
		</div>
		<div class="form-group">
			<label>Cidade:</label>
			<input class="form-control" type = 'text' maxlength = '40' name = 'cidade' id='cidade' descricao = 'cidade' obrigatorio = 'sim' value='<?php echo $Paciente->Cidade;?>' />
		</div>
		<div class="form-group">
			<label>Estado:</label>
			<input class="form-control" type = 'text' maxlength = '2' name = 'estado' id='estado' descricao = 'estado' obrigatorio = 'sim' value='<?php echo $Paciente->Estado;?>' />
		</div>
		<div class="form-group">
			<label>Contatos:</label>
			<input class='add_telefone' type = 'button' value = 'Adicionar' />
			<input type="hidden" name="QtdTelefone" value="<?php echo count($Paciente->Telefones);?>" id="QtdTelefone">
		</div>

		<div class="form-group">
			
			<table>
				
			
					<?php 
				if(is_array($Paciente->Telefones)){
					foreach($Paciente->Telefones as $key => $Telefone) { ?>
						<?php $Registro = $key+1;?>
							<tr class='linha_telefone linha_telefone<?php echo $Registro;?>'><td>Telefone<?php echo $Registro;?>:</td><td><input type = 'text' maxlength = '14' name = 'telefone<?php echo $Registro;?>' descricao = 'telefone<?php echo $Registro;?>' class='telefone' id = 'telefone<?php echo $Registro;?>' obrigatorio = 'sim' value='<?php echo $Telefone;?>' /></td><td><input class='del_telefone' onclick='DelTelefone("<?php echo $Registro;?>")' type = 'button' value = 'Remover' /></td></tr>
					<?php }
				}
			?>
			<tr class='tr_botoes'></tr>
			</table>
		</div>
		<div class="form-group">
			<div class='retorno_ajax'></div>
			<div class="linha_botoes">
				<button class="btn btn-sm btn btn-success btn-block botao_submit">
					Enviar</button>
				<button class="btn btn-sm btn btn-danger btn-block botao_reset"
					type="reset">Limpar</button>

			</div>
			
		</div>		
					
					
		</form>
	<script type="text/javascript">
		var Telefones = [];

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

		$(document).ready(function(){

			/*
			/* Inclui os telefones do banco de dados no array de telefones
			*/
			<?php if(is_array($Paciente->Telefones)){
				foreach($Paciente->Telefones as $key => $Telefone){ ?>
					Telefones.push(<?php echo $key+1;?>);
				<?php } ?>
			<?php } ?>

			$("#cpf").mask("999.999.999-99");

			$('.add_telefone').click(function(){
				AddTelefone();				
			});

			// Função para o click de cadastro
			$('.botao_submit').click(function(){

				// Validação do formulário padrão
				if(! validaDados2('formulario')){
					return false;
				}

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
			});
		});
	</script>
</div>