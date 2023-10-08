<?php
include 'includes/session.php';

if (isset($_POST['category_id'])) {
    $category_id = $_POST['category_id'];

    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("SELECT * FROM subcategory WHERE category_id = :category_id");
        $stmt->execute(['category_id' => $category_id]);
        $subcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $options = '<option value="0">Select Subcategory</option>';

        foreach ($subcategories as $subcategory) {
            $options .= '<option value="' . $subcategory['id'] . '">' . $subcategory['name'] . '</option>';
        }

        echo json_encode(['status' => 'success', 'subcategories' => $options]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

    $pdo->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Category ID not provided']);
}
?>
