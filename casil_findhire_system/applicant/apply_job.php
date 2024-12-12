<?php
require '../core/dbConfig.php';
require '../core/functions.php';
session_start();


checkLogin('Applicant');


$job_id = isset($_GET['job_id']) ? $_GET['job_id'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $job_id) {

    $applicant_id = $_SESSION['user_id'];

    
    try {
        $stmt = $pdo->prepare("INSERT INTO applications (applicant_id, job_id) VALUES (?, ?)");
        $stmt->execute([$applicant_id, $job_id]);

        echo "<p>Your application has been submitted successfully!</p>";
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>Invalid job ID or application error.</p>";
}


if ($job_id) {
    $stmt = $pdo->prepare("SELECT * FROM job_posts WHERE job_id = ?");
    $stmt->execute([$job_id]);
    $job = $stmt->fetch();

    if ($job) {

        echo "<h2>" . htmlspecialchars($job['title']) . "</h2>";
        echo "<p>" . nl2br(htmlspecialchars($job['description'])) . "</p>";
        echo "<p><strong>Job ID:</strong> " . $job['job_id'] . "</p>";
    } else {
        echo "<p>Job not found.</p>";
    }
}
?>


<?php if ($job_id && $job): ?>
    <form action="apply_job.php?job_id=<?php echo $job['job_id']; ?>" method="POST">
        <button type="submit">Submit Application</button>
    </form>
<?php else: ?>
    <p>No job selected or job is unavailable.</p>
<?php endif; ?>


<p><a href="dashboard.php">Back to Dashboard</a></p>
