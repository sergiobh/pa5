<div class='setores_listar'>
	<h2 class="glyphicon glyphicon-th-list">LISTA DE SETORES</h2>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Código</th>
				<th>Nome</th>
				<th>Gestor Responsável</th>
				<th><span class="glyphicon glyphicon-cog"></span></th>
			</tr>
		</thead>
		<tbody class='tbodySetores'>
		</tbody>
	</table>
</div>
<script type="text/javascript">
$(document).ready(function(){
	carregaSetores();
});

function carregaSetores(){
	$.blockUI({ message: '<h3>Carregando os dados...</h3>' });

	var Url = "<?php echo BASE_URL;?>/setor/montaGrid";
	var Setores;
	var Grid;

	$.ajax({
		type: "get",
		url: Url,
		dataType: 'json',
		success: function(retorno){
			if(retorno.success){
				populaGridSetores(retorno.Setores);
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
				$('.tbodySetores').html('');
			}
		},
		error: function(){
			RedirecionamentoHome();
		}
	});
}

function populaGridSetores(Setores){
	html = "";

	for(Reg in Setores){
		html += abreTR();	
			html += carregaTD(Setores[Reg].SetorId);
			html += carregaTD(Setores[Reg].Nome);
			html += carregaTD(Setores[Reg].Gestor);
			html += montaLinks(Setores[Reg].SetorId);		
		html +=fechaTR();
	}

	$(".tbodySetores").html(html);
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

function montaLinks(SetorId){
	var urlEditar = '<?php echo BASE_URL.'/setor/editar/';?>'+SetorId;
	var editar = '<div class="botao_editar"><a href='+urlEditar+' title="Editar setor '+SetorId+'"><div class="glyphicon glyphicon-pencil"></div></a></div>';
	
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
