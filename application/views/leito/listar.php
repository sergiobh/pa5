<div class='titulo_page'>Lista de Leitos</div>
<div class="leito_listar">
	<div id="leito_conteudo"></div>
	<div class="clear"></div>
<hr />
	<div class='legenda home_andar'>
		<div class='divideAndar divisor'>Legenda:</div>
		<div class='home_leito_item Liberado leg'>Liberado</div>	<!-- <div class="clear"></div> -->
		<div class='home_leito_item Arrumacao leg'>Arrumação</div>	<!-- <div class="clear"></div> -->
		<div class='home_leito_item Ocupado leg'>Ocupado</div>	<!-- <div class="clear"></div> -->
		<div class='home_leito_item Desativado leg'>Desativado</div>	<!-- <div class="clear"></div> -->
	</div>
	<div class="clear"></div>	
</div>
<script type="text/javascript">
$(document).ready(function(){
	$.blockUI({ message: '<h1>Carregando os dados...</h1>' });

	var Url = "<?php echo BASE_URL;?>/leito/getListar";

	$.ajax({
		type: "get",
		url: Url,
		dataType: 'json',
		success: function(retorno){
			if(retorno.success){
				var Leitos 		= retorno.Leitos;
				var Leito 		= "";
				var Quarto 		= "";
				var Andar 		= "";
				
				var Dados 		= "";

				for(Reg in Leitos){
					if(Andar != Leitos[Reg].Andar){
						if(Andar != ""){
							Dados += '</div></div>';
						}

						Dados 		+= '<div class="divideAndar home_andar ">';
						Dados 		+= '<div class=" divisor home_andar_item">Andar: '+Leitos[Reg].Andar+'</div>';

						Andar 		= Leitos[Reg].Andar;
						Quarto 		= "";
					}

					if(Quarto != Leitos[Reg].Quarto){
						if(Quarto != ""){
							Dados 	+= '</div>';
						}

						Dados 		+= '<div class="home_quarto">';
						Dados 		+= '<div class="home_quarto_item "><span class="homeTextQuartoLeito">'+Leitos[Reg].Quarto+'</span><br />';

						Quarto  	= Leitos[Reg].Quarto;
					}

					Dados 			+= '<a class="link_leito" href="<?php echo BASE_URL;?>/leito/editar/'+Leitos[Reg].LeitoId+'" title="Editar '+Leitos[Reg].Leito+'" >';
					Dados 			+= '<div class="boxLeito"><span class="home_leito_item '+Leitos[Reg].Status+'"></span><br /><span class="nomeLeito">'+Leitos[Reg].Leito+'</span></div>';
					Dados 			+= '</a>';
				}

				Dados 				+= "</div></div></div>";

				$("#leito_conteudo").html(Dados);

				$.unblockUI();
			}
			else{
				$('.retorno_ajax').html('Ocorreu um erro no servidor. Favor recarregar a página!');
				$.unblockUI();
			}
		},
		error: function(){
			$('.retorno_ajax').html('Ocorreu um erro no servidor. Tentar novamente!');
			$.unblockUI();
		}
	});

});
</script>