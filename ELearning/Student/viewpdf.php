<?php
if(isset($_GET['lesson_id'])) {
    $lesson_id = $_GET['lesson_id'];
    // Query untuk mendapatkan path atau URL PDF dari database
    $sql = "SELECT lesson_pdf FROM lesson WHERE lesson_id = $lesson_id";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $pdf_url = $row['lesson_pdf'];
        // Tampilkan PDF menggunakan iframe
        echo '<div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="' . $pdf_url . '" type="application/pdf" allowfullscreen></iframe>
              </div>';
    } else {
        echo "PDF not found.";
    }
} else {
    echo "Lesson ID not specified.";
}
?>
