<?php
require_once "../connection/database.php";

if (isset($_POST['approve']) || isset($_POST['reject'])) {
    $studentId = $_POST['student_id'];
    
    if (isset($_POST['approve'])) {
        $newStatus = 'approved';
    } elseif (isset($_POST['reject'])) {
        $newStatus = 'rejected';
    }

    // Prepare an SQL statement to update the status
    if ($stmt = $conn->prepare('UPDATE student SET status =?  WHERE studentid = ?')) {
        $stmt->bind_param('ss', $newStatus, $studentId);
        if ($stmt->execute()) {
            // Update successful
            header("Location: ../admin/home.php?success=1"); // Redirect to the page where pending registrations are displayed
            exit();
        } else {
            // Error occurred during the update
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        // Error in SQL statement preparation
        echo "Error: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
