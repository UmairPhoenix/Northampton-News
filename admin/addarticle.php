<?php 
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="/styles.css"/>
        <meta name="summary" content="Assignment 2024" />
		<title>Northampton News - Home</title>
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
				<li><a href="/latest.php">Latest Articles</a></li>
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
					<li><a href="addcategory.php">Add Category</a></li>
					<li><a href="addarticle.php">Add Article</a></li>
					<li><a href="categories.php">List Categories</a></li>
					<li><a href="articles.php">List Articles</a></li>
				</ul>
            </nav>
            <article>
                <h2>Add Article</h2>

                <?php

                if (isset($_SESSION['loggedin'])) {
                    if (isset($_POST['submit'])) {
                        $pdo = new PDO('mysql:host=mysql;dbname=news;charset=utf8', 'student', 'student');

                        $stmt = $pdo->prepare('INSERT INTO article (title, description, categoryId, date) VALUES (:title, :description, :categoryId, :date)');

                        $stmt->execute([
                            'title' => $_POST['title'],
                            'description' => $_POST['description'],
                            'categoryId' => $_POST['categoryId'],
                            'date' => (new DateTime())->format('Y-m-d H:i:s'),
                        ]);

                        echo 'Article added';
                    }
                    else {
                        ?>
                        <form action="addarticle.php" method="POST">
                            <label>Category</label>
                            <select name="categoryId">
                                <option value="1">Local News</option>
                                <option value="2">Local Events</option>
                                <option value="3">Sport</option>
                            </select>
                            <label>Article title:</label>
                            <input type="text" name="title" />
                            <label>Article text:</label>
                            <textarea name="description"></textarea>
                            <input type="submit" value="Submit" name="submit" />
                        </form>
                        <?php
                    }
                }
                else {
                    ?>
                    <form action="index.php" method="POST">
                       <label>Username</label>                                              
                       <input type="text" name="username" /> 
                       <label>Password</label>
                       <input type="password" name="password" />
                       <input type="submit" name="submit" value="submit" />
                    </form>
                    <?php   
                }
                ?>
            </article>

        </main>

		<footer>
			&copy; Northampton News 2020
		</footer>
	</body>
</html>
