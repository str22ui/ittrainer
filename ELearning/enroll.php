<?php
session_start();
include('./dbConnection.php');

if (isset($_POST['enroll']) && isset($_POST['course_id'])) {
    if (isset($_SESSION['stuLogEmail'])) {
        $stuEmail = $_SESSION['stuLogEmail'];
        $course_id = $_POST['course_id'];

        // Check if the user is already enrolled in this course
        $check_sql = "SELECT * FROM courseorder WHERE stu_email = '$stuEmail' AND course_id = '$course_id'";
        $check_result = $conn->query($check_sql);

        if ($check_result && $check_result->num_rows > 0) {
            // User is already enrolled
            echo "<script>alert('You are already enrolled in this course!');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
            exit();
        } else {
            // User is not enrolled, proceed with enrollment
            // Generate order_id (using a random number or any unique identifier)
            $order_id = "ORDS" . rand(10000, 99999999);

            // Insert into courseorder table
            $sql = "INSERT INTO courseorder (order_id, stu_email, course_id, order_date) 
                    VALUES ('$order_id', '$stuEmail', '$course_id', NOW())";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Enrolled successfully!');</script>";
                echo "<script>window.location.href = 'index.php';</script>";
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        // Redirect to login or signup page if user is not logged in
        header("Location: loginorsignup.php");
        exit();
    }
} else {
    // Redirect to courses page if no enroll button is clicked
    header("Location: courses.php");
    exit();
}
