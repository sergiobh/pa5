<div class='chamados_listar'>
	<h2 class="glyphicon glyphicon-th-list">LISTA DE FUNCIONÁRIOS</h2>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Código</th>
				<th>Nome</th>
				<th>CPF</th>
				<th><span class="glyphicon glyphicon-cog"></span></th>
			</tr>
		</thead>
		<tbody class='tbodyFunc'>
		</tbody>
	</table>
</div>	
<script type="text/javascript">
$(document).ready(function(){
	$.blockUI({ message: '<h1>Carregando os dados...</h1>' });

	var Url = "<?php echo BASE_URL;?>/funcionario/montaGrid";
	var Funcionarios;
	var Grid;

	$.ajax({
		type: "get",
		url: Url,
		dataType: 'json',
		success: function(retorno){
			if(retorno.success){
				populaGridFunc(retorno.Funcionarios);
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
});

function populaGridFunc(Funcionarios){
	html = "";

	for(Reg in Funcionarios){
		html += abreTR();	
			html += carregaTD(Funcionarios[Reg].FuncionarioId);
			html += carregaTD(Funcionarios[Reg].Nome);
			html += carregaTD(Funcionarios[Reg].Cpf);
			html += montaLinks(Funcionarios[Reg].FuncionarioId);		
		html +=fechaTR();
	}

	$(".tbodyFunc").html(html);
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

function montaLinks(FuncionarioId){
	var urlEditar = '<?php echo BASE_URL.'/funcionario/editar/';?>'+FuncionarioId;
	var editar = '<div class="botao_editar"><a href='+urlEditar+' title="Editar funcionário '+FuncionarioId+'"><div class="glyphicon glyphicon-pencil"></div></a></div>';
	
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