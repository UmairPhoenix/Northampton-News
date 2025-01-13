<?php
    include 'includes/header.php';
    include 'includes/navbar.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $categoryId = $_GET['id'];

    try {
        $stmt = $pdo->prepare('SELECT * FROM category WHERE id = :id');
        $stmt->execute(['id' => $categoryId]);
        $category = $stmt->fetch();

        if (!$category) {
            echo '<p class="error">Category not found.</p>';
            exit;
        }
    } catch (PDOException $e) {
        echo '<p class="error">Error fetching category: ' . htmlspecialchars($e->getMessage()) . '</p>';
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['name'])) {
            try {
                $stmt = $pdo->prepare('UPDATE category SET name = :name WHERE id = :id');
                $stmt->execute([
                    'name' => $_POST['name'],
                    'id' => $categoryId,
                ]);

                echo '<p class="success">Category updated successfully.</p>';
            } catch (PDOException $e) {
                echo '<p class="error">Error updating category: ' . htmlspecialchars($e->getMessage()) . '</p>';
            }
        } else {
            echo '<p class="error">Category name cannot be empty.</p>';
        }
    }
} else {
    echo '<p class="error">Invalid category ID.</p>';
    exit;
}
?>

<main>
    <article>
        <h2>Edit Category</h2>
        <form action="editcategory.php?id=<?php echo htmlspecialchars($categoryId); ?>" method="POST">
            <label for="name">Category Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
            <button type="submit">Update Category</button>
        </form>
        <p><a href="categories.php">Back to Categories</a></p>
    </article>
</main>

<?php include 'includes/footer.php'; ?>
