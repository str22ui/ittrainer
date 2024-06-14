<?php
if (!isset($_SESSION)) {
  session_start();
}
define('TITLE', 'My Course');
define('PAGE', 'mycourse');
// include('./stuInclude/header.php'); 
include_once('../dbConnection.php');

if (isset($_SESSION['is_login'])) {
  $stuLogEmail = $_SESSION['stuLogEmail'];
} else {
  echo "<script> location.href='../index.php'; </script>";
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
  <link rel="stylesheet" href="../css/stustyle.css">
</head>

<body>
  <nav class="navbar navbar-dark fixed-top flex-md-nowrap p-0 shadow" style="background-color: #F0FFFF;">
    <a href="../index.php"><img src="../image/malogo1.png" alt="Metrodata Academy Logo" style="height: 50px;"></a>
  </nav>

  <div class="container-fluid" style="margin-top:60px;">
    <div class="row">
      <nav class="col-md-2 bg-light sidebar py-5 d-print-none">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item mb-3">
              <img src="<?php echo $stu_img ?>" alt="studentimage" class="img-thumbnail rounded-circle">
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if (PAGE == 'profile') {
                                    echo 'active';
                                  } ?>" href="studentProfile.php">
                <i class="fas fa-user"></i>
                Profile <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if (PAGE == 'mycourse') {
                                    echo 'active';
                                  } ?>" href="myCourse.php">
                <i class="fab fa-accessible-icon"></i>
                My Courses
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if (PAGE == 'feedback') {
                                    echo 'active';
                                  } ?>" href="stufeedback.php">
                <i class="fab fa-accessible-icon"></i>
                Feedback
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if (PAGE == 'studentChangePass') {
                                    echo 'active';
                                  } ?>" href="studentChangePass.php">
                <i class="fas fa-key"></i>
                Change Password
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../logout.php">
                <i class="fas fa-sign-out-alt"></i>
                Logout
              </a>
            </li>
          </ul>
        </div>
      </nav>
      <main class="col-md-10 ml-sm-auto px-4">
        <div class="container mt-5">
          <div class="row">
            <div class="jumbotron">
              <h4 class="text-center">All Course</h4>
              <?php
              if (isset($stuLogEmail)) {
                $sql = "SELECT co.order_id, c.course_id, c.course_name, c.course_duration, c.course_desc, c.course_img, c.course_author FROM courseorder AS co JOIN course AS c ON c.course_id = co.course_id WHERE co.stu_email = '$stuLogEmail'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) { ?>
                    <div class="bg-light mb-3">
                      <h5 class="card-header"><?php echo $row['course_name']; ?></h5>
                      <div class="row">
                        <div class="col-sm-3">
                          <img src="<?php echo $row['course_img']; ?>" class="card-img-top mt-4" alt="pic">
                        </div>
                        <div class="col-sm-6 mb-3">
                          <div class="card-body">
                            <p class="card-title"><?php echo $row['course_desc']; ?></p>
                            <small class="card-text">Duration: <?php echo $row['course_duration']; ?></small><br />
                            <small class="card-text">Instructor: <?php echo $row['course_author']; ?></small><br />
                            <!-- <a href="viewpdf.php?course_id=<?php echo $row['course_id']; ?>" class="btn btn-secondary mt-5 float-right">View PDF</a> -->


                            <a href="watchcourse.php?course_id=<?php echo $row['course_id'] ?>" class="btn btn-primary mt-5 float-right">Watch Course</a>
                          </div>
                        </div>
                      </div>
                    </div>
              <?php
                  }
                }
              }
              ?>
              <hr />
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- Footer -->
  <?php
  include('./stuInclude/footer.php');
  ?>
  <!-- Bootstrap JavaScript -->
  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/all.min.js"></script>
</body>

</html>