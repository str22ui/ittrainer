<?php
if (!isset($_SESSION)) {
  session_start();
}
define('TITLE', 'Edit Course');
include('../dbConnection.php');

if (isset($_SESSION['is_admin_login'])) {
  $adminEmail = $_SESSION['adminLogEmail'];
} else {
  echo "<script> location.href='../index.php'; </script>";
}

// Update
if (isset($_REQUEST['requpdate'])) {
  // Checking for Empty Fields
  if (($_REQUEST['course_id'] == "") || ($_REQUEST['course_name'] == "") || ($_REQUEST['course_desc'] == "") || ($_REQUEST['course_author'] == "") || ($_REQUEST['course_duration'] == "")) {
    // msg displayed if required field missing
    $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fields </div>';
  } else {
    // Assigning User Values to Variable
    $cid = $_REQUEST['course_id'];
    $cname = $_REQUEST['course_name'];
    $cdesc = $_REQUEST['course_desc'];
    $cauthor = $_REQUEST['course_author'];
    $cduration = $_REQUEST['course_duration'];

    if (!empty($_FILES['course_img']['name'])) {
      $cimg = '../image/courseimg/' . $_FILES['course_img']['name'];
      move_uploaded_file($_FILES['course_img']['tmp_name'], $cimg);
    } else {
      $cimg = $_REQUEST['existing_img'];
    }

    $sql = "UPDATE course SET course_id = '$cid', course_name = '$cname', course_desc = '$cdesc', course_author='$cauthor', course_duration='$cduration', course_img='$cimg' WHERE course_id = '$cid'";
    if ($conn->query($sql) === TRUE) {
      // below msg display on form submit success
      $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Updated Successfully </div>';
    } else {
      // below msg display on form submit failed
      $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Update </div>';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo TITLE; ?></title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="../css/all.min.css">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../css/adminstyle.css">
</head>
<nav class="navbar navbar-dark fixed-top p-0 shadow" style="background-color: #F0FFFF;">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="adminDashboard.php">
    <img src="../image/malogo1.png" alt="Metrodata Academy Logo" style="height: 50px;">
  </a>
</nav>

<body>
  <div class="d-flex justify-content-center mt-5">
    <div class="col-sm-6 jumbotron">
      <h3 class="text-center">Update Course Details</h3>
      <?php
      if (isset($_REQUEST['view'])) {
        $sql = "SELECT * FROM course WHERE course_id = {$_REQUEST['id']}";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
      }
      ?>
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="course_id">Course ID</label>
          <input type="text" class="form-control" id="course_id" name="course_id" value="<?php if (isset($row['course_id'])) {
                                                                                            echo $row['course_id'];
                                                                                          } ?>" readonly>
        </div>
        <div class="form-group">
          <label for="course_name">Course Name</label>
          <input type="text" class="form-control" id="course_name" name="course_name" value="<?php if (isset($row['course_name'])) {
                                                                                                echo $row['course_name'];
                                                                                              } ?>">
        </div>
        <div class="form-group">
          <label for="course_desc">Course Description</label>
          <textarea class="form-control" id="course_desc" name="course_desc" rows="2"><?php if (isset($row['course_desc'])) {
                                                                                        echo $row['course_desc'];
                                                                                      } ?></textarea>
        </div>
        <div class="form-group">
          <label for="course_author">Trainer</label>
          <input type="text" class="form-control" id="course_author" name="course_author" value="<?php if (isset($row['course_author'])) {
                                                                                                    echo $row['course_author'];
                                                                                                  } ?>">
        </div>
        <div class="form-group">
          <label for="course_duration">Course Duration</label>
          <input type="text" class="form-control" id="course_duration" name="course_duration" value="<?php if (isset($row['course_duration'])) {
                                                                                                        echo $row['course_duration'];
                                                                                                      } ?>">
        </div>
        <div class="form-group">
          <label for="course_img">Course Image</label>
          <img src="<?php if (isset($row['course_img'])) {
                      echo $row['course_img'];
                    } ?>" alt="courseimage" class="img-thumbnail">
          <input type="file" class="form-control-file" id="course_img" name="course_img">
          <input type="hidden" name="existing_img" value="<?php if (isset($row['course_img'])) {
                                                            echo $row['course_img'];
                                                          } ?>">
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-danger" id="requpdate" name="requpdate">Update</button>
          <a href="courses.php" class="btn btn-secondary">Close</a>
        </div>
        <?php if (isset($msg)) {
          echo $msg;
        } ?>
      </form>
    </div>
  </div>
</body>

</html>
<?php
include('./adminInclude/footer.php');
?>