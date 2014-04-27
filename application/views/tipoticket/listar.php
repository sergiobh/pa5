<div class='tipotickets_listar'>
	<h2 class="glyphicon glyphicon-th-list">&nbsp;LISTA DE TIPOS DE TICKET</h2>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>COD</th>
				<th>TIPO</th>
				<th>CATEGORIA</th>
				<th>PRIORIDADE</th>
				<th>SLA</th>
				<th><span class="glyphicon glyphicon-cog"></span></th>
			</tr>
		</thead>
		<tbody class='tbodyTipoTickets'>
		</tbody>
	</table>
</div>
<script type="text/javascript">
$(document).ready(function(){
	carregaTipoTickets();
});

function carregaTipoTickets(){
	$.blockUI({ message: '<h3>Carregando os dados...</h3>' });

	var Url = "<?php echo BASE_URL;?>/tipoticket/montaGrid";

	$.ajax({
		type: "get",
		url: Url,
		dataType: 'json',
		success: function(retorno){
			if(retorno.success){
				populaGridTipoTickets(retorno.TipoTickets);
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
				$('.tbodyTipoTickets').html('');
			}
		},
		error: function(){
			RedirecionamentoHome();
		}
	});
}

function populaGridTipoTickets(TipoTickets){
	html = "";

	for(Reg in TipoTickets){
		html += abreTR();	
			html += carregaTD(TipoTickets[Reg].TipoId);
			html += carregaTD(TipoTickets[Reg].Nome);
			html += carregaTD(TipoTickets[Reg].Categoria);
			html += carregaTD(TipoTickets[Reg].Prioridade);
			html += carregaTD(TipoTickets[Reg].SLA);
			html += montaLinks(TipoTickets[Reg].TipoId);		
		html +=fechaTR();
	}

	$(".tbodyTipoTickets").html(html);
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

function montaLinks(TipoId){
	var urlEditar = '<?php echo BASE_URL.'/tipoticket/editar/';?>'+TipoId;
	var editar = '<div class="botao_editar"><a href='+urlEditar+' title="Editar tipo de ticket '+TipoId+'"><div class="glyphicon glyphicon-pencil"></div></a></div>';

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
