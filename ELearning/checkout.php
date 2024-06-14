<?php 
session_start();
include('./dbConnection.php');

if(!isset($_SESSION['stuLogEmail'])) {
    echo "<script> location.href='loginorsignup.php'; </script>";
    exit();
} else {
    $stuEmail = $_SESSION['stuLogEmail'];
    $course_id = $_SESSION['course_id'];

    // Generate order_id (opsional, jika diperlukan)
    // $order_id = "ORDS" . rand(10000,99999999);

    // Insert data ke tabel courseorder (sesuai dengan struktur yang diperbarui)
    $sql = "INSERT INTO courseorder (stu_email, course_id, order_date) 
            VALUES ('$stuEmail', '$course_id', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Enrolled successfully!";
        // Redirect atau tampilkan pesan berhasil enroll sesuai kebutuhan
        // Contoh menggunakan JavaScript untuk redirect
        echo "<script> setTimeout(() => {
            window.location.href = '../Student/myCourse.php';
        }, 1500); </script>";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Checkout</title>
<!-- Bootstrap CSS -->
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<!-- Font Awesome CSS -->
<link rel="stylesheet" type="text/css" href="css/all.min.css">
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
<!-- Custom Style CSS -->
<link rel="stylesheet" type="text/css" href="./css/style.css" />
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-6 offset-sm-3 jumbotron">
            <h3 class="mb-5">Welcome to Course Enrollment Page</h3>
            <!-- Form untuk proses enroll -->
            <form method="post" action="./PaytmKit/pgRedirect.php">
                <div class="form-group row">
                    <label for="ORDER_ID" class="col-sm-4 col-form-label">Order ID</label>
                    <div class="col-sm-8">
                        <!-- Generate order_id jika diperlukan -->
                        <input id="ORDER_ID" class="form-control" tabindex="1" maxlength="20" size="20" name="ORDER_ID" autocomplete="off"
                            value="<?php echo "ORDS" . rand(10000,99999999)?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="CUST_ID" class="col-sm-4 col-form-label">Student Email</label>
                    <div class="col-sm-8">
                        <input id="CUST_ID" class="form-control" tabindex="2" maxlength="12" size="12" name="CUST_ID" autocomplete="off"
                            value="<?php if(isset($stuEmail)){echo $stuEmail; }?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <!-- Hidden fields untuk INDUSTRY_TYPE_ID dan CHANNEL_ID -->
                    <div class="col-sm-8 offset-sm-4">
                        <input type="hidden" id="INDUSTRY_TYPE_ID" class="form-control" tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID"
                            autocomplete="off" value="Retail" readonly>
                        <input type="hidden" id="CHANNEL_ID" class="form-control" tabindex="4" maxlength="12" size="12" name="CHANNEL_ID"
                            autocomplete="off" value="WEB" readonly>
                    </div>
                </div>
                <div class="text-center">
                    <!-- Tombol untuk proses enroll -->
                    <input value="Enroll" type="submit" class="btn btn-primary">
                    <!-- Link untuk membatalkan proses dan kembali ke halaman courses -->
                    <a href="./courses.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/all.min.js"></script>
<script type="text/javascript" src="js/custom.js"></script>

</body>
</html>
