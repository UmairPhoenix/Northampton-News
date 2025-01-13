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
        <h2>Add Category</h2>
        <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    $stmt = $pdo->prepare('INSERT INTO category (name) VALUES (:name)');
                    $stmt->execute([
                        'name' => $_POST['name'],
                    ]);

                    echo '<p class="success">Category added successfully.</p>';
                } catch (PDOException $e) {
                    echo '<p class="error">Error adding category: ' . htmlspecialchars($e->getMessage()) . '</p>';
                }
            } else {
                ?>
                <form action="addcategory.php" method="POST">
                    <label for="name">Category name:</label>
                    <input type="text" id="name" name="name" required>
                    <button type="submit" name="submit">Submit</button>
                </form>
                <?php
            }
        } else {
            echo '<p class="error">You must be logged in to add a category.</p>';
        }
        ?>
    </article>
</main>

<?php include 'includes/footer.php'; ?>
