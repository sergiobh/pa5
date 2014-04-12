<form class="form-signin" role="form">
	<h2 class="form-signin-heading">Cadastro de Chamados</h2>
	<div class="form-group">
		<label>Categoria:</label> <select id="selectCategoriaCadTicket"
			name="selectCategoriaCadTicket" autofocus class="form-control">
		</select>
	</div>

	<div class="form-group">

		<label>Tipo de solicitação:</label> <select id="tipoSolicitacao"
			name="tipoSolicitacao" value="" class="form-control">

		</select>
	</div>
	<div class="form-group">
		<label>Descrição do Ticket:</label>
		<textarea id="descricaoTicket" name="descricaoTicket" type="text"
			value="" class="form-control" placeholder="Descrição do Incidente"></textarea>
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

var TipoSolicitacaoDependendo = '<option value="">Tipo de Solicitação: (Selecione a Categoria)</option>';
var TipoSolicitacaoSelecione = '<option value="">Tipo de Solicitação: (Selecione)</option>';


$( document ).ready( function( ) {
	limpaTipoSolicitacao();
	carregaCategorias();	

	var validator = $( ".form-signin" ).validate( {
		debug: true,
		//onsubmit: false,
		rules: ( "add", {
			selectCategoriaCadTicket: {
				required: true

			},
			tipoSolicitacao: {
				required: true
			},
			descricaoTicket: {
				required: true,
				minlength: 5
			}
		} ),
		messages: {
			selectCategoriaCadTicket: {
				required: "Campo obrigatório"

			},
			tipoSolicitacao: {
				required: "Campo obrigatório"

			},
			descricaoTicket: {
				required: "Campo obrigatório",
				minlength: "Digite pelo menos 5 caracteres"

			}
		}
	} );

	$( ".form-signin" ).submit( function( ) {
		if( validator.form( ) ) {
			submerterForm( );
		}

		return false;
	} );

	$('#selectCategoriaCadTicket').change(function(){
		var CategoriaId = $(this).val();

		if(CategoriaId == ''){
			$('#tipoSolicitacao').html(TipoSolicitacaoDependendo);
		}
		else{
			carregaTipoSolicitacao(CategoriaId);
		}
	});

	// Reset
	$('.botao_reset').click(function(){
		$('#descricaoTicket').val('');
		carregaTipoSolicitacao();
		$('#selectCategoriaCadTicket').val('');
		
		return false;
	});
	
});

function submerterForm( ) {
	// Declaração de variaveis
	var CategoriaId 	= $("#selectCategoriaCadTicket option:selected").val();
	var TipoSolicitacaoId		= $("#tipoSolicitacao option:selected").val();
	var Descricao = $("#descricaoTicket").val();
	
	// Executa o POST usando metodo AJAX e retorando Json
	var Url				= '<?php echo BASE_URL;?>/chamado/salvarCadastro';

	var data 			= 'CategoriaId='+CategoriaId+'&TipoSolicitacaoId='+TipoSolicitacaoId+'&Descricao='+Descricao;

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

function limpaTipoSolicitacao(){
	$('#tipoSolicitacao').html(TipoSolicitacaoDependendo);
}

// Função para carregar os Tipo de Solicitação
function carregaTipoSolicitacao(CategoriaId){
	var Url		= '<?php echo BASE_URL;?>/tiposolicitacao/getTipoSolicitacao';
	var data 	= 'CategoriaId='+CategoriaId;

	$.blockUI({ message: '<h1>Carregando os Tipos de Solicitação...</h1>' });

	$.ajax({
		type: "get",
		url: Url,
		data: data,
		dataType: 'json',		
		success: function(retorno){
			var Dados = "";

			if(retorno.success){
				var TipoSolicitacao = retorno.TipoSolicitacao;

				for(Reg in TipoSolicitacao){
					Dados += '<option value="'+TipoSolicitacao[Reg].tipoid+'">'+TipoSolicitacao[Reg].nome+'</option>';
				}

				$('#tipoSolicitacao').html(TipoSolicitacaoSelecione + Dados);
				$.unblockUI();
			}
			else{
				$('.retorno_ajax').html('Ocorreu um erro no servidor. Favor recarregar a página!');
				$.unblockUI();
			}
		},
		error: function(){
			$('.retorno_ajax').html('Ocorreu um erro no servidor. Favor recarregar a página!');
			
			setTimeout(
				function(){
					$.unblockUI();
				},
				4000
			);
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
</script>