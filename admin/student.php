<?php 

session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: adminlogin.php");
    exit();
 }
$page = "Student Registration";
include '../partial/sidebar.php';
include '../partial/header.php';


require_once "../connection/database.php";

// Fetch pending student registrations from the database
$status = 'pending';

try {
    $stmt = $conn->prepare('SELECT studentid, firstname, lastname, middlename, section, email FROM student WHERE status = ?');
    $stmt->bind_param('s', $status);
    $stmt->execute();
    $result = $stmt->get_result();
} catch (Exception $e) {
    // Handle database errors here.
    die('Database error: ' . $e->getMessage());
}
?>
    <div class="main-content">
        <main>
                <table>
                    <tr>
                        <th>Student-ID</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Middlename</th>
                        <th>Section</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <td data-cell="student-id"><?php echo htmlspecialchars($row['studentid']); ?></td>
                        <td data-cell="firstname"><?php echo htmlspecialchars($row['firstname']); ?></td>
                        <td data-cell="lastname"><?php echo htmlspecialchars($row['lastname']); ?></td>
                        <td data-cell="middlename"><?php echo htmlspecialchars($row['middlename']); ?></td>
                        <td data-cell="section"><?php echo htmlspecialchars($row['section']); ?></td>
                        <td data-cell="email"><?php echo htmlspecialchars($row['email']); ?></td>
                        <td data-cell="action">
                            <div class="action-flex">
                                <form action="../includes/process_approval.php" method="post">
                                    <input type="hidden" name="student_id" value="<?php echo $row['studentid']; ?>">
                                    <button type="submit" name="approve">Approve</button>
                                </form>
                                <form action="../includes/process_approval.php" method="post">
                                    <input type="hidden" name="student_id" value="<?php echo $row['studentid']; ?>">
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