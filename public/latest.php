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
            $stmt = $pdo->query('SELECT * FROM article ORDER BY date DESC');
            $articles = $stmt->fetchAll();

            echo '<h2>Latest Articles</h2>';

            foreach ($articles as $article) {
                echo '<hr />';
                echo '<h2>' . htmlspecialchars($article['title']) . '</h2>';
                echo '<em>' . htmlspecialchars($article['date']) . '</em>';
                echo '<p>' . htmlspecialchars($article['description']) . '</p>';
            }
        } catch (PDOException $e) {
            echo '<p>Error fetching articles: ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
        ?>
    </article>
</main>
<?php include 'includes/footer.php'; ?>
