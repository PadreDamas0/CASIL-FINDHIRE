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
</head>
<body>
    <div style="max-width: 800px; margin: 0 auto; padding: 20px; background-color: white; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <header style="text-align: center;">
            <h1>HR Dashboard</h1>
            <nav style="float: right;">
                <a href="../logout.php">Logout</a>
            </nav>
        </header>

        <main style="text-align: center;">
            <h2>Welcome, HR!</h2>

            <div>
                <?php if (count($job_posts) > 0): ?>
                    <?php foreach ($job_posts as $job): ?>
                        <div style="background-color: #f9f9f9; border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; text-align: left;">
                            <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                            <p><?php echo nl2br(htmlspecialchars($job['description'])); ?></p>

                            <?php
                  
                            $stmt = $pdo->prepare("SELECT a.*, u.username FROM applications a JOIN users u ON a.applicant_id = u.user_id WHERE a.job_id = ? ORDER BY a.status ASC");
                            $stmt->execute([$job['job_id']]);
                            $applications = $stmt->fetchAll();

                            if (count($applications) > 0): ?>
                                <div>
                                    <?php foreach ($applications as $application): ?>
                                        <div style="background-color: #fff; padding: 10px; border: 1px solid #ddd; margin-bottom: 10px; border-radius: 5px;">
                                            <p><strong>Applicant: </strong><?php echo htmlspecialchars($application['username']); ?></p>
                                            <p><strong>Status: </strong><?php echo htmlspecialchars($application['status']); ?></p>

                                            <?php if ($application['status'] == 'pending'): ?>
                                                <form action="accept_application.php" method="POST">
                                                    <input type="hidden" name="application_id" value="<?php echo $application['application_id']; ?>">
                                                    <button type="submit" name="accept" value="1" style="background-color: #28a745; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer;">Accept</button>
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
