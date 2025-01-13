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
        <h2>Articles</h2>
        <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            try {
                $stmt = $pdo->query('SELECT * FROM article ORDER BY date DESC');

                echo '<table>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Title</th>';
                echo '<th>Actions</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                foreach ($stmt as $article) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($article['title']) . '</td>';
                    echo '<td>';
                    echo '<a href="editarticle.php?id=' . htmlspecialchars($article['id']) . '">Edit</a> | ';
                    echo '<a href="deletearticle.php?id=' . htmlspecialchars($article['id']) . '" onclick="return confirm(\'Are you sure you want to delete this article?\');">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } catch (PDOException $e) {
                echo '<p class="error">Error fetching articles: ' . htmlspecialchars($e->getMessage()) . '</p>';
            }
        } else {
            echo '<p class="error">You must be logged in to view this page.</p>';
        }
        ?>
    </article>
</main>

<?php include 'includes/footer.php'; ?>
