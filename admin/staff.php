<?php
    include 'includes/header.php';
    include 'includes/navbar.php'; 

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_staff'])) {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'admin';

    if (!empty($username) && !empty($_POST['password'])) {
        try {
            $stmt = $pdo->prepare('INSERT INTO staff (username, password, role) VALUES (:username, :password, :role)');
            $stmt->execute(['username' => $username, 'password' => $password, 'role' => $role]);
            $message = "Staff member added successfully.";
        } catch (PDOException $e) {
            $message = "Error adding staff member: " . htmlspecialchars($e->getMessage());
        }
    } else {
        $message = "Please fill in all fields.";
    }
}

if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];

    try {
        $stmt = $pdo->prepare('SELECT role FROM staff WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $staff = $stmt->fetch();

        if ($staff && $staff['role'] !== 'superadmin') {
            $stmt = $pdo->prepare('DELETE FROM staff WHERE id = :id');
            $stmt->execute(['id' => $id]);
            $message = "Staff member deleted.";
        } else {
            $message = "You cannot delete the superadmin account.";
        }
    } catch (PDOException $e) {
        $message = "Error deleting staff member: " . htmlspecialchars($e->getMessage());
    }
}

$stmt = $pdo->query('SELECT * FROM staff ORDER BY role DESC, id ASC');
$staffMembers = $stmt->fetchAll();
?>

<main>
    <article>
        <h1>Manage Staff</h1>
        <?php if (!empty($message)): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <h2>Add Staff Member</h2>
        <form method="POST" action="staff.php">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit" name="add_staff">Add Staff</button>
        </form>

        <h2>Existing Staff Members</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($staffMembers as $staff): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($staff['id']); ?></td>
                        <td><?php echo htmlspecialchars($staff['username']); ?></td>
                        <td><?php echo htmlspecialchars($staff['role']); ?></td>
                        <td>
                            <?php if ($staff['role'] !== 'superadmin'): ?>
                                <a href="?delete_id=<?php echo $staff['id']; ?>" 
                                   onclick="return confirm('Are you sure you want to delete this staff member?');">
                                    Delete
                                </a>
                            <?php else: ?>
                                Superadmin
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </article>
</main>

<?php include 'includes/footer.php'; ?>
