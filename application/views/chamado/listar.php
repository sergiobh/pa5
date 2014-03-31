<h2 class="glyphicon glyphicon-th-list">LISTA DE CHAMADOS</h2>
<p></p>
<div class="linha_botoes">
	<button class="btn btn-success">Aberto</button>
	<button class="btn btn-warning">Aguardando Resposta</button>
	<button class="btn btn-info">Em manutenção</button>
	<button class="btn btn-danger">Fechado</button>
	<button class="btn btn-primary">Cancelado</button>
	<button class="btn btn-danger">Indeferido</button>
</div>
<h2 class="form-signin-heading">
	Chamados <span id="StatusChamado">Aberto</span>
</h2>
<hr />

<table class="table table-hover">
	<thead>
		<tr>
			<th>Nº</th>
			<th>CATEGORIA</th>
			<th>TIPO SOLICITAÇÃO</th>
			<th>DATA SOLICITAÇÃO</th>
			<th>DESCRIÇÃO</th>
			<th>PREVISÃO</th>
			<th>PRIORIDADE</th>
			<th><span class="glyphicon glyphicon-cog"></span></th>
		</tr>
	</thead>
	<tbody class='tbodyChamados'>
	</tbody>
</table>
<script>
$( document ).ready( function( ) {
	listarChamados(1);
});

function listarChamados( StatusId ) {
	
	// Executa o GET usando metodo AJAX e retorando Json
	var Url				= '<?php echo BASE_URL;?>/chamado/listarChamados';

	var data 			= 'StatusId='+StatusId;

	$.blockUI({ message: '<h1>Carregandos os chamados...</h1>' });

	$.ajax({
		type: "GET",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			if(retorno.success){
				//alert(count(Chamados));
				if(retorno.Chamados.length > 0){
					populaGrid(retorno.Chamados);
					$.unblockUI();					
				}
				else{
					$.blockUI({ message: '<h2>Nenhum registro encontrado!</h2>' });
					setTimeout(
							function(){
								$.unblockUI();
							},
							4000
						);
				}
			}
			else{
				// Se php retornou erro irá salvar o retorno da div "retorno"
				$.blockUI({ message: '<h2>'+retorno.msg+'</h2>' });
				$.unblockUI();
			}
		},
		error: function(){
			$.blockUI({ message: '<h3>Ocorreu um erro no servidor. Tentar novamente!</h3>' });
			$.unblockUI();
		}
	});

	
}

function populaGrid(Chamados){
	var html = '';
	
	for(Reg in Chamados){
		html += abreTR();	
			html += carregaTD(Chamados[Reg].TicketId);
			html += carregaTD(Chamados[Reg].Categoria);
			html += carregaTD(Chamados[Reg].TipoSolicitacao);
			html += carregaTD(Chamados[Reg].DH_Solicitacao);
			html += carregaTDTitle(Chamados[Reg].Descricao);
			html += carregaTD(Chamados[Reg].DH_Previsao);
			html += carregaTD(Chamados[Reg].Prioridade);
			html += montaLinks(Chamados[Reg].TicketId);		
		html +=fechaTR();
	}

	$('.tbodyChamados').html(html);
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
function carregaTDTitle(dado){
	dadoReduzido = dado.substring(0,20);

	return '<td title="'+dado+'">'+dadoReduzido+'</td>';
}
function montaLinks(TicketId){
	var urlEditar = '<?php echo BASE_URL.'/chamado/editar/';?>'+TicketId;
	var editar = '<div class="botao_editar"><a href='+urlEditar+' title="Editar ticket '+TicketId+'"><div class="glyphicon glyphicon-pencil"></div></a></div>';

	var urlExportar = '<?php echo BASE_URL.'/ticket_xml/exportar/';?>'+TicketId;
	var exportar = '<div class="botao_exportar"><a href='+urlExportar+' title="Exportar ticket '+TicketId+'" target="_blank"><div class="glyphicon glyphicon-download-alt"></div></a></div>';
	
 	return carregaTD(editar+exportar);	
}
</script>