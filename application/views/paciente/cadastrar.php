<div class='titulo_page'>Cadastro de Pacientes</div>
<div class = 'painel_pacientes'>
	<form class='formulario form-signin'>
		
		<div class="form-group">
			<label>Nome:</label>
			<input class="form-control" id = 'nome' type = 'text' maxlength = '100' name = 'nome' descricao = 'nome' obrigatorio = 'sim' />
			
		</div>
		
		<div class="form-group">
			<label>Plano:</label>
			<select class="form-control" name="tipo" descricao = "plano" id='tipo' obrigatorio = 'sim'>
						<option value="-1">--- Selecione ---</option>
						<option value="1">Apartamento</option>
						<option value="2">Enfermária</option>
					</select>
		</div>
		
		<div class="form-group">
			<label>Sexo:</label>
			<select class="form-control" name="sexo" id='sexo' descricao = "sexo" obrigatorio = 'sim'>
						<option value="-1">--- Selecione ---</option>
						<option value="1">Masculino</option>
						<option value="2">Feminino</option>
					</select>
			
		</div>
		
		<div class="form-group">
			<label>CPF:</label>
			<input class="form-control" type = 'text' maxlength = '11' name = 'cpf' id='cpf' descricao = 'cpf' obrigatorio = 'sim' />
		</div>
		
		<div class="form-group">
			<label>Logradouro:</label>
			<input class="form-control" type = 'text' maxlength = '50' name = 'logradouro' id='logradouro' descricao = 'logradouro' obrigatorio = 'sim' />
		</div>
		
		<div class="form-group">
			<label>Número:</label>
			<input class="form-control" type = 'text' maxlength = '10' name = 'numero' id='numero' descricao = 'numero' obrigatorio = 'sim' />
			
		</div>
		
		<div class="form-group">
			<label>Complemento:</label>
			<input class="form-control" type = 'text' maxlength = '10' name = 'complemento' id='complemento' descricao = 'complemento' obrigatorio = 'nao' />
		</div>
		
		<div class="form-group">
			<label>Bairro:</label>
			<input class="form-control" type = 'text' maxlength = '40' name = 'bairro' id='bairro' descricao = 'bairro' obrigatorio = 'sim' />
		</div>
		
		<div class="form-group">
			<label>Cidade:</label>
			<input class="form-control" type = 'text' maxlength = '40' name = 'cidade' id='cidade' descricao = 'cidade' obrigatorio = 'sim' />
		</div>
		
		<div class="form-group">
			<label>Estado:</label>
			<input class="form-control" type = 'text' maxlength = '2' name = 'estado' id='estado' descricao = 'estado' obrigatorio = 'sim' />
		</div>
		
		<div class="form-group">
			<label>Contatos</label>
			<input class='add_telefone' type = 'button' value = 'Adicionar' />
			<input type="hidden" name="QtdTelefone" value="0" id="QtdTelefone">
		</div>
		<div class="form-group">
		<table>
		<tr class='tr_botoes'>
				<td></td>
				<td colspan="2">
		<div class="linha_botoes">
		<div class='retorno_ajax'></div>
			<button class="btn btn-sm btn btn-success btn-block botao_submit">
					Enviar</button>
			<button class="btn btn-sm btn btn-danger btn-block botao_reset"
					type="reset">Limpar</button>
		</div>
					
					
				</td>
			</tr>
		</table>
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

			var AddTelefone = "<tr class='linha_telefone linha_telefone"+QtdTelefone+"'><td>Telefone"+QtdTelefone+":</td><td><input class='form-control' type = 'text' maxlength = '14' name = 'telefone"+QtdTelefone+"' descricao = 'telefone"+QtdTelefone+"' class='telefone' id = 'telefone"+QtdTelefone+"' obrigatorio = 'sim' /></td><td><input class='del_telefone ' onclick='DelTelefone("+QtdTelefone+")' type = 'button' value = 'Remover' /></td></tr>";

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

			$("#cpf").mask("999.999.999-99");

			AddTelefone();

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
			});
		});
	</script>
</div>