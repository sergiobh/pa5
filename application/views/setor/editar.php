<div id="editSetores" class="float espacoPadding borda ">
	<form id="formFuncionarios" role="form"	class="form-signin form-signin_setor">
		
		<h2 class="form-signin-heading">Edição de Setor</h2>
		
		 <input type="hidden" id="inputSetorId"
			name="inputSetorId" class="form-control" value="<?php echo $SetorId;?>"/>
		<div class="form-group">
			<label>Nome:</label><input type="text" id="inputNomeSetor"
				name="inputNomeSetor" class="form-control" placeholder="Nome"
				maxlength="40" />
		</div>
		<div class="form-group">
			<label>Gestor responsável:</label> <select id="selectGestorSetor"
				name="selectGestorSetor" class="form-control"
				placeholder="Gestor Responsável">
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
<script type="text/javascript">
var SetorId = $("#inputSetorId").val();
var FuncionariosSelecione = "<option value=''>Gestor (Selecione)</option>";

$(document).ready(function(){
	getGestorResponsavel();

	var validator = $(".form-signin").validate({
		debug: true,
		rules: ( "add", {
			inputNomeSetor: {
				required: true,
				minlength: 2,
				maxlength: 40
			},
			selectGestorSetor: {
				required: true
			}
		}),
		messages: {
			inputNomeSetor:{
	            required: "Campo obrigatório",
	            minlength: "Digite pelo menos 3 caracteres",
	            maxlength: "Digite no máximo 40 caracteres"
	        },
	        selectGestorSetor: {
	            required: "Campo obrigatório"	            
			}
		}
	});
	$( ".form-signin" ).submit( function( ) {
			if( validator.form( ) ) {
				submerterFormSetor( );
			}

			return false;
		} );
});

function submerterFormSetor( ) {
	$.blockUI({ message: '<h3>Salvando os dados...</h3>' });

	var Nome = $("#inputNomeSetor").val();
	var GestorId = $("#selectGestorSetor option:selected").val();
	
	var Url = '<?php echo BASE_URL;?>/setor/salvarEdicao';
	var data = 'SetorId='+SetorId+'&Nome='+Nome+'&GestorId='+GestorId; 
	
	$.ajax({
		type: "post",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			$.blockUI({ message: '<h3>'+ retorno.msg +'</h3>' });
			
			setTimeout(
					function(){
						if(retorno.success){
							window.location = "<?php echo BASE_URL;?>/setor/listar"
						}
						else{
							$.unblockUI();
						}
					},
					2000
				);
		},
		error: function(){
			$.blockUI({ message: '<h3>Ocorreu um erro no servidor. Favor recarregar a página!</h3>' });
			
			setTimeout(
				function(){
					window.location = "<?php echo BASE_URL;?>/setor/listar"
				},
				3000
			);
		}
	});
}

function getGestorResponsavel(){
	var Url		= '<?php echo BASE_URL;?>/funcionario/getFuncionarios';

	$.blockUI({ message: '<h3>Carregando os Gestores Responsáveis...</h3>' });

	$.ajax({
		type: "get",
		url: Url,
		dataType: 'json',
		success: function(retorno){
			var Dados = "";

			if(retorno.success){
				var Funcionarios = retorno.Funcionarios;

				for(Reg in Funcionarios){
					Dados += '<option value="'+Funcionarios[Reg].FuncionarioId+'">'+Funcionarios[Reg].Nome+'</option>';
				}

				$('#selectGestorSetor').html(FuncionariosSelecione + Dados);

				// Busca os dados do Setor para edição
				getSetor();
				
				$.unblockUI();
			}
		},
		error: function(){
			$.blockUI({ message: '<h3>Ocorreu um erro no servidor. Favor recarregar a página!</h3>' });
			
			setTimeout(
				function(){
					window.location = "<?php echo BASE_URL;?>/setor/listar"
				},
				3000
			);
		}
	});
}

function getSetor(){
	var Url = '<?php echo BASE_URL;?>/setor/getEditar';
	var data = 'SetorId='+SetorId; 	
	
 	$.blockUI({ message: '<h3>Carregando os dados do Setor...</h3>' });

	$.ajax({
		type: "get",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			if(retorno.success){
				if(retorno.Setor){
					popularSetor(retorno.Setor);			
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

function popularSetor(Setor){
	$("#inputNomeSetor").val(Setor.Nome);
	$("#selectGestorSetor").val(Setor.FuncionarioId);
}

function exibeErro(msg){
	if(msg == ''){
		msg = 'Ocorreu um erro no servidor. Favor recarregar a página!';
	}

	$.blockUI({ message: '<h3>'+msg+'</h3>' });
	
	setTimeout(
		function(){
			window.location = "<?php echo BASE_URL;?>/setor/listar"
		},
		3000
	);
}
</script>