

<?php
include_once("queryExec.class.php");

$consulta = new query;
?>
<h3>DASHBOARD</h3>
<div class="panel panel-primary floatLeft margin">
  <div class="panel-heading">POR STATUS</div>
  <div class="panel-body">
<?php
$ResultadoStatus = $consulta -> consultaQuery("select s.Nome, count(a.StatusId) Qtde from ticket_atendimento a, ticket_status s 
where a.StatusId = s.StatusId group by s.Nome");

while($status = mysql_fetch_array($ResultadoStatus)){
	echo $status['Nome']."&nbsp;<span class=\"badge\">".$status['Qtde']."</span><br />";
}
?>
  </div>
</div>




<div class="panel panel-primary floatLeft margin">
  <div class="panel-heading">POR TIPO</div>
  <div class="panel-body">
<?php
$ResultadoTipo = $consulta -> consultaQuery("select tp.nome,  count(t.TicketId) Qtde from ticket t, ticket_tipo tp
where tp.TipoId = t.TipoId group by tp.nome");

while($Tipo = mysql_fetch_array($ResultadoTipo)){
	echo $Tipo['nome']."&nbsp;<span class=\"badge\">".$Tipo['Qtde']."</span><br />";
}
?>
  </div>
</div>



<div class="panel panel-primary floatLeft margin">
  <div class="panel-heading">POR PRIORIDADE</div>
  <div class="panel-body">
<?php
$ResultadoPrioridade = $consulta -> consultaQuery("select p.nome, count(t.prioridadeId) Qtde from ticket t, ticket_prioridade p 
where p.PrioridadeId = t.PrioridadeId group by p.nome");

while($Prioridade = mysql_fetch_array($ResultadoPrioridade)){
	echo $Prioridade['nome']."&nbsp;<span class=\"badge\">".$Prioridade['Qtde']."</span><br />";
}
?>
  </div>
</div>


<div class="panel panel-primary floatLeft margin">
  <div class="panel-heading">SEM BAIXA</div>
  <div class="panel-body">
<?php
$ResultadoSemBaixa = $consulta -> consultaQuery("select p.nome, count(t.prioridadeId) Qtde from ticket t, ticket_prioridade p 
where p.PrioridadeId = t.PrioridadeId group by p.nome");

while($SemBaixa = mysql_fetch_array($ResultadoSemBaixa)){
	echo "Qtde: &nbsp;<span class=\"badge\">".$SemBaixa['Qtde']."</span><br />";
}
?>
  </div>
</div>



<div class="panel panel-primary floatLeft margin">
  <div class="panel-heading">POR FUNCIONÁRIO</div>
  <div class="panel-body">
<?php
$ResultadoPorFuncionario = $consulta -> consultaQuery("select f.Nome, count(t.FuncionarioId)Qtde from ticket t, funcionario f
where f.FuncionarioId = t.FuncionarioId group by f.Nome");

while($Funcionario = mysql_fetch_array($ResultadoPorFuncionario)){
	echo $Funcionario['Nome']."&nbsp;<span class=\"badge\">".$Funcionario['Qtde']."</span><br />";
}
?>
  </div>
</div>


<div class="panel panel-primary floatLeft margin">
  <div class="panel-heading">MEDIA DE ESPERA</div>
  <div class="panel-body">
<?php
$ResultadoPorMedia = $consulta -> consultaQuery("SELECT AVG((DATE(DH_Aceite) - DATE(DH_Solicitacao))) MEDIA FROM TICKET");

while($Media = mysql_fetch_array($ResultadoPorMedia)){
	echo "&nbsp;<span class=\"badge\">".$Media['MEDIA']." dias</span><br />";
}
?>
  </div>
</div>



<div class="panel panel-primary floatLeft margin">
  <div class="panel-heading">EM ATENDIMENTO</div>
  <div class="panel-body">
<?php
$ResultadoEmAtendimento = $consulta -> consultaQuery("select count(TicketId) Qtde from ticket where DH_Aceite is not null");

while($EmAtendimento = mysql_fetch_array($ResultadoEmAtendimento)){
	echo "Qtde:&nbsp;<span class=\"badge\">".$EmAtendimento['Qtde']."</span><br />";
}
?>
  </div>
</div>
