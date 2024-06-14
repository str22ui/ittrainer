<?php
if (!isset($_SESSION)) {
  session_start();
}
define('TITLE', 'Edit Lesson');
include('../dbConnection.php');

if (isset($_SESSION['is_admin_login'])) {
  $adminEmail = $_SESSION['adminLogEmail'];
} else {
  echo "<script> location.href='../index.php'; </script>";
}

// Update
if (isset($_REQUEST['requpdate'])) {
  // Checking for Empty Fields
  if (($_REQUEST['lesson_id'] == "") || ($_REQUEST['lesson_name'] == "") || ($_REQUEST['lesson_desc'] == "") || ($_REQUEST['course_id'] == "") || ($_REQUEST['course_name'] == "")) {
    $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fields </div>';
  } else {
    // Assigning User Values to Variables
    $lid = $_REQUEST['lesson_id'];
    $lname = $_REQUEST['lesson_name'];
    $ldesc = $_REQUEST['lesson_desc'];
    $cid = $_REQUEST['course_id'];
    $cname = $_REQUEST['course_name'];

    // Handling file uploads
    $llink = $_FILES['lesson_link']['name'];
    $llink_temp = $_FILES['lesson_link']['tmp_name'];
    $pdf_link = $_FILES['lesson_pdf']['name'];
    $pdf_link_temp = $_FILES['lesson_pdf']['tmp_name'];

    $llink_folder = '../lessonvid/' . $llink;
    $pdf_folder = '../lessonpdf/' . $pdf_link;

    $update_sql = "UPDATE lesson SET lesson_name='$lname', lesson_desc='$ldesc', course_id='$cid', course_name='$cname'";

    if ($llink != '') {
      move_uploaded_file($llink_temp, $llink_folder);
      $update_sql .= ", lesson_link='$llink_folder'";
    }
    if ($pdf_link != '') {
      move_uploaded_file($pdf_link_temp, $pdf_folder);
      $update_sql .= ", lesson_pdf='$pdf_folder'";
    }

    $update_sql .= " WHERE lesson_id='$lid'";

    if ($conn->query($update_sql) === TRUE) {
      $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Updated Successfully </div>';
    } else {
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
  <link rel="stylesheet" href="../css/all.min.css">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <link rel="stylesheet" href="../css/adminstyle.css">
  <style>
    body,
    html {
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
      <h3 class="text-center">Update Lesson Details</h3>
      <?php
      if (isset($_REQUEST['view'])) {
        $sql = "SELECT * FROM lesson WHERE lesson_id = {$_REQUEST['id']}";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
      }
      ?>
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="lesson_id">Lesson ID</label>
          <input type="text" class="form-control" id="lesson_id" name="lesson_id" value="<?php if (isset($row['lesson_id'])) {
                                                                                            echo $row['lesson_id'];
                                                                                          } ?>" readonly>
        </div>
        <div class="form-group">
          <label for="lesson_name">Lesson Name</label>
          <input type="text" class="form-control" id="lesson_name" name="lesson_name" value="<?php if (isset($row['lesson_name'])) {
                                                                                                echo $row['lesson_name'];
                                                                                              } ?>">
        </div>
        <div class="form-group">
          <label for="lesson_desc">Lesson Description</label>
          <textarea class="form-control" id="lesson_desc" name="lesson_desc" rows="2"><?php if (isset($row['lesson_desc'])) {
                                                                                        echo $row['lesson_desc'];
                                                                                      } ?></textarea>
        </div>
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
                                                                                              } ?>" readonly>
        </div>
        <div class="form-group">
          <label for="lesson_link">Lesson Video Link</label>
          <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="<?php if (isset($row['lesson_link'])) {
                                                          echo $row['lesson_link'];
                                                        } ?>" allowfullscreen></iframe>
          </div>
          <input type="file" class="form-control-file" id="lesson_link" name="lesson_link">
        </div>
        <div class="form-group">
          <label for="lesson_pdf">Lesson PDF</label>
          <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="<?php if (isset($row['lesson_pdf'])) {
                                                          echo $row['lesson_pdf'];
                                                        } ?>" type="application/pdf" allowfullscreen></iframe>
          </div>
          <input type="file" class="form-control-file" id="lesson_pdf" name="lesson_pdf">
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-danger" id="requpdate" name="requpdate">Update</button>
          <a href="lessons.php" class="btn btn-secondary">Close</a>
        </div>
        <?php if (isset($msg)) {
          echo $msg;
        } ?>
      </form>
    </div>
  </div>
  <script>
    function isInputNumber(evt) {
      var ch = String.fromCharCode(evt.which);
      if (!(/[0-9]/.test(ch))) {
        evt.preventDefault();
      }
    }
  </script>
</body>

</html>

<?php
include('./adminInclude/footer.php');
?>