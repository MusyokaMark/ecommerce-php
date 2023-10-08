<?php
include 'includes/conn.php';
session_start();

if (isset($_SESSION['admin'])) {
    header('location: admin/home.php');
    // Edit it to admin/home.php
}

// Seller session
// if (isset($_SESSION['seller'])) {
//     header('location: seller/home.php');
// }

if (isset($_SESSION['user'])) {
    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->execute(['id' => $_SESSION['user']]);
        $user = $stmt->fetch();

        if ($user['is_vendor'] == 1) {
            header('location: seller/home.php'); // Redirect to the seller panel
        }

    } catch (PDOException $e) {
        echo "There is some problem in connection: " . $e->getMessage();
    }

    $pdo->close();
}
?>
