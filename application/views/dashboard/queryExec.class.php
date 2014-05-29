<?php
    
    
class query{
    	
		  var $qtdeLinhas;
		
		function consultaQuery($query){
			
			$resultadoQuery = mysql_query($query);
			$linhas = mysql_num_rows($resultadoQuery);
			
			$this ->qtdeLinhas = $linhas;
			
			return $resultadoQuery;

		} 
		
		function getLinhas(){
			return $this ->qtdeLinhas;
		}
		
		
		
		
    }
    
    
    
    
    
?>