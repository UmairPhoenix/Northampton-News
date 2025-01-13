<?php
    include 'includes/header.php';
    include 'includes/navbar.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

if (isset($_GET['mark_done']) && is_numeric($_GET['mark_done'])) {
    try {
        $stmt = $pdo->prepare('UPDATE communications SET status = "Done" WHERE id = :id');
        $stmt->execute(['id' => $_GET['mark_done']]);
        header('Location: communications.php');
        exit;
    } catch (PDOException $e) {
        $error = "Error updating message status: " . htmlspecialchars($e->getMessage());
    }
}

try {
    $stmt = $pdo->query('SELECT * FROM communications ORDER BY id DESC');
    $communications = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Error fetching communications: " . htmlspecialchars($e->getMessage());
}
?>

<main>
    <article>
        <h2>Manage Communications</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Telephone</th>
                    <th>Question</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($communications)): ?>
                    <?php foreach ($communications as $message): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($message['id']); ?></td>
                            <td><?php echo htmlspecialchars($message['name']); ?></td>
                            <td><?php echo htmlspecialchars($message['email']); ?></td>
                            <td><?php echo htmlspecialchars($message['telephone']); ?></td>
                            <td><?php echo htmlspecialchars($message['question']); ?></td>
                            <td><?php echo htmlspecialchars($message['status']); ?></td>
                            <td>
                                <?php if ($message['status'] === 'Pending'): ?>
                                    <a href="?mark_done=<?php echo htmlspecialchars($message['id']); ?>" onclick="return confirm('Are you sure you want to mark this as done?');">Mark as Done</a>
                                <?php else: ?>
                                    Done
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No communications found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </article>
</main>

<?php include 'includes/footer.php'; ?>
