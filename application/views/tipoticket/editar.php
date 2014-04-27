<form id="formTipoTicket" role="form" class="form-signin">
	<h3 class="glyphicon glyphicon-th-large">&nbsp;EDIÇÃO DO TIPO DE TICKET</h3>
	<BR /> <BR />
	<div class="form-group">
		<input type="hidden" id="inputTipoTicketId" name="inputTipoTicketId"
			class="form-control"
			value="<?php echo (isset($TipoId)) ? $TipoId : '';?>" /> <label>Nome:</label><input
			type="text" id="inputCadTipoTicket" name="inputCadTipoTicket"
			class="form-control" maxlength="50" placeholder="Tipo de Ticket"
			readonly="readonly" />
	</div>
	<div class="form-group">
		<label>Categoria:</label><select id="selectCategoriaTipo"
			name="selectCategoriaTipo" class="form-control" readonly="readonly"
			placeholder="Categoria">
		</select>
	</div>
	<div class="form-group">
		<label>Prioridade:</label><select id="selectPrioridadeTipo"
			name="selectPrioridadeTipo" class="form-control"
			placeholder="Prioridade">
		</select>
	</div>
	<div class="form-group">
		<label>SLA: (minutos)</label><input type="text" maxlength="5"
			id="inputSlaTipo" name="inputSlaTipo" class="form-control"
			placeholder="SLA" />
	</div>
	<div class="form-group">
		<label>Status:</label><select id="selectStatus" name="selectStatus"
			class="form-control" placeholder="Prioridade">
			<option value='1'>Ativado</option>
			<option value='0'>Desativado</option>
		</select>
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
<?php
	$this->load->view ( 'tipoticket/NIVEL', array('TipoId' => $TipoId) );
?>
<script type="text/javascript">
var TipoTicket = '';
var TipoId = $("#inputTipoTicketId").val();

$(document).ready(function(){
	getTipoTicket();	

	var validator = $(".form-signin").validate({
		debug: true,
		rules: ( "add", {
			selectPrioridadeTipo: {
				required: true
			},
			inputSlaTipo: {
				required: true,
				number: true
			}
		}),
		messages: {
			selectPrioridadeTipo: {
	            required: "Campo obrigatório"
			},
			inputSlaTipo: {
	            required: "Campo obrigatório",
				number: "Digite o SLA em minutos"
			}
		}
	});
	$( ".form-signin" ).submit( function( ) {
			if( validator.form( ) ) {
				submerterFormTipoTicket( );
			}

			return false;
		} );
});

function submerterFormTipoTicket( ) {
	$.blockUI({ message: '<h3>Salvando os dados...</h3>' });

	var PrioridadeId = $("#selectPrioridadeTipo option:selected").val();
	var SLA = $("#inputSlaTipo").val();
	var Ativo = $("#selectStatus").val(); 
	
	var Url = '<?php echo BASE_URL;?>/tipoticket/salvarEdicao';
	var data = 'TipoId='+TipoTicket.TipoId+'&PrioridadeId='+PrioridadeId+'&SLA='+SLA+'&Ativo='+Ativo; 
	
	$.ajax({
		type: "post",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			exibeErro(retorno.msg);
		},
		error: function(){
			exibeErro("Ocorreu um erro no servidor. Favor recarregar a página!");
		}
	});
}

function getTipoTicket(){
	var Url = '<?php echo BASE_URL;?>/tipoticket/getEditar';
	var data = 'TipoId='+TipoId; 	
	
 	$.blockUI({ message: '<h3>Carregando os dados do Tipo de Ticket...</h3>' });

	$.ajax({
		type: "get",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			if(retorno.success){
				if(retorno.TipoTicket){
					TipoTicket = retorno.TipoTicket;

					carregaCategorias();
					
					$.unblockUI();
				}
				else{
					exibeErro(retorno.msg);
				}
			}
			else{
				exibeErro(retorno.msg);
			}
		},
		error: function(){
			exibeErro('');
		}
	});
}

function carregaCategorias(){
	$.blockUI({ message: '<h2>Carregando as categorias...</h2>' });
	
	var Url = '<?php echo BASE_URL;?>/categoria/getCategorias';

	var data = 'CategoriaId='+TipoTicket.CategoriaId;
	
	$.ajax({
		type: "get",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			var Dados = "";
	
			if(retorno.success){
				var Categorias = retorno.Categorias;
	
				for(Reg in Categorias){
					Dados += '<option value="'+Categorias[Reg].CategoriaId+'">'+Categorias[Reg].Nome+'</option>';
				}
	
				$('#selectCategoriaTipo').html(Dados);

				carregaPrioridade();
				
				$.unblockUI();
			}
			else{
				exibeErroRecarregarPagina;
			}
		},
		error: function(){
			exibeErroRecarregarPagina;
		}
	});
}

function carregaPrioridade(){

	$.blockUI({ message: '<h2>Carregando as prioridades...</h2>' });
	
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
	
				$('#selectPrioridadeTipo').html(Dados);

				popularTipoTicket();
				
				$.unblockUI();
			}
			else{
				exibeErroRecarregarPagina;
			}
		},
		error: function(){
			exibeErroRecarregarPagina;
		}
	});
}

function popularTipoTicket(){
	$("#inputCadTipoTicket").val(TipoTicket.Nome);
	$("#selectCategoriaTipo").val(TipoTicket.CategoriaId);
	$("#selectPrioridadeTipo").val(TipoTicket.PrioridadeId);
	$("#inputSlaTipo").val(TipoTicket.SLA);
	$("#selectStatus").val(TipoTicket.Ativo);
}

function exibeErro(msg){
	if(msg == ''){
		msg = 'Ocorreu um erro no servidor. Favor recarregar a página!';
	}

	$.blockUI({ message: '<h3>'+msg+'</h3>' });
	
	setTimeout(
		function(){
			window.location = "<?php echo BASE_URL;?>/tipoticket/listar"
		},
		3000
	);
}
</script>