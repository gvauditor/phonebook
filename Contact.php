<?php
require('Database.php'); 

class Contact extends Database { 

	private $userid;
	private $fname;
	private $midname;
	private $phone; 
	private $db; 

	function __construct() { 
		$this->db = parent::getInstance()->getConnection();
	}

	function runQuery($sql) { 
			
		$result =  $this->db->query($sql) or trigger_error($db->error."[$sql]");

		//return $result; 
		if($result->num_rows > 0) { 
			while($row = $result->fetch_assoc()) {
    			$value[] = $row;
    		}
    	}
    	else { 
    		$value = false;
    	}	
    	return $value;
	}

	function showLastTen() { 
		$sql = "SELECT id,CONCAT(firstname,' ',midname,' ',lastname) AS name,phone,email FROM contacts ORDER BY created DESC LIMIT 10";
		$result = Contact::runQuery($sql); 

		return $result; 
	}

	function search($search) { 
		
		$search = mysqli_real_escape_string($this->db,$search); 

		$sql = "SELECT id,CONCAT(firstname,' ',midname,' ',lastname) AS name,phone,email FROM contacts 
				WHERE firstname LIKE '%$search%' OR midname LIKE '%$search%' OR lastname LIKE '%search%' OR phone LIKE '%$search%' OR 
					email LIKE '%$search%'
				ORDER BY created";
		$result = Contact::runQuery($sql); 

		return $result; 
	}
}
?>