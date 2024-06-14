<?php
if (!isset($_SESSION)) {
  session_start();
}
define('TITLE', 'Add Lesson');
include('../dbConnection.php');

if (isset($_SESSION['is_admin_login'])) {
  $adminEmail = $_SESSION['adminLogEmail'];
} else {
  echo "<script> location.href='../index.php'; </script>";
}

if (isset($_REQUEST['lessonSubmitBtn'])) {
  // Checking for Empty Fields
  if (($_REQUEST['lesson_name'] == "") || ($_REQUEST['lesson_desc'] == "") || ($_REQUEST['course_id'] == "") || ($_REQUEST['course_name'] == "")) {
    // msg displayed if required field missing
    $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fields </div>';
  } else {
    // Assigning User Values to Variable
    $lesson_name = $_REQUEST['lesson_name'];
    $lesson_desc = $_REQUEST['lesson_desc'];
    $course_id = $_REQUEST['course_id'];
    $course_name = $_REQUEST['course_name'];

    $lesson_link = $_FILES['lesson_link']['name'];
    $lesson_link_temp = $_FILES['lesson_link']['tmp_name'];
    $link_folder = '../lessonvid/' . $lesson_link;
    move_uploaded_file($lesson_link_temp, $link_folder);

    $lesson_pdf = $_FILES['lesson_pdf']['name'];
    $lesson_pdf_temp = $_FILES['lesson_pdf']['tmp_name'];
    $pdf_folder = '../lessonpdf/' . $lesson_pdf;
    move_uploaded_file($lesson_pdf_temp, $pdf_folder);

    $sql = "INSERT INTO lesson (lesson_name, lesson_desc, lesson_link, lesson_pdf, course_id, course_name) VALUES ('$lesson_name', '$lesson_desc', '$link_folder', '$pdf_folder', '$course_id', '$course_name')";
    if ($conn->query($sql) === TRUE) {
      // below msg display on form submit success
      $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Lesson Added Successfully </div>';
    } else {
      // below msg display on form submit failed
      $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Add Lesson </div>';
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
  <div class="col-sm-6 mt-5 mx-auto jumbotron">
    <h3 class="text-center">Add New Lesson</h3>
    <form action="" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="course_id">Course ID</label>
        <input type="text" class="form-control" id="course_id" name="course_id" value="<?php if (isset($_SESSION['course_id'])) {
                                                                                          echo $_SESSION['course_id'];
                                                                                        } ?>" readonly>
      </div>
      <div class="form-group">
        <label for="course_name">Course Name</label>
        <input type="text" class="form-control" id="course_name" name="course_name" value="<?php if (isset($_SESSION['course_name'])) {
                                                                                              echo $_SESSION['course_name'];
                                                                                            } ?>" readonly>
      </div>
      <div class="form-group">
        <label for="lesson_name">Lesson Name</label>
        <input type="text" class="form-control" id="lesson_name" name="lesson_name">
      </div>
      <div class="form-group">
        <label for="lesson_desc">Lesson Description</label>
        <textarea class="form-control" id="lesson_desc" name="lesson_desc" rows="2"></textarea>
      </div>
      <div class="form-group">
        <label for="lesson_pdf">Upload PDF</label>
        <input type="file" class="form-control-file" id="lesson_pdf" name="lesson_pdf">
      </div>
      <div class="form-group">
        <label for="lesson_link">Lesson Video Link</label>
        <input type="file" class="form-control-file" id="lesson_link" name="lesson_link">
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-danger" id="lessonSubmitBtn" name="lessonSubmitBtn">Submit</button>
        <a href="lessons.php" class="btn btn-secondary">Close</a>
      </div>
      <?php if (isset($msg)) {
        echo $msg;
      } ?>
    </form>
  </div>
  <!-- Only Number for input fields -->
  <script>
    function isInputNumber(evt) {
      var ch = String.fromCharCode(evt.which);
      if (!(/[0-9]/.test(ch))) {
        evt.preventDefault();
      }
    }
  </script>
  <!-- Jquery and Bootstrap JavaScript -->
  <script type="text/javascript" src="../js/jquery.min.js"></script>
  <script type="text/javascript" src="../js/popper.min.js"></script>
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
  <!-- Font Awesome JS -->
  <script type="text/javascript" src="../js/all.min.js"></script>
  <!-- Admin Ajax Call JavaScript -->
  <script type="text/javascript" src="..js/adminajaxrequest.js"></script>
  <!-- Custom JavaScript -->
  <script type="text/javascript" src="../js/custom.js"></script>
</body>

</html>
<?php
include('./adminInclude/footer.php');
?>