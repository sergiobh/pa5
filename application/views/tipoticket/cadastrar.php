<div id="cadTipoTicket" class="float espacoPadding">
	<form id="formTipoTicket" role="form" class="form-signin">
		<h2 class="form-signin-heading">&nbsp;Cadastrar Tipo de	Ticket</h2>
		<BR />
		<div class="form-group">
			<label>Nome:</label><input type="text" id="inputCadTipoTicket"
				name="inputCadTipoTicket" class="form-control" maxlength="50"
				placeholder="Tipo de Ticket" />
		</div>
		<div class="form-group">
			<label>Categoria:</label><select id="selectCategoriaTipo"
				name="selectCategoriaTipo" class="form-control"
				placeholder="Categoria">
			</select>
		</div>
		<div class="form-group">
			<label>Setor:</label><select id="selectSetorTipo"
				name="selectSetorTipo" class="form-control"
				placeholder="Setor responsável">
			</select>
		</div>
		<div class="form-group">
			<label>Prioridade:</label><select id="selectPrioridadeTipo"
				name="selectPrioridadeTipo" class="form-control"
				placeholder="Prioridade">
			</select>
		</div>
		<div class="form-group">
			<label>SLA: (horas)</label><input type="text" maxlength="5"
				id="inputSlaTipo" name="inputSlaTipo" class="form-control"
				placeholder="SLA" /><br />
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
var CategoriaSelecione = '<option value="">Categoria: (Selecione)</option>';
var Setorselecione = '<option value="">Setor: (Selecione)</option>';
var Prioridadeselecione = '<option value="">Prioridade: (Selecione)</option>';

$(document).ready(function(){
	carregaCategorias();
	
	var validator = $("#formTipoTicket").validate({
		debug: true,
		rules: ( "add", {
			inputCadTipoTicket: {
				required: true,
				minlength: 3,
				maxlength: 50
			},
			selectCategoriaTipo: {
				required: true
			},
			selectSetorTipo: {
				required: true
			},
			selectPrioridadeTipo: {
				required: true
			},
			inputSlaTipo: {
				required: true,
				number: true
			}
		}),
		messages: {
			inputCadTipoTicket:{
	            required: "Campo obrigatório",
	            minlength: "Digite pelo menos 3 caracteres",
	            maxlength: "Digite no máximo 50 caracteres"
	        },
			selectCategoriaTipo: {
	            required: "Campo obrigatório"
			},
			selectSetorTipo : {
	            required: "Campo obrigatório"
			},
			selectPrioridadeTipo: {
	            required: "Campo obrigatório"
			},
			inputSlaTipo: {
	            required: "Campo obrigatório",
				number: "Digite o SLA em minutos"
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

function submeterFormTipoTicket(){
	$.blockUI({ message: '<h3>Salvando os dados...</h3>' });

	var Nome = $("#inputCadTipoTicket").val();
	var CategoriaId = $("#selectCategoriaTipo option:selected").val();
	var SetorId = $("#selectSetorTipo option:selected").val();
	var PrioridadeId = $("#selectPrioridadeTipo option:selected").val();
	var SLA = $("#inputSlaTipo").val();
	
	var Url = '<?php echo BASE_URL;?>/tipoticket/salvarCadastro';
	var data = 'Nome='+Nome+'&CategoriaId='+CategoriaId+'&SetorId='+SetorId+'&PrioridadeId='+PrioridadeId+'&SLA='+SLA;
	
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

function carregaCategorias(){
	$.blockUI({ message: '<h1>Carregando as categorias...</h1>' });
	
	var Url = '<?php echo BASE_URL;?>/categoria/getCategorias';
	
	$.ajax({
		type: "get",
		url: Url,
		dataType: 'json',
		success: function(retorno){
			var Dados = "";
	
			if(retorno.success){
				var Categorias = retorno.Categorias;
	
				for(Reg in Categorias){
					Dados += '<option value="'+Categorias[Reg].CategoriaId+'">'+Categorias[Reg].Nome+'</option>';
				}
	
				$('#selectCategoriaTipo').html(CategoriaSelecione + Dados);

				carregaSetores();
				
				$.unblockUI();
			}
			else{
				exibeErro(retorno.msg);
			}
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

				carregaPrioridades();
				
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

function carregaPrioridades(){
	$.blockUI({ message: '<h3>Carregando as prioridades...</h3>' });
	
	var Url = '<?php echo BASE_URL;?>/prioridade/getPrioridades';
	
	$.ajax({
		type: "get",
		url: Url,
		dataType: 'json',
		success: function(retorno){
			var Dados = "";
	
			if(retorno.success){
				var Prioridades = retorno.Prioridades;
	
				for(Reg in Prioridades){
					Dados += '<option value="'+Prioridades[Reg].PrioridadeId+'">'+Prioridades[Reg].Nome+'</option>';
				}
	
				$('#selectPrioridadeTipo').html(Prioridadeselecione + Dados);
				
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
			window.location = "<?php echo BASE_URL;?>/tipoticket/listar"
		},
		2000
	);
}
</script>