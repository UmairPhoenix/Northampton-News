<?php
include 'includes/header.php';
include 'includes/navbar.php';

$articleId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare('
    SELECT article.*, staff.username AS author 
    FROM article 
    JOIN staff ON article.author_id = staff.id 
    WHERE article.id = :id
');
$stmt->execute(['id' => $articleId]);
$article = $stmt->fetch();

if (!$article) {
    die('Article not found.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'superadmin') {
        $userId = $_SESSION['user_id'];
        $comment = $_POST['comment'];

        if (!empty($comment)) {
            $stmt = $pdo->prepare('
                INSERT INTO comments (article_id, user_id, comment, date) 
                VALUES (:article_id, :user_id, :comment, NOW())
            ');
            $stmt->execute([
                'article_id' => $articleId,
                'user_id' => $userId,
                'comment' => $comment,
            ]);
            echo '<p class="success">Comment added successfully!</p>';
        } else {
            echo '<p class="error">Comment cannot be empty.</p>';
        }
    } else {
        echo '<p class="error">Only regular users can post comments.</p>';
    }
}

$stmt = $pdo->prepare('
    SELECT comments.*, users.username 
    FROM comments 
    JOIN users ON comments.user_id = users.id 
    WHERE article_id = :article_id 
    ORDER BY date DESC
');
$stmt->execute(['article_id' => $articleId]);
$comments = $stmt->fetchAll();
?>

<main>
    <article>
        <h2><?php echo htmlspecialchars($article['title']); ?></h2>
        <?php if ($article['image']): ?>
            <img src="<?php echo htmlspecialchars($article['image']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" width="400">
        <?php endif; ?>
        <p>
            <em>By <a href="author.php?id=<?php echo $article['author_id']; ?>">
                <?php echo htmlspecialchars($article['author']); ?></a> on 
                <?php echo htmlspecialchars($article['date']); ?>
            </em>
        </p>
        <p><?php echo htmlspecialchars($article['description']); ?></p>

        <h3>Comments</h3>
        <?php if ($comments): ?>
            <ul>
                <?php foreach ($comments as $comment): ?>
                    <li>
                        <p><strong><?php echo htmlspecialchars($comment['username']); ?></strong> says:</p>
                        <p><?php echo htmlspecialchars($comment['comment']); ?></p>
                        <p><small>Posted on <?php echo htmlspecialchars($comment['date']); ?></small></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No comments yet. Be the first to comment!</p>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_id'])): ?>
            <h3>Add a Comment</h3>
            <form method="POST" action="">
                <label for="comment">Comment:</label>
                <textarea id="comment" name="comment" required></textarea>

                <button type="submit">Submit</button>
            </form>
        <?php else: ?>
            <p><a href="login.php">Log in</a> to post a comment.</p>
        <?php endif; ?>
    </article>
</main>

<?php include 'includes/footer.php'; ?>
