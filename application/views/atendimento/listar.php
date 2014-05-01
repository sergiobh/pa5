<div class='chamados_listar'>
	<h2 class="glyphicon glyphicon-th-list">&nbsp;Histórico de Atendimentos</h2>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>NÍVEL</th>
				<th>STATUS</th>
				<th>ATENDENTE</th>
				<th>DATA SOLICITAÇÃO</th>
				<th>ATIVO</th>
			</tr>
		</thead>
		<tbody class='tbodyAtendimentos'>
		</tbody>
	</table>
</div>
<script>
var TicketId = <?php echo $TicketId;?>; 

$( document ).ready( function( ) {
	listarAtendimentos();
	
});

function listarAtendimentos( ) {
	
	// Executa o GET usando metodo AJAX e retorando Json
	var Url				= '<?php echo BASE_URL;?>/atendimentoticket/montaGrid';

	var data 			= 'TicketId='+TicketId;

	$.blockUI({ message: '<h3>Carregandos os atendimentos...</h3>' });

	$.ajax({
		type: "GET",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			if(retorno.success){

				if(retorno.Atendimentos.length > 0){
					populaGridAtendimentos(retorno.Atendimentos);
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
					$('.tbodyAtendimentos').html('');
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

function populaGridAtendimentos(Atendimentos){
	var html = '';

	for(Reg in Atendimentos){
		html += abreTR();	
			html += carregaTD(Atendimentos[Reg].Tipo_Nivel);
			html += carregaTD(Atendimentos[Reg].Status);
			html += carregaTD(Atendimentos[Reg].Atendente);
			html += carregaTD(Atendimentos[Reg].DH_Solicitacao);
			html += carregaTDTitle(Atendimentos[Reg].Ativo);	
		html +=fechaTR();
	}

	$('.tbodyAtendimentos').html(html);
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
</script>