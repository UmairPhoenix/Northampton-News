<?php
	include 'includes/header.php';
	include 'includes/navbar.php';
?>

<main>
    <article>
        <h2>Delete Article</h2>
        <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                try {
                    $stmt = $pdo->prepare('DELETE FROM article WHERE id = :id');
                    $stmt->execute(['id' => $_GET['id']]);

                    echo '<p class="success">Article deleted successfully.</p>';
                } catch (PDOException $e) {
                    echo '<p class="error">Error deleting article: ' . htmlspecialchars($e->getMessage()) . '</p>';
                }
            } else {
                echo '<p class="error">Invalid article ID.</p>';
            }
        } else {
            echo '<p class="error">You must be logged in to perform this action.</p>';
        }
        ?>
        <p><a href="articles.php">Back to Articles</a></p>
    </article>
</main>

<?php include 'includes/footer.php'; ?>
