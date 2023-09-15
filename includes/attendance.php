<?php

session_start();
if(isset($_POST['present'])){
    $studentid = $_POST['student_id'];
    
    try {

        date_default_timezone_set('Asia/Manila');
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');
        
        require_once "../connection/database.php";
        // Student-ID doesn't exists, insert new account
        $stmt = $conn->prepare('INSERT INTO attendance (studentid, time, date) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $studentid, $currentTime, $currentDate);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Insertion successful, set a success message
            $message = "Attendance recorded successfully.";
        } else {
            // Insertion failed, set an error message
            $message = "Failed to record attendance.";
        }

        $stmt->close();
        $conn->close();

        header("Location: ../student/home.php?message=" . urlencode($message));
        
    } catch (Exception $e) {
        die('Database error: ' . $e->getMessage());
    }
    // Redirect to a different page with the message in the query string
    
}


?>