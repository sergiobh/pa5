<div class='titulo_page'>Edição de Quarto</div>
<div class="quarto_editar">
	<?php if($Quarto) { ?>
		<form class='formulario form-signin'>
			
			<div class="form-group">
				<label>Andar:</label>
				<input class="form-control" type="text" id="Andar" name="Andar" value="<?php echo $Quarto->Andar;?>" <?php echo ($Quarto->Status == '3') ? 'readonly="readonly"' : '';?> obrigatorio = 'sim' >
			</div>
			
			<div class="form-group">
				<label>Identificação:</label>
				<input class="form-control" type = 'text' maxlength = '10' id='Identificacao' name = 'Identificacao' descricao = 'Identificação'  obrigatorio = 'sim' value="<?php echo $Quarto->Identificacao;?>" />
			</div>
			
			<div class="form-group">
				<label>Status:</label>
				<select class="form-control" id='Status' descricao = 'Status' obrigatorio = 'sim'>
							<?php if($Quarto->Status != '3') { ?>
								<?php foreach($Status as $Registro){ ?>
									<option value="<?php echo $Registro->Status;?>" <?php echo ($Quarto->Status == $Registro->Status) ? 'selected="selected"' : '';?>><?php echo $Registro->Nome;?></option>
								<?php } ?>
							<?php }else { ?>
								<option value="1" selected="selected">Ocupado</option>
							<?php } ?>
						</select>
			</div>
			
			<div class="form-group">
				
				<div class='retorno_ajax'></div>
			<div class="linha_botoes">
				<button class="btn btn-sm btn btn-success btn-block botao_submit">
					Enviar</button>
				<button class="btn btn-sm btn btn-danger btn-block botao_reset"
					type="reset">Cancelar</button>
			</div>
			</div>
	</form>
	<?php } else{ ?>
		<div class=''>Quarto inválido!</div>
	<?php } ?>
	<script type="text/javascript">
		$(document).ready(function(){
		
			// Função para o click de cadastro
			$('.botao_submit').click(function(){

				// Validação do formulário padrão
				if(! validaDados2('formulario')){
					return false;
				}

				// Declaração de variaveis
				var QuartoId 	= <?php echo $Quarto->QuartoId;?>;
				var Andar 		= $("#Andar").val();
				var Identificacao 	= $("#Identificacao").val();
				var Status		= $("#Status option:selected").val();

				// Executa o POST usando metodo AJAX e retorando Json
				var Url				= '<?php echo BASE_URL;?>/quarto/salvarEdicao';

				var data 			= 'Andar='+Andar+'&QuartoId='+QuartoId+'&Status='+Status+'&Identificacao='+Identificacao;

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
			});	
		});
	</script>
</div>