<?php
    include 'includes/header.php';
    include 'includes/navbar.php';
?>
<main>
    <nav>
        <ul>
            <li><a href="news.php">Local News</a></li>
            <li><a href="events.php">Local Events</a></li>
            <li><a href="sport.php">Sport</a></li>
        </ul>
    </nav>
    <article>
        <?php
        try {
            $stmt = $pdo->prepare('
                SELECT article.*, staff.username AS author 
                FROM article 
                JOIN staff ON article.author_id = staff.id
                ORDER BY article.date DESC
            ');
            $stmt->execute();
            $articles = $stmt->fetchAll();

            foreach ($articles as $article) {
                echo '<hr />';
                echo '<h3>' . htmlspecialchars($article['title']) . '</h3>';
                echo '<em>By <a href="author.php?id=' . $article['author_id'] . '">' . htmlspecialchars($article['author']) . '</a> on ' . htmlspecialchars($article['date']) . '</em>';
                echo '<p>' . htmlspecialchars($article['description']) . '</p>';
            }
        } catch (PDOException $e) {
            echo '<p>Error fetching articles: ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
        ?>
    </article>
</main>
<?php include 'includes/footer.php'; ?>
