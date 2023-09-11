<?php 

session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: adminlogin.php");
    exit();
 }
$page = "Faculty Member Registration";
include '../partial/sidebar.php';
include '../partial/header.php';


require_once "../connection/database.php";

$status = 'pending';

try {
    $stmt = $conn->prepare('SELECT facultyid, firstname, lastname, middlename, email FROM faculty WHERE status = ?');
    $stmt->bind_param('s', $status);
    $stmt->execute();
    $result = $stmt->get_result();
} catch (Exception $e) {
    // Handle database errors here.
    die('Database error: ' . $e->getMessage());
}
?>

?>
<div class="main-content">
    <main>
        <table>
            <tr>
                <th>Faculty ID</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>MiddleName</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td data-cell="student-id"><?php echo htmlspecialchars($row['facultyid']); ?></td>
                        <td data-cell="firstname"><?php echo htmlspecialchars($row['firstname']); ?></td>
                        <td data-cell="lastname"><?php echo htmlspecialchars($row['lastname']); ?></td>
                        <td data-cell="middlename"><?php echo htmlspecialchars($row['middlename']); ?></td>
                        <td data-cell="email"><?php echo htmlspecialchars($row['email']); ?></td>
                        <td data-cell="action">
                            <div class="action-flex">
                                <form action="../includes/faculty_process_approval.php" method="post">
                                    <input type="hidden" name="faculty_id" value="<?php echo $row['facultyid']; ?>">
                                    <button type="submit" name="approve">Approve</button>
                                </form>
                                <form action="../includes/faculty_process_approval.php" method="post">
                                    <input type="hidden" name="faculty_id" value="<?php echo $row['facultyid']; ?>">
                                    <button type="submit" name="reject">Reject</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
        </table>
    </main>
</div>
</body>
</html>
