<div class='nivel_listar'>
	<h2 class="glyphicon glyphicon-th-list">&nbsp;LISTA DE NÍVEIS DO TIPO DE TICKET</h2>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>NÍVEL</th>
				<th>SETOR</th>
				<th><span class="glyphicon glyphicon-cog"></span></th>
			</tr>
		</thead>
		<tbody class='tbodyTipoNivels'>
		</tbody>
	</table>
</div>
<br />
<br />
<br />
<script type="text/javascript">
var TipoId = <?php echo (isset($TipoId)) ? $TipoId : '';?>

$(document).ready(function(){
	carregaNiveis();
});

function carregaNiveis(){
	$.blockUI({ message: '<h3>Carregando os dados...</h3>' });

	var Url = "<?php echo BASE_URL;?>/tiponivel/montaGrid";

	var data = 'TipoId='+TipoId;
	
	$.ajax({
		type: "get",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			if(retorno.success){
				populaGridTipoNivel(retorno.TipoNivels);
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
				$('.tbodyTipoNivels').html('');
			}
		},
		error: function(){
			//RedirecionamentoHome();
		}
	});
}

function populaGridTipoNivel(TipoNivels){
	html = "";

	for(Reg in TipoNivels){
		html += abreTR();	
			html += carregaTD(TipoNivels[Reg].Nivel);
			html += carregaTD(TipoNivels[Reg].Setor);
			html += montaLinksNivel(TipoNivels[Reg].TipoId, TipoNivels[Reg].Nivel);		
		html +=fechaTR();
	}

	$(".tbodyTipoNivels").html(html);
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

function montaLinksNivel(TipoId, NivelId){
	var urlEditar = '<?php echo BASE_URL.'/tiponivel/editar/';?>'+TipoId+'/'+NivelId;
	var editar = '<div class="botao_editar"><a href='+urlEditar+' title="Editar nível do tipo de ticket '+NivelId+'"><div class="glyphicon glyphicon-pencil"></div></a></div>';

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