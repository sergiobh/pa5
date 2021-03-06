<div class='chamados_historicos'>
	<h2 class="glyphicon glyphicon-th-list">&nbsp;Histórico do Chamado</h2>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>DESCRIÇÃO</th>
				<th>OCORRÊNCIA</th>
				<th>USUÁRIO</th>
				<th>DATA OCORRÊNCIA</th>
				<th><span class="glyphicon glyphicon-cog"></span></th>
			</tr>
		</thead>
		<tbody class='tbodyHistoricos'>
		</tbody>
	</table>
</div>
<script>
function listarHistorico(){
	// Executa o GET usando metodo AJAX e retorando Json
	var Url				= '<?php echo BASE_URL;?>/chamado/carregarHistorico';

	var data 			= 'TicketId=<?php echo $TicketId;?>'+'&Permissao='+Ticket.Permissao;

	$.blockUI({ message: '<h1>Carregandos os Históricos...</h1>' });

	$.ajax({
		type: "GET",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			if(retorno.success){

				if(retorno.Historicos.length > 0){
					populaGridHistorico(retorno.Historicos);
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
					$('.tbodyHistoricos').html('');
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
function populaGridHistorico(Historicos){
	var html = '';
	
	for(Reg in Historicos){
		html += abreTR();	
			html += carregaTDTitleHistorico(Historicos[Reg].HistoricoTipoId, Historicos[Reg].Descricao);
			html += carregaTD(Historicos[Reg].Ocorrencia);
			html += carregaTD(Historicos[Reg].Usuario);
			html += carregaTD(Historicos[Reg].DH_Cadastro);
			html += montaLinks(Historicos[Reg].Url);		
		html +=fechaTR();
	}

	$('.tbodyHistoricos').html(html);
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
function carregaTDTitleHistorico(HistoricoTipoId, dado){
	if(HistoricoTipoId == 3 || HistoricoTipoId == 4){
		return carregaTD('Anexo'); 
	}
	
	dadoReduzido = dado.substring(0,20);

	return '<td title="'+dado+'">'+dadoReduzido+'</td>';
}
function montaLinks(URL){

	if(URL == ''){
		return carregaTD('');
	}

	var urlDownload = '<?php echo BASE_URL;?>'+URL;
	var download = '<div class="botao_download"><a href='+urlDownload+' title="Download do Anexo" target="_blank"><div class="glyphicon glyphicon-download-alt"></div></a></div>';
	
 	return carregaTD(download);	
}

</script>