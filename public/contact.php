<?php
include 'includes/header.php';
include 'includes/navbar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare('INSERT INTO communications (name, email, telephone, question, status) 
                               VALUES (:name, :email, :telephone, :question, "Pending")');
        $stmt->execute([
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'telephone' => $_POST['telephone'],
            'question' => $_POST['question']
        ]);

        $successMessage = "Thank you! Your message has been submitted.";
    } catch (PDOException $e) {
        $errorMessage = "Error submitting your message: " . htmlspecialchars($e->getMessage());
    }
}
?>
<main>
    <article>
        <h2>Contact Us</h2>
        <?php if (isset($successMessage)): ?>
            <p class="success"><?php echo htmlspecialchars($successMessage); ?></p>
        <?php elseif (isset($errorMessage)): ?>
            <p class="error"><?php echo htmlspecialchars($errorMessage); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="telephone">Telephone:</label>
            <input type="text" id="telephone" name="telephone" required>

            <label for="question">Your Question:</label>
            <textarea id="question" name="question" required></textarea>

            <button type="submit">Submit</button>
        </form>
    </article>
</main>
<?php include 'includes/footer.php'; ?>
