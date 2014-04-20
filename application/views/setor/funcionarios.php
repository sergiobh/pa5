<div class='setores_funcionarios'>
	<h2 class="glyphicon glyphicon-th-list">PERMISSÃO DE FUNCIONÁRIOS</h2>
	<h2 class="form-signin-heading">
		SETOR: <span id="title_setor"></span>
	</h2>
	<form class="form-inline" role="form">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Código</th>
					<th>Nome</th>
					<th>Cpf</th>
					<th><span class="glyphicon glyphicon-cog"></span></th>
				</tr>
			</thead>
			<tbody class='tbodyFuncionarios'>
			</tbody>
		</table>
	</form>
	<form class="form_setorfuncionarios" role="form">
		<button class="btn btn-sm btn btn-success btn-block botao_direita">Salvar</button>
	</form>
</div>
<script type="text/javascript">
var SetorId = <?php echo $SetorId;?>

$(document).ready(function(){
	carregaFuncionarios();
	
	$( ".form_setorfuncionarios" ).submit( function( ) {
		submeterFormSetorFuncionarios();

		return false;
	} );
});

function carregaFuncionarios(){
	$.blockUI({ message: '<h3>Carregando os dados...</h3>' });

	var Url = "<?php echo BASE_URL;?>/funcionario/montaGrid";
	
	$.ajax({
		type: "get",
		url: Url,
		dataType: 'json',
		success: function(retorno){
			if(retorno.success){
				populaGridFuncionarios(retorno.Funcionarios);
				$.unblockUI();
			}
			else{
				exibeMensagem('Nenhum registro encontrado!');
				$('.tbodyFuncionarios').html('');
			}
		},
		error: function(){
			exibeMensagem();
		}
	});
}

function populaGridFuncionarios(Funcionarios){
	var html = '';
	
	for(Reg in Funcionarios){
		html += abreTR();	
			html += carregaTD(Funcionarios[Reg].FuncionarioId);
			html += carregaTD(Funcionarios[Reg].Nome);
			html += carregaTD(Funcionarios[Reg].Cpf);
			html += montaCheckBox(Funcionarios[Reg].FuncionarioId);		
		html +=fechaTR();
	}

	$('.tbodyFuncionarios').html(html);

	montaPermissoes();
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

function montaCheckBox(funcionarioId){
	return carregaTD('<input type="checkbox" name="SetorFuncionarioCheck" class="SetorFuncionarioCheck" funcionarioId="' + funcionarioId + '" >');
}

function exibeMensagem(msg, redirect){
	if(msg == ''){
		msg = 'Ocorreu um erro no servidor<br />Redirecionando...';
		redirect = 'home';
	}

	$.blockUI({ message: '<h3>'+ msg +'</h3>' });

	// Efetuar o redirecionamento
	setTimeout(
		function(){
			if(redirect == 'home'){
				window.location = "<?php echo BASE_URL;?>";
			}
			else if(redirect == 'lista'){
				window.location = "<?php echo BASE_URL;?>/setor/listar";
			}
			else{
				$.unblockUI();
			}
		},
		2000
	);					
}

function montaPermissoes(){
	$.blockUI({ message: '<h3>Carregando as permissões...</h3>' });

	var Url = "<?php echo BASE_URL;?>/setor/getPermissoes";
	var data = 'SetorId='+SetorId;
	
	$.ajax({
		type: "get",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			if(retorno.success){
				populaPermissoes(retorno.Permissoes);
			}

			populaSetor(retorno.Setor);
			$.unblockUI();			
		},
		error: function(){
			exibeMensagem();
		}
	});
}

function populaPermissoes( Permissoes ){
	for ( var Reg in Permissoes ) {
		$('.SetorFuncionarioCheck[funcionarioId=' + Permissoes[Reg].FuncionarioId + ']').prop('checked', 'checked');
	}
}

function populaSetor(Setor){
	$("#title_setor").html(Setor.Nome);
}

function submeterFormSetorFuncionarios(){
	var Funcionarios = new Array();

	$('.SetorFuncionarioCheck:checked').each(function (){
		Funcionarios.push( $(this).attr("funcionarioId") );
	});

	var ListFuncionarios = JSON.stringify(Funcionarios);
	
	$.blockUI({ message: '<h3>Salvando as permissões...</h3>' });

	var Url = "<?php echo BASE_URL;?>/setor/setPermissoes";
	var data = 'SetorId='+SetorId+'&Funcionarios='+ListFuncionarios;
	
	$.ajax({
		type: "post",
		url: Url,
		data: data,
		dataType: 'json',
		success: function(retorno){
			exibeMensagem(retorno.msg, 'lista');
		},
		error: function(){
			exibeMensagem();
		}
	});
}
</script>