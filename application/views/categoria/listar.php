<div class='categorias_listar'>
	<h2 class="glyphicon glyphicon-th-list">&nbsp;LISTA DE CSTEGORIAS</h2>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Código</th>
				<th>Nome</th>
				<th><span class="glyphicon glyphicon-cog"></span></th>
			</tr>
		</thead>
		<tbody class='tbodyCategorias'>
		</tbody>
	</table>
</div>
<script type="text/javascript">
$(document).ready(function(){
	carregaCategorias();
});

function carregaCategorias(){
	$.blockUI({ message: '<h3>Carregando os dados...</h3>' });

	var Url = "<?php echo BASE_URL;?>/categoria/montaGrid";

	$.ajax({
		type: "get",
		url: Url,
		dataType: 'json',
		success: function(retorno){
			if(retorno.success){
				populaGridCategorias(retorno.Categorias);
				$.unblockUI();
			}
			else{
				$.blockUI({ message: '<h3>Nenhum registro encontrado!</h3>' });
				setTimeout(
						function(){
							$.unblockUI();
						},
						2000
					);
				$('.tbodyCategorias').html('');
			}
		},
		error: function(){
			RedirecionamentoHome();
		}
	});
}

function populaGridCategorias(Categorias){
	html = "";

	for(Reg in Categoria){
		html += abreTR();	
			html += carregaTD(Categoria[Reg].CategoriaId);
			html += carregaTD(Categoria[Reg].Nome);
			html += montaLinks(Categoria[Reg].CategoriaId);		
		html +=fechaTR();
	}

	$(".tbodyCategorias").html(html);
}

function abreTR(){
	return '<tr>';
}
function fechaTR(){
	return '</tr>';
}
function carregaTD(dado){
	return '<td>'+dado+'</td>';
}

function montaLinks(CategoriasId){
	var urlEditar = '<?php echo BASE_URL.'/categoria/editar/';?>'+CategoriaId;
	var editar = '<div class="botao_editar"><a href='+urlEditar+' title="Editar categoria '+CategoriaId+'"><div class="glyphicon glyphicon-pencil"></div></a></div>';
	
 	return carregaTD(editar);	
}

function RedirecionamentoHome(){
	$.blockUI({ message: '<h1>Ocorreu um erro no servidor<br />Redirecionando...</h1>' });

	// Efetuar o redirecionamento
	setTimeout(
		function(){
			window.location = "<?php echo BASE_URL;?>"
		},
		4000
	);					
}
</script>
