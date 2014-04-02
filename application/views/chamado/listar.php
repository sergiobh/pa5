<div class='chamados_listar'>
	<h2 class="glyphicon glyphicon-th-list">LISTA DE CHAMADOS</h2>
	<br />
	<div class="linha_botoes">
	<?php
	if ($StatusTickets) {
		$StartTicket = '';
		$StartTicketName = '';
		
		foreach ( $StatusTickets as $StatusTicket ) {
			echo '<button class="item_chamado btn ' . $StatusTicket->TipoBotao . '" statusid=' . $StatusTicket->StatusId . ' >' . $StatusTicket->Nome . '</button> ';
			if ($StartTicket === '') {
				$StartTicket = $StatusTicket->StatusId;
				$StartTicketName = $StatusTicket->Nome; 
			}
		}
	}
	?>
	</div>
	<h2 class="form-signin-heading">
		Chamados: <span id="StatusChamado"><?php echo $StartTicketName;?></span>
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
</div>
<script>
var StartTicket = <?php echo $StartTicket;?>
	
$( document ).ready( function( ) {
	listarChamados(<?php echo $StartTicket;?>);
	
	$('.item_chamado').click(function(){
		StartTicket = $(this).attr('statusid')
		listarChamados(StartTicket);
		$('#StatusChamado').html($(this).html());
	});
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
							1000
						);
					$('.tbodyChamados').html('');
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
	var exportar = '';
	
	if(StartTicket != 1){
		var urlExportar = '<?php echo BASE_URL.'/ticket_xml/exportar/';?>'+TicketId;
		exportar = '<div class="botao_exportar"><a href='+urlExportar+' title="Exportar ticket '+TicketId+'" target="_blank"><div class="glyphicon glyphicon-download-alt"></div></a></div>';
	}
	
 	return carregaTD(editar+exportar);	
}
</script>