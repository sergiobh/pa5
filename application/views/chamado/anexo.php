<div class='chamado_anexo'>
	<form class="form-signin" role="form"
		action="<?php echo BASE_URL."/chamado/editar/".$TicketId;?>"
		method="post" enctype="multipart/form-data">
		<h2 class="form-signin-heading">Anexar Documentos ao Chamado</h2>
		<div class="form-group">
			<input type="file" name="ticketFile" class="filestyle"
				data-classButton="btn btn-primary">
		</div>
		<div class="form-group">
			<div class="linha_botoes">
				<button class="btn btn-sm btn btn-success btn-block botao_submit">Enviar</button>
			</div>
		</div>
	</form>
	<div class='RespostaXml'><?php echo (isset($RespostaXml)) ? $RespostaXml : '';?></div>
</div>
<script>
$(document).ready(function(){
	$(":file").filestyle({classButton: "btn btn-primary", 'buttonText': 'Selecione...'});
});
</script>