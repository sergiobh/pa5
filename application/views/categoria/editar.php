<div id="editCategorias" class="float espacoPadding borda ">
	<form id="formCategorias" role="form"
		class="form-signin form-signin_Categoria">
		<h3 class="glyphicon glyphicon-th-large">&nbsp;EDIÇÃO DE CATEGORIAS</h3>
		<BR /> <BR /> <input type="hidden" id="inputCategoriaId"
			name="inputCategoriaId" class="form-control"
			value="<?php echo $CategoriaId;?>" />
		<div class="form-group">
			<label>Nome:</label><input type="text" id="inputNomeCategoria"
				name="inputNomeCategoria" class="form-control" placeholder="Nome"
				maxlength="50" />
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
var CategoriaId = $("#inputCategoriaId").val();

$(document).ready(function(){
	getCategoria();

	var validator = $("#formCategorias").validate({
		debug: true,
		rules: ( "add", {
			inputNomeCategoria: {
				required: true,
				minlength: 3,
				maxlength: 50
			}
		}),
		messages: {
			inputNomeCategoria:{
	            required: "Campo obrigatório",
	            minlength: "Digite pelo menos 3 caracteres",
	            maxlength: "Digite no máximo 50 caracteres"
	        }
		}
	});
	$( ".form-signin" ).submit( function( ) {
			if( validator.form( ) ) {
				submerterFormCategoria( );
			}

			return false;
	});
});

function submerterFormCategoria( ) {
	$.blockUI({ message: '<h3>Salvando os dados...</h3>' });

	var Nome = $("#inputNomeCategoria").val();
	
	var Url = '<?php echo BASE_URL;?>/categoria/salvarEdicao';
	var data = 'CategoriaId='+CategoriaId+'&Nome='+Nome; 
	
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
							window.location = "<?php echo BASE_URL;?>/categoria/listar"
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
					window.location = "<?php echo BASE_URL;?>/categoria/listar"
				},
				3000
			);
		}
	});
}

function getCategoria(){
	var Url = '<?php echo BASE_URL;?>/categoria/getEditar';
	var data = 'CategoriaId='+CategoriaId; 	
	
 	$.blockUI({ message: '<h3>Carregando os dados da Categoria...</h3>' });

	$.ajax({
		type: "get",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			if(retorno.success){
				if(retorno.Categoria){
					popularCategoria(retorno.Categoria);			
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

function popularCategoria(Categoria){
	$("#inputNomeCategoria").val(Categoria.Nome);
}

function exibeErro(msg){
	if(msg == ''){
		msg = 'Ocorreu um erro no servidor. Favor recarregar a página!';
	}

	$.blockUI({ message: '<h3>'+msg+'</h3>' });
	
	setTimeout(
		function(){
			window.location = "<?php echo BASE_URL;?>/categoria/listar"
		},
		3000
	);
}
</script>