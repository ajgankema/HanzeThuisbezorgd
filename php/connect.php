<?php
   //maakt een connectie met de database
 
	//maakt van database connectie gegevens geclassifiseerde informatie (private)
	class DatabaseConnectie {
	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $database = "mysb";
	private $conn;
	
	function __construct() {
		$this->conn = $this->connectDB();
	}
	
	//maakt een connectie met de database
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		return $conn;
	}
	//query uitvoeren op de database (array maken in de resulset met opgevraagde informatie)
	function runQuery($query) {
		$result = mysqli_query($this->conn,$query);
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
	}
?>