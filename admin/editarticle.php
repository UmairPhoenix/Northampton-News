<?php
    include 'includes/header.php';
    include 'includes/navbar.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $articleId = $_GET['id'];
    try {
        $stmt = $pdo->prepare('SELECT * FROM article WHERE id = :id');
        $stmt->execute(['id' => $articleId]);
        $article = $stmt->fetch();

        if (!$article) {
            echo '<p class="error">Article not found.</p>';
            exit;
        }
    } catch (PDOException $e) {
        echo '<p class="error">Error fetching article: ' . htmlspecialchars($e->getMessage()) . '</p>';
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $stmt = $pdo->prepare('
                UPDATE article 
                SET title = :title, description = :description, categoryId = :categoryId, date = :date 
                WHERE id = :id
            ');

            $stmt->execute([
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'categoryId' => $_POST['categoryId'],
                'date' => (new DateTime())->format('Y-m-d H:i:s'),
                'id' => $articleId,
            ]);

            echo '<p class="success">Article updated successfully.</p>';
        } catch (PDOException $e) {
            echo '<p class="error">Error updating article: ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
    }
} else {
    echo '<p class="error">Invalid article ID.</p>';
    exit;
}
?>

<main>
    <article>
        <h2>Edit Article</h2>
        <form action="editarticle.php?id=<?php echo htmlspecialchars($articleId); ?>" method="POST">
            <label>Category</label>
            <select name="categoryId">
                <option value="1" <?php if ($article['categoryId'] == 1) echo 'selected'; ?>>Local News</option>
                <option value="2" <?php if ($article['categoryId'] == 2) echo 'selected'; ?>>Local Events</option>
                <option value="3" <?php if ($article['categoryId'] == 3) echo 'selected'; ?>>Sport</option>
            </select>
            <label>Article title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($article['title']); ?>" required />
            <label>Article text:</label>
            <textarea name="description" required><?php echo htmlspecialchars($article['description']); ?></textarea>
            <button type="submit">Update Article</button>
        </form>
    </article>
</main>

<?php include 'includes/footer.php'; ?>
