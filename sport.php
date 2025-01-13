<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="/styles.css"/>
        <meta name="summary" content="Assignment 2024" />
		<title>Northampton News - Latest Sport</title>
	</head>
	<body>
		<header>
			<section>
				<h1>Northampton News</h1>
			</section>
		</header>
		<nav>
			<ul>
				<li><a href="/">Home</a></li>
				<li><a href="latest.php">Latest Articles</a></li>
				<li><a href="#">Select Category</a>
					<ul>
						<li><a href="news.php">Local News</a></li>
						<li><a href="events.php">Local Events</a></li>
						<li><a href="sport.php">Sport</a></li>
					</ul>
				</li>
				<li><a href="contact.php">Contact us</a></li>
			</ul>
		</nav>
		<img src="/images/banners/randombanner.php" />
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
$pdo = new PDO('mysql:host=mysql;dbname=news;charset=utf8', 'student', 'student');

$stmt = $pdo->prepare('SELECT * FROM article WHERE categoryId = 3 ORDER by date desc');
$stmt->execute();

$articles = $stmt->fetchAll();

echo '<h2>Sport</h2>';

foreach ($articles as $article) {
    echo '<hr />';
    echo '<h3>' . $article['title'] . '</h3>';
    echo '<em>' . $article['date'] . '</h2>';
    echo '<p>' . $article['description'] . '</p>';
}


?>
            </article>

        </main>

		<footer>
			&copy; Northampton News 2020
		</footer>
	</body>
</html>
