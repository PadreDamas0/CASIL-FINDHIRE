<?php
require '../core/dbConfig.php';
require '../core/functions.php';
session_start();


checkLogin('HR');


$stmt = $pdo->query("SELECT * FROM job_posts ORDER BY created_at DESC");
$job_posts = $stmt->fetchAll();

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Dashboard</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>FindHire - HR Dashboard</h1>
            <nav>
                <a href="../logout.php">Logout</a>
            </nav>
        </header>

        <main>
            <h2>Welcome HR</h2>

            <div class="job-posts">
                <?php if (count($job_posts) > 0): ?>
                    <?php foreach ($job_posts as $job): ?>
                        <div class="job-post">
                            <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                            <p><?php echo nl2br(htmlspecialchars($job['description'])); ?></p>

                            <?php
           
                            $stmt = $pdo->prepare("SELECT a.*, u.username FROM applications a JOIN users u ON a.applicant_id = u.user_id WHERE a.job_id = ? ORDER BY a.status ASC");
                            $stmt->execute([$job['job_id']]);
                            $applications = $stmt->fetchAll();

                            if (count($applications) > 0): ?>
                                <div class="applications">
                                    <?php foreach ($applications as $application): ?>
                                        <div class="application">
                                            <p><strong>Applicant: </strong><?php echo htmlspecialchars($application['username']); ?></p>
                                            <p><strong>Status: </strong><?php echo htmlspecialchars($application['status']); ?></p>

                                            <?php if ($application['status'] == 'pending'): ?>
                                                <form action="accept_application.php" method="POST">
                                                    <input type="hidden" name="application_id" value="<?php echo $application['application_id']; ?>">
                                                    <button type="submit" name="accept" value="1" class="btn accept-btn">Accept</button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p>No applications yet.</p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No job posts available.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
