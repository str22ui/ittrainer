<?php
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'Add Student');
// include('./adminInclude/header.php'); 
include('../dbConnection.php');

 if(isset($_SESSION['is_admin_login'])){
  $adminEmail = $_SESSION['adminLogEmail'];
 } else {
  echo "<script> location.href='../index.php'; </script>";
 }
 if(isset($_REQUEST['newStuSubmitBtn'])){
  // Checking for Empty Fields
  if(($_REQUEST['stu_name'] == "") || ($_REQUEST['stu_email'] == "") || ($_REQUEST['stu_pass'] == "") || ($_REQUEST['stu_occ'] == "")){
   // msg displayed if required field missing
   $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fields </div>';
  } else {
   // Assigning User Values to Variable
   $stu_name = $_REQUEST['stu_name'];
   $stu_email = $_REQUEST['stu_email'];
   $stu_pass = $_REQUEST['stu_pass'];
   $stu_occ = $_REQUEST['stu_occ'];

    $sql = "INSERT INTO student (stu_name, stu_email, stu_pass, stu_occ) VALUES ('$stu_name', '$stu_email', '$stu_pass', '$stu_occ')";
    if($conn->query($sql) == TRUE){
     // below msg display on form submit success
     $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Student Added Successfully </div>';
    } else {
     // below msg display on form submit failed
     $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Add Student </div>';
    }
  }
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">

  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="../css/all.min.css">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="../css/adminstyle.css">

  <!-- Custom Centering CSS -->
  <style>
    body, html {
      height: 100%;
    }
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
    }
    .jumbotron {
      width: 100%;
      max-width: 600px;
    }
  </style>
</head>
<nav class="navbar navbar-dark fixed-top p-0 shadow" style="background-color: #F0FFFF;">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="adminDashboard.php">
    <img src="../image/malogo1.png" alt="Metrodata Academy Logo" style="height: 50px;">
  </a> 
</nav>

<body>
<div class="container">
  <div class="col-sm-12 mx-3 jumbotron">
    <h3 class="text-center">Add New Student</h3>
    <form action="" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="stu_name">Name</label>
        <input type="text" class="form-control" id="stu_name" name="stu_name">
      </div>
      <div class="form-group">
        <label for="stu_email">Email</label>
        <input type="text" class="form-control" id="stu_email" name="stu_email">
      </div>
      <div class="form-group">
        <label for="stu_pass">Password</label>
        <input type="text" class="form-control" id="stu_pass" name="stu_pass">
      </div>
      <div class="form-group">
        <label for="stu_occ">Occupation</label>
        <input type="text" class="form-control" id="stu_occ" name="stu_occ">
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-danger" id="newStuSubmitBtn" name="newStuSubmitBtn">Submit</button>
        <a href="students.php" class="btn btn-secondary">Close</a>
      </div>
      <?php if(isset($msg)) {echo $msg; } ?>
    </form>
  </div>
</div>
</body>
</html>

<?php
include('./adminInclude/footer.php'); 
?>
