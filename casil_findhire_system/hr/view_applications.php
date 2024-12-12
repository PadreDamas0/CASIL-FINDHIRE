<?php
require '../core/dbConfig.php';
require '../core/functions.php';
session_start();


checkLogin('HR');


if (!isset($_GET['job_post_id'])) {
    header("Location: dashboard.php");
    exit();
}

$job_post_id = $_GET['job_post_id'];


$stmt = $pdo->prepare("SELECT * FROM applications WHERE job_post_id = ?");
$stmt->execute([$job_post_id]);
$applications = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $application_id = $_POST['application_id'];
    $status = $_POST['status'];
    

    $stmt = $pdo->prepare("UPDATE applications SET status = ? WHERE application_id = ?");
    $stmt->execute([$status, $application_id]);

    echo "<p>Application status updated!</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Applications</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
    <h1>Applications for Job Post</h1>
    <p>Review and manage the applications.</p>

    <?php if (count($applications) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Applicant ID</th>
                    <th>Application Text</th>
                    <th>Resume</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $application): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($application['applicant_id']); ?></td>
                        <td><?php echo htmlspecialchars($application['application_text']); ?></td>
                        <td><a href="../applicant/uploads/<?php echo htmlspecialchars($application['resume']); ?>" target="_blank">Download Resume</a></td>
                        <td><?php echo htmlspecialchars($application['status']); ?></td>
                        <td>
                            <form action="" method="POST">
                                <input type="hidden" name="application_id" value="<?php echo $application['application_id']; ?>">
                                <button type="submit" name="status" value="Accepted">Accept</button>
                                <button type="submit" name="status" value="Rejected">Reject</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No applications for this job.</p>
    <?php endif; ?>

    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
