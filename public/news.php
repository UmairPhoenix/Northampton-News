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
            // Fetch articles for category ID 1 (Local News)
            $stmt = $pdo->prepare('SELECT * FROM article WHERE categoryId = :categoryId ORDER BY date DESC');
            $stmt->execute(['categoryId' => 1]);

            $articles = $stmt->fetchAll();

            echo '<h2>Latest News</h2>';

            foreach ($articles as $article) {
                echo '<hr />';
                echo '<h3>' . htmlspecialchars($article['title']) . '</h3>';
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
