<div class='niveis_historicos'>
	<div class='cadnivel_titulo'>
		<h2>
			&nbsp;TICKET:&nbsp;<span id="titulo_nivel"></span>
		</h2>
	</div>
	<?php $this->load->view ( 'tiponivel/listar', array('TipoId' => $TipoId, 'ExibeRemove' => true) );?>
	<div class="cadnivel_form">
		<div id="cadTipoTicket" class="float espacoPadding">
			<form id="formTipoTicket" role="form" class="form-signin">
				<h3 class="glyphicon glyphicon-th-large">&nbsp;CADASTRAR NÍVEL DO
					TIPO</h3>
				<BR /> <BR />
				<div class="form-group">
					<input type="hidden" id="inputCadNivelTipo"
						name="inputCadNivelTipo" class="form-control" />
				</div>
				<div class="form-group">
					<label>Setor:</label><select id="selectSetorTipo"
						name="selectSetorTipo" class="form-control"
						placeholder="Setor responsável">
					</select>
				</div>
				<div class="form-group">
					<div class="linha_botoes">
						<button class="btn btn-sm btn btn-success btn-block botao_submit">
							Enviar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</br>
</br>
<script>
var TipoId = <?php echo $TipoId;?> 
var TipoTicket;

var Setorselecione = '<option value="">Setor: (Selecione)</option>';

$(document).ready(function(){
	carregaNomeNivel();

	carregaSetores();
	
	var validator = $("#formTipoTicket").validate({
		debug: true,
		rules: ( "add", {
			selectSetorTipo: {
				required: true
			}
		}),
		messages: {
			selectSetorTipo : {
	            required: "Campo obrigatório"
			}
		}
	});
	
	$( "#formTipoTicket" ).submit( function() {
		if( validator.form() ) {
			submeterFormTipoTicket();
		}

		return false;
	});
});

function carregaNomeNivel(){
	$.blockUI({ message: '<h3>Carregando os dados...</h3>' });

	var Url = "<?php echo BASE_URL;?>/tipoticket/getEditar";
	var data = 'TipoId='+TipoId;
	
	$.ajax({
		type: "get",
		url: Url,
		dataType: 'json',
		success: function(retorno){
			if(retorno.success){
				TipoTicket = retorno.TipoTicket;

				$("#titulo_nivel").html(TipoTicket.Nome.toUpperCase());

				$("#inputCadNivelTipo").val(TipoTicket.TipoId);
				
				$.unblockUI();
			}
			else{
				RedirecionamentoHome();
			}
		},
		error: function(){
			RedirecionamentoHome();
		}
	});
}

function RedirecionamentoHome(){
	$.blockUI({ message: '<h3>Registro não encontrado!<br />Redirecionando...</h3>' });

	// Efetuar o redirecionamento
	setTimeout(
		function(){
			window.location = "<?php echo BASE_URL;?>/tipoticket/listar"
		},
		2000
	);					
}

function submeterFormTipoTicket(){
	$.blockUI({ message: '<h3>Salvando os dados...</h3>' });

	var TipoId = $("#inputCadNivelTipo").val();
	var SetorId = $("#selectSetorTipo option:selected").val();
	
	var Url = '<?php echo BASE_URL;?>/tiponivel/salvarCadastro';
	var data = 'TipoId='+TipoId+'&SetorId='+SetorId;
	
	$.ajax({
		type: "post",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			exibeErro(retorno.msg);
		},
		error: function(){
			exibeErro('Ocorreu um erro no servidor. Favor recarregar a página!');
		}
	});
}

function carregaSetores(){
	$.blockUI({ message: '<h3>Carregando os setores...</h3>' });
	
	var Url = '<?php echo BASE_URL;?>/setor/getSetores';
	
	$.ajax({
		type: "get",
		url: Url,
		dataType: 'json',
		success: function(retorno){
			var Dados = "";
	
			if(retorno.success){
				var Setores = retorno.Setores;
	
				for(Reg in Setores){
					Dados += '<option value="'+Setores[Reg].SetorId+'">'+Setores[Reg].Nome+'</option>';
				}
	
				$('#selectSetorTipo').html(Setorselecione + Dados);
				
				$.unblockUI();
			}
			else{
				exibeErro(Retorno.msg);
			}
		},
		error: function(){
			exibeErro('Ocorreu um erro no servidor. Favor recarregar a página!');
		}
	});
}

function exibeErro(msg){
	$.blockUI({ message: '<h3>'+msg+'</h3>' });
	
	setTimeout(
		function(){
			window.location = "<?php echo BASE_URL;?>/tiponivel/cadastrar/"+TipoId;
		},
		2000
	);
}
</script>