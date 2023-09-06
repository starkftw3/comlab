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
    <link rel="stylesheet" href="resources/style.css">
    <title>User Dashboard</title>
</head>
<body>
    <div class="container">
        <h1>Welcome to Dashboard</h1>
        <a href="../includes/logout.php" class="btn btn-warning">Logout</a>
    </div>
    <main>
        <h2>Report</h2>
        <form action="../includes/submitreport.php">
        <select id="computers" name="computers">
            <option value="computer 1">computer 1</option>
            <option value="computer 2">computer 2</option>
            <option value="computer 3">computer 3</option>
            <option value="computer 4">computer 4</option>
        </select> 
            <input type="text" placeholder="Enter Report" name="report" />
            <textarea name="description" placeholder="Enter Description" style="width:200px; height:50px; resize: none;"></textarea>
            <input type="submit" value="report" name="submit-report"/>
        </form>
    </main>
</body>
</html>