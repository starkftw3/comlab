<?php
session_start(); // Start or resume the session

require_once "../connection/database.php";

$newStatus = "resolved";

if (isset($_POST['resolve'])) {
    $reportid = $_POST['report_id'];
    
    // Prepare an SQL statement to update the status
    if ($stmt = $conn->prepare('UPDATE problemreport SET status = ? WHERE Report_ID = ?')) {
        $stmt->bind_param('ss', $newStatus, $reportid);
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
header("Location: ../admin/report.php?message=" . urlencode($message));
// Close the database connection
$conn->close();
?>
