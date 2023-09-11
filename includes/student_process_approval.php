<?php
session_start(); // Start or resume the session

require_once "../connection/database.php";

if (isset($_POST['approve']) || isset($_POST['reject'])) {
    $studentId = $_POST['student_id'];
    
    if (isset($_POST['approve'])) {
        $newStatus = 'approved';
    } elseif (isset($_POST['reject'])) {
        $newStatus = 'rejected';
    }

    // Prepare an SQL statement to update the status
    if ($stmt = $conn->prepare('UPDATE student SET status = ? WHERE studentid = ?')) {
        $stmt->bind_param('ss', $newStatus, $studentId);
        if ($stmt->execute()) {
            // Update successful
            $message = "Status updated successfully.";
        } else {
            // Error occurred during the update
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        // Error in SQL statement preparation
        $message = "Error: " . $conn->error;
    }
}
header("Location: ../admin/student.php?message=" . urlencode($message));
// Close the database connection
$conn->close();
?>
