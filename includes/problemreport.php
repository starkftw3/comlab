<?php
//di pa tapos

session_start();
if (isset($_POST["submit-report"])) {
    $computerNo = $_POST["computers"];
    $laboratoryRoom = $_POST["laboratory"];
    $report = $_POST["report"];
    $description = $_POST["description"];

    // Validate inputs
    if (empty($computerNo) || empty($laboratoryRoom) || empty($report) || empty($description)) {
        echo "<div class='alert alert-danger'>All fields are required</div>";
    } else {
        // Sanitize user inputs if necessary

        // Use a try-catch block for error handling
        try {
            require_once "../connection/database.php";
            // Connect to your database here and store the connection in $conn
            
            date_default_timezone_set('Asia/Manila');
            $currentDateTime = date('Y-m-d H:i:s');
            // Prepare the SQL statement
            $stmt = $conn->prepare('INSERT INTO problemreport (Student_ID, lab_ID, report, computerNo, Report_Description, Report_Date) VALUES (?, ?, ?, ?, ?, ?)');
            
            // Bind parameters and execute the statement
            $stmt->bind_param('sssiss', $_SESSION["studentid"], $laboratoryRoom, $report, $computerNo, $description, $currentDateTime);
            if ($stmt->execute()) {
                header('Location: ../student/home.php?message=Your report was submitted successfully.');
            } else {
                header('Location: ../student/home.php?message=Failed to submit the report.');
            }

            // Close the statement and database connection
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            // Handle exceptions here (e.g., database connection error)
            

            //include the logic in header()
             echo "<div class='alert alert-danger'>An error occurred: " . $e->getMessage() . "</div>";
        }
    }
} else {
    header('Location: ../student/home.php?message=Reporting failed due to a technical issue. Please try again later.');
}

