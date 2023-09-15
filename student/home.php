<?php
session_start();
if (!isset($_SESSION["student"])) {
    header("Location: studentlogin.php");
    exit();
}

require_once "../connection/database.php"; // Include your database connection file here

// Get user information from the session
$studentName = $_SESSION["name"];
$studentSection = $_SESSION['section'];
$studentId = $_SESSION['studentid'];

// Function to check if an day and time  is valid for marking attendance
function isAttendanceAllowed($eventDate, $eventTimeIn, $eventTimeOut, $currentTime, $currentDate) { //2023-09-15, 15:00:00, 17:00:00, 15:00:00
    return ($eventDate === $currentDate && $eventTimeIn <= $currentTime && $eventTimeOut >= $currentTime); 
            //2023-09-15 === 2023-09-15 && 20:50:00  15:00:00 <= 16:00:00 && 17:00:00 >= 16:00:00 
}

try {
    date_default_timezone_set('Asia/Manila');
    $currentDate = date("Y-m-d");
    $currentTime = date("H:i:s");
    echo $currentTime;

    // Query the database to get upcoming events for the student's section
    $stmt = $conn->prepare('SELECT date, timein, timeout FROM calendar WHERE section = ?');
    $stmt->bind_param('s', $studentSection);
    $stmt->execute();
    $results = $stmt->get_result();

} catch (Exception $e) {
    die('Database error: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style-student.css">
    <title>User Dashboard</title>
</head>
<body>
    <nav class="navbar">
        <h5>Welcome <?php echo $studentName; ?></h5>
        <a href="../includes/logout.php" class="btn btn-warning">Logout</a>
    </nav>

    <div>

        <!--get the day_of_week in database
            get the dateToday (date function) convert it to day(example: Monday)
            check the day of dateToday
            get the timenow
            get the timein in database
            get the timeout in database

            if

            if(day_of_week === dateToday)
                if(timein >= timenow && timeout <= time)
                    markAttendance = true;
                    break;

        -->
        <?php
        $matchFound = false;

        if ($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {
                if (isAttendanceAllowed($row["date"], $row["timein"], $row["timeout"], $currentTime, $currentDate)) {
                    echo $row["date"]," ", $row["timein"]," ", $row["timeout"]," ", $currentTime, " ", $currentDate;
                    $matchFound = true;
                    break;
                }
            }

            if (!$matchFound) {
                echo "No matching date found.<br>";
            }
        } else {
            echo "No results found.";
        }
        ?>

        <?php if ($matchFound): ?>
            <h4>Attendance</h4>
            <form action='../includes/attendance.php' method='POST'>
                <input type='hidden' name='student_id' value='<?php echo $studentId; ?>'>
                <button type='submit' name='present'>Present</button>
            </form>
        <?php endif; ?>
        
        <main class="report">
        <main class="report">
        <h2 class="title-report">Report</h2>
        <form action="../includes/problemreport.php" method="POST" class="form">
            <select id="laboratory" name="laboratory" class="input" required>
                <option value="">Select a Laboratory</option>
                <option value="205 Main">205 Main</option>
                <option value="204 Main">204 Main</option>
                <option value="203 Main">203 Main</option>
            </select>
            <select id="computers" name="computers" class="input" required >
                <option value="">Select a computer</option>
                <option value="1">computer 1</option>
                <option value="2">computer 2</option>
                <option value="3">computer 3</option>
                <option value="4">computer 4</option>
             </select>
            <input type="text" placeholder="Enter Report" name="report" class="input" required />
            <textarea name="description" placeholder="Enter Description" class="textarea"></textarea>
            <button type="submit" name="submit-report" class="submit">Report</button>
        </form>
        </main>
    </div>
</body>
</html>
