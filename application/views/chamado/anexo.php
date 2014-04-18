<div class='chamado_anexo'>
	<form class="form-signin_upload" role="form"
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
	<form class="form-signin" role="form">
		<div class="form-group">
			<div class='RespostaUpload' id='RespostaUpload'><?php echo (isset($RespostaMsg)) ? $RespostaMsg : '';?></div>
		</div>
	</form>
</div>
<script>
$(document).ready(function(){
	$(":file").filestyle({classButton: "btn btn-primary", 'buttonText': 'Selecione...'});

	<?php if(isset($RespostaMsg)){ ?>	
		$('html, body').animate({
	        scrollTop: $("#RespostaUpload").offset().top
	    }, 2000);
		
		setTimeout(
				function(){
					$("#RespostaUpload").html("");
				},
				5000
			);
	<?php } ?>

	$(".form-signin_upload").submit(function(){
		if($(".input-large").val() == ""){
			return false;
		}	
	});
});
</script>