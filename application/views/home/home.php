<?php /*
<script type="text/javascript" src="<?php echo BASE_URL;?>/web/js/jquery/jquery.mobile-1.3.2.js"></script>
<link href="<?php echo BASE_URL; ?>/web/css/mobile/principal.css" rel="stylesheet">
<link href="<?php echo BASE_URL; ?>/web/css/mobile/jquery.mobile-1.3.2.min.css" rel="stylesheet">
*/ ?>
<div class='titulo_page'>Painel de Leitos</div>
<div class='my-page'>
	<div class="home ui-content" data-role="content" role="main">
	   	<div data-role="content">
	  		<ul id="leitos" data-role="listview" data-inset="true"></ul>
		</div>
	
		<div class="clear"></div>
	</div>
</div>
<script type="text/javascript">
	var URL_DISPONIVEL = '<?php echo BASE_URL."/web/imagens/site/mobile/disponivel.jpg";?>';
	var URL_OCUPADO = '<?php echo BASE_URL."/web/imagens/site/mobile/ocupado.jpg";?>';
	var URL_DESATIVADO = '<?php echo BASE_URL."/web/imagens/site/mobile/desativado.jpg";?>';
	var URL_ARRUMACAO = '<?php echo BASE_URL."/web/imagens/site/mobile/arrumacao.jpg";?>';

	function RedirecionamentoHome(){
		$.blockUI({ message: '<h1>Nenhum leito encontrado!</h1>' });

		// Efetuar o redirecionamento
		setTimeout(
			function(){
				$.unblockUI();
			},
			4000
		);					
	}

	function insereAndar(Andar){
		$('#leitos').append($('<li/>', {
			'data-role':'list-divider',
			'role':"heading",
			'class': 'divisor ui-li ui-li-divider ui-bar-b ui-first-child',
			'text': Andar
		}));
	}

	function insereLeito(URL, Leito, Quarto, Status, LeitoId){
		var Link = ''; 
		if(LeitoId != 0){
			Link = ','+'onClick'+':'+'Quarto('+LeitoId+')';
		}

		
		$('#leitos').append($('<li/>', {
				'class': 'ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-li-has-thumb ui-last-child ui-btn-up-d'
			}).append($('<div>', {
				'class': 'ui-btn-inner ui-li'
			}).append($('<div>', {
				'class': 'ui-btn-text'					
			}).append($('<a/>', {
				'href': '#erro'
				,'data-rel': 'popup'
				,'data-transition': 'pop'
				,'data-position-to': 'window'
				,'class': 'ui-btn ui-btn-up-d ui-btn-icon-right ui-li-has-arrow ui-li ui-li-has-thumb ui-last-child'
				+ Link
			}).append(
				$('<img/>',{
					'src': URL	
				}),$('<h2/>',{
					'text': Leito
				}),$('<p/>',{
					'class': 'ui-li-aside',
					'text': Quarto							
				}),
				$('<p/>',{
					'text': Status							
				})
			)))));
	}
	
	$(document).ready(function(){
		$.blockUI({ message: '<h1>Carregando os dados...</h1>' });

		var Url 		= "<?php echo BASE_URL;?>/home/montaIndex";
		var Conteudo 	= "";

		$.ajax({
			type: "get",
			url: Url,
			dataType: 'json',
			success: function(data){
				if(data.success){

					var andar="";
    	       		$.each(data.Leitos, function(index, d){  
						var src=""			 
						if(d.Status=="Ocupado"){
							src = URL_OCUPADO;	
	
							if(andar!=d.Andar){
	
								insereAndar(d.Andar);
	
								andar=d.Andar;
							}
	
							insereLeito();
						}
						else {					
							if(d.Status=="Liberado"){
								src = URL_DISPONIVEL;
							}
							else if(d.Status=="Ocupado"){
								src = URL_OCUPADO;
							}
							else if(d.Status=="Desativado"){
								src = URL_DESATIVADO;
							}
							else {
								src = URL_ARRUMACAO;
							}	
	
							if(andar!=d.Andar){
	
								insereAndar(d.Andar);
	
								andar=d.Andar;
							}										

							insereLeito(src, d.Leito, d.Quarto, d.Status, d.LeitoId);
							
						}
					});

					$.unblockUI();
    	       		
					//$('#leitos').listview('refresh');


					
					/*
					var Leitos	= retorno.Leitos;

					var Leito 			= '';
					var Quarto 			= '';
					var Andar			= '';
					var FecharDiv  		= false;

					for(Reg in Leitos){

						if(Andar != Leitos[Reg].Andar){						

							if(Andar != ""){
								Conteudo += "</div></div>";
							}

							Conteudo += '<div class="home_andar">';
							Conteudo += '<div class="home_andar_item">Andar: '+Leitos[Reg].Andar+'</div>';

							Andar 	  = Leitos[Reg].Andar;
							Quarto 	  = "";
							FecharDiv = true;
						}

						if(Quarto != Leitos[Reg].Quarto){
							if(Quarto != ""){
								Conteudo += '</div>';
							}

							Conteudo += '<div class="home_quarto">';
							Conteudo += '<div class="home_quarto_item">Quarto: '+Leitos[Reg].Quarto+'</div>';

							Quarto    = Leitos[Reg].Quarto;
							FecharDiv = true;
						}
					
						Conteudo += '<div class="home_leito_item '+Leitos[Reg].Status+'">Leito: '+Leitos[Reg].Leito+'</div>';
					}

					Conteudo += '</div></div>';					

					$("#home_conteudo").html(Conteudo);
					*/

					
					
				}
				else{
					RedirecionamentoHome();					
				}
			},
			error: function(){
				RedirecionamentoHome();
			}
		});
	});
</script>