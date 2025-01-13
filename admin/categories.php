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
        <h2>Categories</h2>
        <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            try {
                $stmt = $pdo->query('SELECT * FROM category ORDER BY id ASC');

                echo '<table>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Category Name</th>';
                echo '<th>Actions</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                foreach ($stmt as $category) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($category['name']) . '</td>';
                    echo '<td>';
                    echo '<a href="editcategory.php?id=' . htmlspecialchars($category['id']) . '">Edit</a> | ';
                    echo '<a href="deletecategory.php?id=' . htmlspecialchars($category['id']) . '" onclick="return confirm(\'Are you sure you want to delete this category?\');">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } catch (PDOException $e) {
                echo '<p class="error">Error fetching categories: ' . htmlspecialchars($e->getMessage()) . '</p>';
            }
        } else {
            echo '<p class="error">You must be logged in to view this page.</p>';
        }
        ?>
    </article>
</main>

<?php include 'includes/footer.php'; ?>
