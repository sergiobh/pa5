<div class='titulo_page'>Cadastro de Funcionário</div>
<div class='funcionario_cadastrar'>
	<form action="" id="formFuncionarios" role="form" class="form-signin">
		<h3 class="glyphicon glyphicon-th-large">FUNCION&Aacute;RIO</h3>
		<BR /> <BR />
		<div class="form-group">
			<label>Nome:</label> <input type="text" id="inputNomeFunc" autofocus
				name="inputNomeFunc" class="form-control" placeholder="Nome" />
		</div>
		<div class="form-group">
			<label>Setor:</label> <select type="text" id="selectSetorFunc"
				name="selectSetorFunc" class="form-control" placeholder="Setor">
				<option value="">Selecione...</option>
			</select>
		</div>
		<div class="form-group">
			<label>CPF:</label> <input type="text" id="inputCpfFunc"
				name="inputCpfFunc" class="form-control" placeholder="C.P.F" />
		</div>
		<div class="form-group">
			<label>Senha:</label> <input type="password" maxlength="8"
				id="inputsenhaFunc" name="inputsenhaFunc" class="form-control"
				placeholder="Senha" /><br />
		</div>
		<div class="form-group">
			<div class="linha_botoes">
				<button class="btn btn-sm btn btn-success btn-block botao_submit">Enviar</button>
				<button class="btn btn-sm btn btn-danger btn-block botao_reset"
				type="reset">Limpar</button>
			</div>
		</div>
	</form>
	<script type="text/javascript">
		$(document).ready(function(){

			carregarGrupoUsuario();
		
			// Função para o click de cadastro
			$('.botao_submit').click(function(){

				// Validação do formulário padrão
				if(! validaDados2('formulario')){
					return false;
				}

				// Declaração de variaveis
				var Nome 		= $("#Nome").val();
				var Cpf 		= $("#Cpf").val();
				var Senha 		= $("#Senha").val();
				var GrupoId 	= $("#GrupoId").val();

				// Executa o POST usando metodo AJAX e retorando Json
				var Url				= '<?php echo BASE_URL;?>/funcionario/salvarCadastro';

				var data 			= {'Nome':Nome,'Cpf':Cpf,'GrupoId':GrupoId,'Senha':Senha};

				$.blockUI({ message: '<h1>Salvando os dados...</h1>' });

				$.ajax({
					type: "post",
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
			});	
		});

		function carregarGrupoUsuario(){
				$.blockUI({ message: '<h3>Carregando lista de Grupos</h3>' });

				var Url = "<?php echo BASE_URL;?>/grupo/listarcombobox";

				$.ajax({
					type: "get",
					url: Url,
					dataType: 'json',
					success: function(retorno){
						if(retorno.success){
							alimentaComboBox(retorno.Grupos);
							$.unblockUI();
						}
						else{
							// Se php retornou erro irá salvar o retorno da div "retorno"
							$('.retorno_ajax').html("Ocorreu um erro no sistema, recarregue a página!");
							$.unblockUI();
						}
					},
					error: function(){
						$('.retorno_ajax').html('Ocorreu um erro no servidor. Tentar novamente!');
						$.unblockUI();
					}
				});
		}

		function alimentaComboBox(Grupos){
			var Listagem = '<option value="-1">--- Selecione ---</option>';

			for(i in Grupos){
				Listagem += '<option value="'+Grupos[i].GrupoId+'">'+Grupos[i].Nome+'</option>';				
			}

			$('#GrupoId').html(Listagem);
		}
	</script>



	<?php /*
		<form action = <?php echo BASE_URL;?>/funcionario/processar method = "post" onsubmit="return validaDados(this)">
	*/ ?>
</div>