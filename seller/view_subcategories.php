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
          Subcategories
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
        if (isset($_GET['category_id'])) {
          $category_id = $_GET['category_id'];
        } else {
          echo '<p>No category selected.</p>';
          exit; // Exit if no category is selected.
        }

        $conn = $pdo->open();

        // Fetch subcategories for the selected category
        try {
          $stmt = $conn->prepare("SELECT * FROM subcategory WHERE category_id = :category_id");
          $stmt->execute(['category_id' => $category_id]);

          echo '<table class="table table-bordered">
                  <thead>
                    <th>Subcategory Name</th>
                  </thead>
                  <tbody>';

          foreach ($stmt as $row) {
            echo '<tr><td>' . $row['name'] . '</td></tr>';
          }

          echo '</tbody></table>';
        } catch (PDOException $e) {
          echo $e->getMessage();
        }

        $pdo->close();
        ?>
      </section>
    </div>
    <?php include 'includes/footer.php'; ?>
  </div>
  <!-- ./wrapper -->
  <?php include 'includes/scripts.php'; ?>
</body>
</html>
