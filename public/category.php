<?php
include 'includes/header.php';
include 'includes/navbar.php';

$categoryId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare('SELECT * FROM category WHERE id = :id');
$stmt->execute(['id' => $categoryId]);
$category = $stmt->fetch();

if (!$category) {
    echo '<p class="error">Category not found.</p>';
    include 'includes/footer.php';
    exit;
}

$stmt = $pdo->prepare('SELECT id, title, date FROM article WHERE categoryId = :categoryId ORDER BY date DESC');
$stmt->execute(['categoryId' => $categoryId]);
$articles = $stmt->fetchAll();
?>

<main>
    <article>
        <h2>Articles in <?php echo htmlspecialchars($category['name']); ?></h2>
        <?php if ($articles): ?>
            <ul>
                <?php foreach ($articles as $article): ?>
                    <li>
                    <?php if (!empty($article['image'])): ?>
                        <img src="<?php echo htmlspecialchars($article['image']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" width="150">
                    <?php endif; ?>
                        <a href="article.php?id=<?php echo $article['id']; ?>">
                            <?php echo htmlspecialchars($article['title']); ?>
                        </a>
                        <small>(Published on <?php echo htmlspecialchars($article['date']); ?>)</small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No articles found in this category.</p>
        <?php endif; ?>
    </article>
</main>

<?php include 'includes/footer.php'; ?>
