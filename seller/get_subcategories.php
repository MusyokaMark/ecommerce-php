<?php
include 'includes/session.php';

if (isset($_POST['category_id'])) {
    $category_id = $_POST['category_id'];
    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("SELECT * FROM subcategory WHERE category_id = :category_id");
        $stmt->execute(['category_id' => $category_id]);

        $subcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($subcategories);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'An error occurred while fetching subcategories.']);
    }

    $pdo->close();
}
?>
