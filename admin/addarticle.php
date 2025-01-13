<?php
    include 'includes/header.php';
    include 'includes/navbar.php';
?>

<main>
    <article>
        <h2>Add Article</h2>
        <?php
        if (isset($_POST['submit'])) {
            try {
                $title = $_POST['title'];
                $description = $_POST['description'];
                $categoryId = $_POST['categoryId'];
                $authorId = $_SESSION['user_id'];
                $date = (new DateTime())->format('Y-m-d H:i:s');

                $imagePath = null;
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = '../uploads/';
                    $imagePath = $uploadDir . basename($_FILES['image']['name']);
                    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
                }

                $stmt = $pdo->prepare('
                    INSERT INTO article (title, description, categoryId, author_id, date, image) 
                    VALUES (:title, :description, :categoryId, :author_id, :date, :image)
                ');
                $stmt->execute([
                    'title' => $title,
                    'description' => $description,
                    'categoryId' => $categoryId,
                    'author_id' => $authorId,
                    'date' => $date,
                    'image' => $imagePath,
                ]);

                echo '<p class="success">Article added successfully!</p>';
            } catch (PDOException $e) {
                echo '<p class="error">Error adding article: ' . htmlspecialchars($e->getMessage()) . '</p>';
            }
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <label for="title">Article Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Article Text:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="categoryId">Category:</label>
            <select id="categoryId" name="categoryId" required>
                <?php
                $stmt = $pdo->query('SELECT * FROM category');
                while ($category = $stmt->fetch()) {
                    echo '<option value="' . $category['id'] . '">' . htmlspecialchars($category['name']) . '</option>';
                }
                ?>
            </select>

            <label for="image">Upload Image:</label>
            <input type="file" id="image" name="image" accept="image/*">

            <button type="submit" name="submit">Add Article</button>
        </form>
    </article>
</main>

<?php include 'includes/footer.php'; ?>
