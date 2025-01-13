<?php
include 'includes/header.php';
include 'includes/navbar.php';

$authorId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

try {
    $stmt = $pdo->prepare('SELECT * FROM staff WHERE id = :id');
    $stmt->execute(['id' => $authorId]);
    $author = $stmt->fetch();

    if (!$author) {
        echo '<p>Author not found.</p>';
        include 'includes/footer.php';
        exit;
    }

    $stmt = $pdo->prepare('SELECT * FROM article WHERE author_id = :author_id ORDER BY date DESC');
    $stmt->execute(['author_id' => $authorId]);
    $articles = $stmt->fetchAll();
} catch (PDOException $e) {
    echo '<p>Error fetching author or articles: ' . htmlspecialchars($e->getMessage()) . '</p>';
    include 'includes/footer.php';
    exit;
}
?>
<main>
    <article>
        <h1>Articles by <?php echo htmlspecialchars($author['username']); ?></h1>
        <?php if (!empty($articles)): ?>
            <?php foreach ($articles as $article): ?>
                <div class="article">
                    <h2><?php echo htmlspecialchars($article['title']); ?></h2>
                    <p><?php echo htmlspecialchars($article['description']); ?></p>
                    <p><small>Published on <?php echo htmlspecialchars($article['date']); ?></small></p>
                </div>
                <hr />
            <?php endforeach; ?>
        <?php else: ?>
            <p>No articles found for this author.</p>
        <?php endif; ?>
    </article>
</main>
<?php include 'includes/footer.php'; ?>
