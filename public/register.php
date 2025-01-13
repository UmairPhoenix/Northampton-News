<?php
include 'includes/header.php';
include 'includes/navbar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare('INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)');
    try {
        $stmt->execute(['username' => $username, 'email' => $email, 'password' => $password, 'role' => 'user']);
        echo '<p class="success">Registration successful! <a href="login.php">Log in</a></p>';
    } catch (PDOException $e) {
        echo '<p class="error">Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
}
?>
<main>
    <article>
        <h2>Register</h2>
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Register</button>
        </form>
    </article>
</main>
<?php include 'includes/footer.php'; ?>
