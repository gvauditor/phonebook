<?php
require('Database.php');

class Contact_Crud extends Database { 
	private $fname; 
	private $midname;
	private $lname;
	private $phone;
	private $email;
	private $db;

	function __construct($id = '',$data = '') { 
		
		$this->db = parent::getInstance()->getConnection();

		if($data != '') { 
			$this->fname = mysqli_real_escape_string($this->db,$data['firstname']); 
			$this->midname = mysqli_real_escape_string($this->db,$data['midname']);
			$this->lname = mysqli_real_escape_string($this->db,$data['lastname']);
			$this->phone = mysqli_real_escape_string($this->db,$data['phone']); 
			$this->email = mysqli_real_escape_string($this->db,$data['email']);
		}
		else { 
			$result = $this->select($id); 

			foreach($result AS $row) { 
				$this->fname = mysqli_real_escape_string($this->db,$row['firstname']);
				$this->midname = mysqli_real_escape_string($this->db,$row['midname']);
				$this->lastname = mysqli_real_escape_string($this->db,$row['lastname']);
				$this->phone = mysqli_real_escape_string($this->db,$row['phone']);
				$this->email = mysqli_real_escape_string($this->db,$row['email']); 
			}
		}
	}

	function validate_entry($id = '') { 
		if($this->fname == '' || $this->midname == '' || $this->lname == '')
			$msg = 'Check the value of the name.';
		elseif(strlen($this->fname) > 30 || strlen($this->midname) > 30|| strlen($this->lname) > 30) 
			$msg = 'Maximum of 30 characters for firstname, middlename and lastname.';
		elseif(strlen($this->phone) > 11)
			$msg = 'Phone number must have a maximum of 11 characters only.';
		elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL))
			$msg = 'Invalid email address.';
		elseif(strlen($this->email) > 50)
			$msg = 'Email address must have a maximum of 50 characters only.';
		elseif($this->checkDuplicate($id) > 0)
			$msg = 'Record already exist in the database.';
		else 
			$msg = 'success';

		return $msg;
		
	}

	function runQuery($sql) { 
		$result =  $this->db->query($sql) or trigger_error($db->error."[$sql]");
	}

	function checkDuplicate($id = '') { 

		if($id != '')
			$ext = "AND id != $id "; 

		$sql = "SELECT id FROM contacts WHERE firstname = '$this->fname' AND midname = '$this->midname' AND lastname = '$this->lname' 
					AND phone='$this->phone' AND email = '$this->email' ".$ext;
		$result = $this->db->query($sql) or trigger_error($db->error."[$sql]");

		return $result->num_rows;
	}

	function insert() { 
		$sql = "INSERT INTO contacts (firstname,midname,lastname,phone,email) VALUES('$this->fname','$this->midname','$this->lname',
				'$this->phone','$this->email')";
		$result = Contact_Crud::runQuery($sql);

	}

	function update($id) { 
		$sql = "UPDATE contacts SET firstname = '$this->fname',
									midname = '$this->midname',
									lastname = '$this->lname',
									phone = '$this->phone',
									email = '$this->email',
									created = NOW() 
				WHERE id = '$id' ";

		$result = Contact_Crud::runQuery($sql);
	}

	function select($id) {

		$sql = "SELECT * FROM contacts WHERE id='$id'";
		$result =  $this->db->query($sql) or trigger_error($this->db->error."[$sql]");

		//return $result; 

		while($row = $result->fetch_assoc()) {
    		$value[] = $row;
    	}

    	return $value; 

	}
}

?>