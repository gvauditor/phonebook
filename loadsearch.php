<?php 
	require('Contact.php'); 
    $list = new Contact();

    $search = trim($_GET['search']);
 ?>
 
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

    if($list->search($search)) { 
    foreach($list->search($search) AS $row) {  
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
      <strong>Showing!</strong> search results.
    </div>

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