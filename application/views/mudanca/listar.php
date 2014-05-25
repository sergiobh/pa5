<div class='mudancas_listar'>
	<h2 class="glyphicon glyphicon-th-list">&nbsp;LISTA DE MUDANÇAS</h2>
	<br />
	<div class="linha_botoes">
	<?php
	if ($Prioridades) {
		$StartMudanca = '';
		$StartMudancaName = '';

		foreach ( $Prioridades as $Prioridade ) {
			echo '<button class="item_mudanca btn ' . $Prioridade->TipoBotao . '" prioridadeid=' . $Prioridade->PrioridadeId . ' >' . $Prioridade->Nome . '</button> ';
			if ($StartMudanca === '') {
				$StartMudanca = $Prioridade->PrioridadeId;
				$StartMudancaName = $Prioridade->Nome; 
			}
		}
	}
	?>
	</div>
	<h2 class="form-signin-heading">
		Mudancas: <span id="StatusMudanca"><?php echo $StartMudancaName;?></span>
	</h2>
	<hr />
	
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Nº</th>
				<th>NOME</th>
				<th>PRIORIDADE</th>
				<th>AUTORIZAÇÃO</th>
				<th>AVALIAÇÃO</th>
				<th>DATA SOLICITAÇÃO</th>
				<th><span class="glyphicon glyphicon-cog"></span></th>
			</tr>
		</thead>
		<tbody class='tbodyMudancas'>
		</tbody>
	</table>
</div>
<script>
var StartMudanca = <?php echo $StartMudanca;?>
	
$( document ).ready( function( ) {
	listarMudancas(<?php echo $StartMudanca;?>);
	
	$('.item_mudanca').click(function(){
		StartMudanca = $(this).attr('prioridadeid')
		listarMudancas(StartMudanca);
		$('#StatusMudanca').html($(this).html());
	});
});

function listarMudancas( PrioridadeId ) {
	
	// Executa o GET usando metodo AJAX e retorando Json
	var Url				= '<?php echo BASE_URL;?>/mudanca/listarMudancas';

	var data 			= 'PrioridadeId='+PrioridadeId;

	$.blockUI({ message: '<h3>Carregando as mudancas...</h3>' });

	$.ajax({
		type: "GET",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			if(retorno.success){
				//alert(count(Mudancas));
				if(retorno.Mudancas.length > 0){
					populaGrid(retorno.Mudancas);
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
					$('.tbodyMudancas').html('');
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

function populaGrid(Mudancas){
	var html = '';
	
	for(Reg in Mudancas){
		html += abreTR();	
			html += carregaTD(Mudancas[Reg].MudancaId);
			html += carregaTD(Mudancas[Reg].Nome);
			html += carregaTD(Mudancas[Reg].Prioridade);
			html += carregaTD(Mudancas[Reg].Autorizacao);
			html += carregaTD(Mudancas[Reg].Avaliacao);
			html += carregaTD(Mudancas[Reg].DH_Solicitacao);
			html += montaLinks(Mudancas[Reg].MudancaId);
		html +=fechaTR();
	}

	$('.tbodyMudancas').html(html);
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
function montaLinks(MudancaId){
	var urlEditar = '<?php echo BASE_URL.'/mudanca/editar/';?>'+MudancaId;
	var editar = '<div class="botao_editar"><a href='+urlEditar+' title="Editar mudança '+MudancaId+'"><div class="glyphicon glyphicon-pencil"></div></a></div>';
	var exportar = '';
		
 	return carregaTD(editar);	
}
</script>