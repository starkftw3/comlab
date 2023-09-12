<?php

session_start();
if (!isset($_SESSION["student"])) {
   header("Location: studentlogin.php");
   exit();
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
        <h5>Welcome <?=$_SESSION["name"]?></h5>
        <a href="../includes/logout.php" class="btn btn-warning">Logout</a>
    </nav>

    <div>

        <!--
            get the session section
            get the date today
            find the session section === calendar database section
            find the date today === calendar database date
        -->

        <?php
        date_default_timezone_set('Asia/Manila');
        $currentDateTime = date('Y-m-d');
        
        $studentSection = $_SESSION['section'];
        echo $studentSection;
        require_once "../connection/database.php";

        try {
            $stmt = $conn->prepare('SELECT date FROM calendar WHERE section = ?');
            $stmt->bind_param('s', $studentSection);
            $stmt->execute();
            $results = $stmt->get_result();
            
        } catch (Exception $e) {
            die('Database error: ' . $e->getMessage());
        }

        $matchFound = false;

        // fix this plss
        if ($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {
        // Compare the 'date' from the database to the current date
            if ($row["date"] === $currentDateTime) {
                echo "Yes<br>";
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

        <?php
            if($matchFound){
                echo"<h2>Attendance</h2>";
                echo "<form>";
                echo "<input>";
                echo   "<button type='submit' name='approve'>Approve</button>";
                echo "</form>";
                echo "</div>";
            }
        ?>
        
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
</body>
</html>