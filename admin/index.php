<?php
	include 'includes/header.php';
	include 'includes/navbar.php';
?>

<main>
    <nav>
        <ul>
            <li><a href="addcategory.php">Add Category</a></li>
            <li><a href="addarticle.php">Add Article</a></li>
            <li><a href="categories.php">List Categories</a></li>
            <li><a href="articles.php">List Articles</a></li>
        </ul>
    </nav>
    <article>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stmt = $pdo->prepare('SELECT * FROM staff WHERE username = :username AND password = :password');
            $stmt->execute([
                'username' => $_POST['username'],
                'password' => $_POST['password'],
            ]);
            $user = $stmt->fetch();

            if ($user) {
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                echo '<p>Welcome back, ' . htmlspecialchars($_SESSION['username']) . '.</p>';
            } else {
                echo '<p class="error">Invalid username or password.</p>';
            }
        }

        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            echo '<p>Please choose an option from the left.</p>';
        } else {
            ?>
            <form action="index.php" method="POST">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <button type="submit" name="submit">Login</button>
            </form>
            <?php
        }
        ?>
    </article>
</main>

<?php include 'includes/footer.php'; ?>
