<?php
require '../core/dbConfig.php';
require '../core/functions.php';


$job_id = isset($_GET['job_id']) ? $_GET['job_id'] : null;

if ($job_id) {

    $stmt = $pdo->prepare("SELECT j.*, u.username AS hired_name FROM job_posts j LEFT JOIN users u ON j.hired_applicant_id = u.user_id WHERE j.job_id = ?");
    $stmt->execute([$job_id]);
    $job = $stmt->fetch();

    if ($job) {
        echo "<h2>" . htmlspecialchars($job['title']) . "</h2>";
        echo "<p>" . nl2br(htmlspecialchars($job['description'])) . "</p>";

        if ($job['hired_applicant_id']) {
            echo "<p><strong>Hired Applicant: </strong>" . htmlspecialchars($job['hired_name']) . "</p>";
        } else {
            echo "<p>No one hired for this job yet.</p>";
        }
    } else {
        echo "<p>Job not found.</p>";
    }
}
?>
