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
    $stmt = $conn->prepare('SELECT Report_ID, Student_ID, lab_ID, report, computerno, Report_Description, Report_Date FROM problemreport WHERE status = ?');
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
                        <th>Lab-ID</th>
                        <th>Report</th>
                        <th>computer no</th>
                        <th>Report Description</th>
                        <th>Report Date</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <td data-cell="student-id"><?php echo htmlspecialchars($row['Student_ID']); ?></td>
                        <td data-cell="firstname"><?php echo htmlspecialchars($row['lab_ID']); ?></td>
                        <td data-cell="lastname"><?php echo htmlspecialchars($row['report']); ?></td>
                        <td data-cell="middlename"><?php echo htmlspecialchars($row['computerno']); ?></td>
                        <td data-cell="section"><?php echo htmlspecialchars($row['Report_Description']); ?></td>
                        <td data-cell="email"><?php echo htmlspecialchars($row['Report_Date']); ?></td>
                        <td data-cell="action">
                            <div class="action-flex">
                                <form action="../includes/problemresolve.php" method="post">
                                    <input type="hidden" name="report_id" value="<?php echo $row['Report_ID']; ?>">
                                    <button type="submit" name="resolve">Resolved</button>
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