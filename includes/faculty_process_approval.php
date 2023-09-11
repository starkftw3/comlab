<?php
session_start(); // Start or resume the session

require_once "../connection/database.php";

if (isset($_POST['approve']) || isset($_POST['reject'])) {
    $facultyId = $_POST['faculty_id'];
    
    if (isset($_POST['approve'])) {
        $newStatus = 'approved';
    } elseif (isset($_POST['reject'])) {
        $newStatus = 'rejected';
    }

    // Prepare an SQL statement to update the status
    if ($stmt = $conn->prepare('UPDATE faculty SET status = ? WHERE facultyid = ?')) {
        $stmt->bind_param('ss', $newStatus, $facultyId);
        if ($stmt->execute()) {
            // Update successful
            $_SESSION['message'] = "Status updated successfully.";
        } else {
            // Error occurred during the update
            $_SESSION['message'] = "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        // Error in SQL statement preparation
        $_SESSION['message'] = "Error: " . $conn->error;
    }
}
header("Location: ../admin/facultymember.php?message=" . urlencode($message));
// Close the database connection
$conn->close();
?>
