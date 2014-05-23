<form class="form-signin" role="form">
	<h2 class="form-signin-heading">Cadastro de Mudanças</h2>
	<div class="form-group">
		<div class="form-group">
			<label>Nome:</label><input id="NomeMudanca" name="NomeMudanca"
				type="text" class="form-control" placeholder="Nome da Mudança" />
		</div>
		<div class="form-group">
			<label>Descrição da Mudança:</label>
			<textarea id="descricaoMudanca" name="descricaoMudanca" type="text"
				value="" class="form-control" placeholder="Descrição da Mudança"></textarea>
		</div>
		<div class="form-group">
			<label>Prioridade:</label> <select id="PrioridadeMudanca" name="PrioridadeMudanca"
				value="" class="form-control">
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
var Prioridade_selecao = '<option value="">Prioridade: (Selecione)</option>';

$( document ).ready( function( ) {
	carregaPrioridade();
	
	var validator = $( ".form-signin" ).validate( {
		debug: true,
		rules: ( "add", {
			NomeMudanca: {
				required: true,
				minlength: 5
			},
			descricaoMudanca: {
				required: true,
				minlength: 5
			},
			PrioridadeMudanca: {
				required: true
			}
		} ),
		messages: {
			NomeMudanca: {
				required: "Campo obrigatório",
				minlength: "Digite pelo menos 5 caracteres"
			},
			descricaoMudanca: {
				required: "Campo obrigatório",
				minlength: "Digite pelo menos 5 caracteres"
			},
			PrioridadeMudanca: {
				required: "Campo obrigatório"
			}
		}
	} );

	$( ".form-signin" ).submit( function( ) {
		if( validator.form( ) ) {
			submerterForm( );
		}

		return false;
	} );

	// Reset
	$('.botao_reset').click(function(){
		$('#NomeMudanca').val('');
		$('#descricaoMudanca').val('');
		$('#PrioridadeMudanca').val('');
		
		return false;
	});
});

function submerterForm( ) {
	// Declaração de variaveis
	var Nome = $("#NomeMudanca").val();
	var Descricao = $("#descricaoMudanca").val();
	var PrioridadeId = $("#PrioridadeMudanca option:selected").val();
	
	// Executa o POST usando metodo AJAX e retorando Json
	var Url				= '<?php echo BASE_URL;?>/mudanca/salvarCadastro';

	var data 			= 'Nome='+Nome+'&Descricao='+Descricao+'&PrioridadeId='+PrioridadeId;

	$.blockUI({ message: '<h3>Salvando os dados...</h3>' });

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
						window.location = "<?php echo BASE_URL;?>/chamado/listar"
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
}

function carregaPrioridade(){

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

				Dados = Prioridade_selecao;
				
				for(Reg in Prioridades){
					Dados += '<option value="'+Prioridades[Reg].PrioridadeId+'">'+Prioridades[Reg].Nome+'</option>';
				}
	
				$('#PrioridadeMudanca').html(Dados);
				
				$.unblockUI();
			}
			else{
				exibeErroRecarregarPagina();
			}
		},
		error: function(){
			exibeErroRecarregarPagina();
		}
	});
}

function carregaCategorias(){
	$.blockUI({ message: '<h3>Carregando as categorias...</h3>' });
	
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
	
				$('#selectCategoriaCadTicket').html(CategoriaSelecione + Dados);
				$.unblockUI();
			}
			else{
				
				$('.retorno_ajax').html('Ocorreu um erro no servidor. Favor recarregar a página!');
				$.unblockUI();
			}
		},
		error: function(){
			$('.retorno_ajax').html('Ocorreu um erro no servidor. Favor recarregar a página!');
			$.unblockUI();
		}
	});	
}

function exibeErroRecarregarPagina(Msg){
	if(Msg == ''){
		Msg = 'Ocorreu um erro no servidor. Favor recarregar a página!';
	}
	
	$.blockUI({ message: '<h3>'+Msg+'</h3>' });
	setTimeout(
			function(){
				$.unblockUI();
			},
			3000
		);
}
</script>