<?php
session_start();
if (!isset($_SESSION["loggedin"])) {
   header("Location: adminlogin.php");
   exit();
}

require_once "../connection/database.php";

// Fetch pending student registrations from the database
if ($stmt = $conn->prepare('SELECT studentid, full_name FROM student WHERE status = ?')) {
    $status = 'pending';
    $stmt->bind_param('s', $status);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='../resources/style.css'>
    <title>Pending Student Registrations</title>
</head>
<body>
    <h1>Pending Student Registrations</h1>
    <?php
        if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo "<div class='alert alert-success'>Update successful!</div>";
        }
    ?>

    <table >
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Full Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['studentid']); ?></td>
                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                    <td>
                        <form action="../includes/process_approval.php" method="post">
                            <input type="hidden" name="student_id" value="<?php echo $row['studentid']; ?>">
                            <button type="submit" name="approve">Approve</button>
                        </form>
                        <form action="../includes/process_approval.php" method="post">
                            <input type="hidden" name="student_id" value="<?php echo $row['studentid']; ?>">
                            <button type="submit" name="reject">Reject</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
