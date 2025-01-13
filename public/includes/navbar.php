<?php include $_SERVER['DOCUMENT_ROOT'] . '/config/db.php'; ?>
<nav>
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="latest.php">Latest Articles</a></li>
        <li><a href="#">Select Category</a>
            <ul>
                <?php
                $stmt = $pdo->query('SELECT * FROM category');
                while ($category = $stmt->fetch()) {
                    echo '<li><a href="category.php?id=' . $category['id'] . '">' . htmlspecialchars($category['name']) . '</a></li>';
                }
                ?>
            </ul>
        </li>
        </li>
        <li><a href="/public/contact.php">Contact us</a></li>
        <li><a href="/public/advertise.php">Advertise with Us</a></li>
        <li><a href="/public/register.php">Register</a></li>
        <li><a href="/public/login.php">Login</a></li>
    </ul>
</nav>
<img src="../images/banners/randombanner.php" />