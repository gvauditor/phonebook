<?php 
require('Contact_Crud.php'); 

if(isset($_GET['id'])) { 
	$id = trim($_GET['id']); 

	$contact = new Contact_Crud($id,'');
	foreach($contact->select($id) AS $row) { 
		$data['firstname'] = trim($row['firstname']);
		$data['midname'] = trim(($row['midname']));
		$data['lastname'] = trim(($row['lastname']));
		$data['phone'] = trim(($row['phone']));
		$data['email'] = trim(($row['email'])); 
	}
}

if(isset($_POST['submit'])) { 
	
	$data['firstname'] = trim(($_POST['firstname']));
	$data['midname'] = trim($_POST['midname']);
	$data['lastname'] = trim($_POST['lastname']);
	$data['phone'] = trim($_POST['phone']);
	$data['email'] = trim($_POST['email']); 

	$contact = new Contact_Crud('',$data); 
	
	$msg = $contact->validate_entry(); 

	if($msg == 'success') { 
		$contact->insert(); 
		header("Location:index.php");
	} 

}
elseif(isset($_POST['update'])) { 
	
	$data['firstname'] = trim($_POST['firstname']);
	$data['midname'] = trim($_POST['midname']);
	$data['lastname'] = trim($_POST['lastname']);
	$data['phone'] = trim($_POST['phone']);
	$data['email'] = trim($_POST['email']);

	$contact = new Contact_Crud('',$data);

	$msg = $contact->validate_entry($id);
	if($msg == 'success') { 
		$contact->update($id); 
		header("Location:index.php");
	} 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Simple Phonebook Application</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery.min.js'"></script>
  <script src="js/bootstrap.min.js'"></script>
</head>
<body>

<div class="container">
        
  <h2><a href="index.php">Name and contact lookup</a></h2>
  <?php 
  if(isset($msg)) { ?> 
  	<div class="alert alert-danger">
  		<strong>Error!</strong> <?php echo $msg; ?>
	</div>
  <?php } ?>
  <form class="form-horizontal" role="form" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
  <div class="form-group">
        <div class="col-xs-4">
        <label for="firstname">Firstname</label>
        <input type="text" class="form-control" name="firstname" placeholder="Enter your firstname" value="<?php if(isset($data['firstname'])) echo $data['firstname']; ?>" maxlength="30">
      </div>
  </div>
  <div class="form-group">
        <div class="col-xs-4">
        <label for="midname">Middlename</label>
        <input type="text" class="form-control" name="midname" placeholder="Enter your middlename" value="<?php if(isset($data['midname'])) echo $data['midname']; ?>" maxlength="30">
      </div>
  </div>
  <div class="form-group">
        <div class="col-xs-4">
        <label for="lastname">Lastname</label>
        <input type="text" class="form-control" name="lastname" placeholder="Enter your lastname" value="<?php if(isset($data['lastname'])) echo $data['lastname']; ?>" maxlength="30">
      </div>
  </div>
  <div class="form-group">
        <div class="col-xs-4">
        <label for="phone">Phone Number</label>
        <input type="text" class="form-control" name="phone" placeholder="Enter your phone number" value="<?php if(isset($data['phone'])) echo $data['phone']; ?>" maxlength="11">
      </div>
  </div>
  <div class="form-group">
        <div class="col-xs-4">
        <label for="phone">Email</label>
        <input type="text" class="form-control" name="email" placeholder="Enter your email address" value="<?php if(isset($data['email'])) echo $data['email']; ?>" maxlength="50">
      </div>
  </div>
    <div class="form-group">
        <div class="col-xs-4">
        <?php 
        if(!isset($_GET['id']))
        	echo '<button type="submit" name="submit" class="btn btn-default">Submit</button>';
        else
        	echo '<button type="submit" name="update" class="btn btn-default">Update</button>';
        ?>	
      </div>
  </div>
</form>
</div>

</body>
</html>