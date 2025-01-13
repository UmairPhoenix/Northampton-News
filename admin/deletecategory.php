<?php
	include 'includes/header.php';
	include 'includes/navbar.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    try {
        // Prepare and execute the delete query
        $stmt = $pdo->prepare('DELETE FROM category WHERE id = :id');
        $stmt->execute(['id' => $_GET['id']]);

        // Display a success message
        echo '<p class="success">Category deleted successfully.</p>';
    } catch (PDOException $e) {
        // Display an error message
        echo '<p class="error">Error deleting category: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
} else {
    echo '<p class="error">Invalid category ID.</p>';
}

echo '<p><a href="categories.php">Back to Categories</a></p>';
?>

<main>
    <article>
        <h2>Delete Category</h2>
        <p>Use the "Back to Categories" link above to manage other categories.</p>
    </article>
</main>

<?php include 'includes/footer.php'; ?>
