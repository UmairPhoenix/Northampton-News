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
        <h2>Add Article</h2>
        <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
                try {
                    $authorId = $_SESSION['user_id'];

                    $stmt = $pdo->prepare('INSERT INTO article (title, description, categoryId, date, author_id) 
                                           VALUES (:title, :description, :categoryId, :date, :author_id)');
                    $stmt->execute([
                        'title' => $_POST['title'],
                        'description' => $_POST['description'],
                        'categoryId' => $_POST['categoryId'],
                        'date' => (new DateTime())->format('Y-m-d H:i:s'),
                        'author_id' => $authorId,
                    ]);

                    echo '<p class="success">Article added successfully.</p>';
                } catch (PDOException $e) {
                    echo '<p class="error">Error adding article: ' . htmlspecialchars($e->getMessage()) . '</p>';
                }
            } else {
                ?>
                <form action="addarticle.php" method="POST">
                    <label for="categoryId">Category</label>
                    <select name="categoryId" id="categoryId" required>
                        <option value="1">Local News</option>
                        <option value="2">Local Events</option>
                        <option value="3">Sport</option>
                    </select>
                    <label for="title">Article title:</label>
                    <input type="text" name="title" id="title" required>
                    <label for="description">Article text:</label>
                    <textarea name="description" id="description" required></textarea>
                    <button type="submit" name="submit">Submit</button>
                </form>
                <?php
            }
        } else {
            echo '<p class="error">You must be logged in to add an article.</p>';
        }
        ?>
    </article>
</main>

<?php include 'includes/footer.php'; ?>
