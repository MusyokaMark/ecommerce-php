<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Category
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li>Products</li>
          <li class="active">Category</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <?php
        if (isset($_SESSION['error'])) {
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              " . $_SESSION['error'] . "
            </div>
          ";
          unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              " . $_SESSION['success'] . "
            </div>
          ";
          unset($_SESSION['success']);
        }
        ?>
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
              </div>
              <div class="box-body">
                <table id="example1" class="table table-bordered">
                  <thead>
                    <th>Category Name</th>
                    <th>Tools</th>
                  </thead>
                  <tbody>
                    <?php
                    // Start the session (if not already started)
                    // session_start();

                    // Check if the user is logged in and their user ID is stored in the session
                    if (isset($_SESSION['user'])) {
                      $user_id = $_SESSION['user'];

                      $conn = $pdo->open();

                      try {
                        $stmt = $conn->prepare("SELECT DISTINCT c.*
                            FROM category c
                            INNER JOIN products p ON c.id = p.category_id
                            WHERE p.user_id = :user_id");
                        $stmt->execute(['user_id' => $user_id]);
                        foreach ($stmt as $row) {
                          echo "
                    <tr>
                      <td>" . $row['name'] . "</td>
                    <td>
                      <a href='view_subcategories.php?category_id=" . $row['id'] . "' class='btn btn-info btn-sm view-subcategories btn-flat'><i class='fa fa-eye'></i> View Subcategories</a>
                      <a href='view_product.php?category_id=" . $row['id'] . "&user_id=" . $_SESSION['user'] . "' class='btn btn-info btn-sm view-subcategories btn-flat'><i class='fa fa-eye'></i> View Products</a>

                </td>
        </tr>
      ";
                        }
                      } catch (PDOException $e) {
                        echo $e->getMessage();
                      }

                      $pdo->close();
                    } else {
                      // Redirect or display an error message if the user is not logged in
                      // header("Location: login.php"); 
                      // Redirect to the login page
                      exit(); // Terminate script execution
                    }
                    ?>


                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>

    </div>
    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/category_modal.php'; ?>

  </div>
  <!-- ./wrapper -->

  <?php include 'includes/scripts.php'; ?>
  <script>
    $(function() {
      $(document).on('click', '.edit', function(e) {
        e.preventDefault();
        $('#edit').modal('show');
        var id = $(this).data('id');
        getRow(id);
      });

      $(document).on('click', '.delete', function(e) {
        e.preventDefault();
        $('#delete').modal('show');
        var id = $(this).data('id');
        getRow(id);
      });

    });

    function getRow(id) {
      $.ajax({
        type: 'POST',
        url: 'category_row.php',
        data: {
          id: id
        },
        dataType: 'json',
        success: function(response) {
          $('.catid').val(response.id);
          $('#edit_name').val(response.name);
          $('.catname').html(response.name);
        }
      });
    }
  </script>
</body>

</html>