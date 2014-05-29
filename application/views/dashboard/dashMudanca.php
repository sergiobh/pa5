

<?php
include_once("queryExec.class.php");

$consulta = new query;
?>
<h3>DASHBOARD DE MUDANÇA</h3>


<div class="panel panel-primary floatLeft margin">
  <div class="panel-heading">QTDE TOTAL DE SOLICITAÇÕES</div>
  <div class="panel-body">
<?php
$ResultadOTotal = $consulta -> consultaQuery("select count(MudancaId)Qtde from mudanca");

while($Total = mysql_fetch_array($ResultadOTotal)){
	echo "Qtde: &nbsp;<span class=\"badge\">".$Total['Qtde']."</span><br />";
}
?>
  </div>
</div>


<div class="panel panel-primary floatLeft margin">
  <div class="panel-heading">POR PRIORIDADE</div>
  <div class="panel-body">
<?php
$ResultadoPrioridade = $consulta -> consultaQuery("select tp.Nome, count(m.MudancaId) Qtde from mudanca m, ticket_prioridade tp 
where tp.PrioridadeId = m.PrioridadeId  group by tp.nome");

while($Prioridade = mysql_fetch_array($ResultadoPrioridade)){
	echo $Prioridade['Nome']."&nbsp;<span class=\"badge\">".$Prioridade['Qtde']."</span><br />";
}
?>
  </div>
</div>


<div class="panel panel-primary floatLeft margin">
  <div class="panel-heading">POR FUNCIONÁRIO</div>
  <div class="panel-body">
<?php
$ResultadoPorFuncionario = $consulta -> consultaQuery("select f.Nome, count(m.UsuarioId)Qtde from mudanca m, funcionario f 
where m.UsuarioId = f.FuncionarioId group by f.nome");

while($Funcionario = mysql_fetch_array($ResultadoPorFuncionario)){
	echo $Funcionario['Nome']."&nbsp;<span class=\"badge\">".$Funcionario['Qtde']."</span><br />";
}
?>
  </div>
</div>


<div class="panel panel-primary floatLeft margin">
  <div class="panel-heading">QTDE POR STATUS</div>
  <div class="panel-body">
<?php
$ResultadoStatus = $consulta -> consultaQuery("select ts.Nome, count(mu.StatusId)Qtde from mudanca mu, mudanca_status ts 
where mu.StatusId = ts.StatusId group by ts.nome");

while($status = mysql_fetch_array($ResultadoStatus)){
	echo $status['Nome']."&nbsp;<span class=\"badge\">".$status['Qtde']."</span><br />";
}
?>
  </div>
</div>


<div class="panel panel-primary floatLeft margin">
  <div class="panel-heading">QTDE DE TICKETS<BR /> QUE GERARAM MUDANÇA</div>
  <div class="panel-body">
<?php
$ResultadoTicketsMudanca = $consulta -> consultaQuery("select count(VinculoId)Qtde from vinculo_mudanca_ticket");

while($TMudanca = mysql_fetch_array($ResultadoTicketsMudanca)){
	echo "Qtde: &nbsp;<span class=\"badge\">".$TMudanca['Qtde']."</span><br />";
}
?>
  </div>
</div>


<div class="panel panel-primary floatLeft margin">
  <div class="panel-heading">DIAS DE ESPERA</div>
  <div class="panel-body">
<?php
$ResultadoDias = $consulta -> consultaQuery("select nome, (CURDATE() - date(DH_Solicitacao)) dias from mudanca where StatusId = 1");

while($DiasEspera = mysql_fetch_array($ResultadoDias)){
	echo $DiasEspera['nome']."&nbsp;<span class=\"badge\">".$DiasEspera['dias']."</span><br />";
}
?>
  </div>
</div>



<div class="panel panel-primary floatLeft margin">
  <div class="panel-heading">MEDIA DE ESPERA</div>
  <div class="panel-body">
<?php
$ResultadoPorMedia = $consulta -> consultaQuery("select avg((CURDATE() - date(DH_Solicitacao))) dias from mudanca where StatusId = 1");

while($Media = mysql_fetch_array($ResultadoPorMedia)){
	echo "&nbsp;<span class=\"badge\">".$Media['dias']." dias</span><br />";
}
?>
  </div>
</div>


