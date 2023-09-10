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