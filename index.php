<?php require('Contact.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Simple Phonebook Application</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <div class="table-responsive">          
  <h2><a href="index.php">Name and contact lookup</a></h2>
      <div class="alert alert-warning">
      <strong>Disclaimer!</strong> Data is for testing purposes only. If data matches a true person, the data may not be accurate.
    </div>
  <div class="row">
  <div class="col-sm-8"> <a href="addcontact.php"><button type="button" class="btn btn-primary">Add New Record</button></a></div>
    <div class="col-sm-4"> 
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search" id="searchText">
        <div class="input-group-btn">
          <button class="btn btn-default" type="button" id="searchBtn"><i class="glyphicon glyphicon-search"></i></button>
        </div>
      </div>
    </div>
</div>
  <div id="tableholder">
  <table class="table">
    <thead>
      <tr>
        <th>Record #</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>&nbsp;</th>  
      </tr>
    </thead>
    <tbody>
    <?php
    $list = new Contact();

    if($list->showLastTen()) {
    foreach($list->showLastTen() AS $row) {  
    ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['phone']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td>      
          <a href="addcontact.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-default btn-sm">
            <span class="glyphicon glyphicon-edit"></span> Edit
          </button></a>
        </td>  
      </tr>
      <?php } } ?>
    </tbody>
  </table>
    <div class="alert alert-info">
      <strong>Info!</strong> Showing the last 10 saved records.
    </div>
  </div>
  </div>
</div>

</body>
</html>
<script>
$(document).ready(function(){
    $("#searchBtn").click(function(){
        var searchval = $("#searchText").val();
        searchval = searchval.trim();

        if(searchval.length < 2) 
            alert('Enter at least 2 character to search.');
        else { 
            $("#tableholder").load("loadsearch.php?search="+searchval, function(responseTxt, statusTxt, xhr){
                //
            });
        }
    });
});
</script>