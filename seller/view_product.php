<?php
include 'includes/session.php';
include 'includes/header.php';
?>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Products
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li>Products</li>
          <li class="active">Subcategories</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <?php
        // Check if the user is logged in and their user ID is stored in the session
        if (isset($_SESSION['user'])) {
          $user_id = $_SESSION['user'];

          if (isset($_GET['category_id'])) {
            $category_id = $_GET['category_id'];

            $conn = $pdo->open();

            // Fetch products for the selected category and user
            try {
              $stmt = $conn->prepare("SELECT * FROM products WHERE category_id = :category_id AND user_id = :user_id");
              $stmt->execute(['category_id' => $category_id, 'user_id' => $user_id]);

              echo '<div class="table-responsive">
                      <table class="table table-bordered table-striped table-sm">
                        <thead>
                          <tr>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Tool</th>
                          </tr>
                        </thead>
                        <tbody>';

              foreach ($stmt as $row) {
                echo '<tr>
                        <td>' . $row['name'] . '</td>
                       
                        <td>' . $row['price'] . '</td>
                        <!-- Add more columns for other properties as needed -->
                        
                      </tr>';
              }

              echo '</tbody></table></div>';
            } catch (PDOException $e) {
              echo $e->getMessage();
            }

            $pdo->close();
          } else {
            echo '<p>No category selected.</p>';
          }
        } else {
          // Redirect to the login page or display an error message if the user is not logged in
          //header("Location: login.php"); // Redirect to the login page
          exit(); // Terminate script execution
        }
        ?>
      </section>
    </div>
    <?php include 'includes/footer.php'; ?>
  </div>
  <!-- ./wrapper -->
  <?php include 'includes/scripts.php'; ?>
</body>
</html>
