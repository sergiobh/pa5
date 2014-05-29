

<?php
include_once("queryExec.class.php");

$consulta = new query;





$ResultadoStatus = $consulta -> consultaQuery("select s.Nome, count(a.StatusId) Qtde from ticket_atendimento a, ticket_status s 
where a.StatusId = s.StatusId group by s.Nome");

while($status = mysql_fetch_array($ResultadoStatus)){
	
	echo $status['Nome']."| Qtde:".$status['Qtde']."<br />";
	
	
}




?>