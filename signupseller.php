<?php include 'includes/session.php'; ?>
<?php
if (isset($_SESSION['user'])) {
    header('location: cart_view.php');
}

if (isset($_SESSION['captcha'])) {
    $now = time();
    if ($now >= $_SESSION['captcha']) {
        unset($_SESSION['captcha']);
    }
}

// Include your database connection code here and fetch categories and subcategories from the database
// Replace the placeholders with your actual database connection and query
$conn = new PDO("mysql:host=localhost;dbname=ecomm", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$categories = $conn->query("SELECT * FROM category")->fetchAll(PDO::FETCH_ASSOC);
$counties = $conn->query("SELECT * FROM counties")->fetchAll(PDO::FETCH_ASSOC);
$subcategory = $conn->query("SELECT * FROM subcategory")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'includes/header.php'; ?>

<body class="hold-transition register-page">
    <div class="register-box">
        <?php
        if (isset($_SESSION['error'])) {
            echo "
          <div class='callout callout-danger text-center'>
            <p>" . $_SESSION['error'] . "</p> 
          </div>
        ";
            unset($_SESSION['error']);
        }

        if (isset($_SESSION['success'])) {
            echo "
          <div class='callout callout-success text-center'>
            <p>" . $_SESSION['success'] . "</p> 
          </div>
        ";
            unset($_SESSION['success']);
        }
        ?>
        <div class="register-box-body">
            <p class="login-box-msg">Become a Seller</p>

            <form action="registerseller.php" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" name="firstname" placeholder="Firstname" value="<?php echo (isset($_SESSION['firstname'])) ? $_SESSION['firstname'] : '' ?>" required>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" name="lastname" placeholder="Lastname" value="<?php echo (isset($_SESSION['lastname'])) ? $_SESSION['lastname'] : '' ?>" required>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo (isset($_SESSION['email'])) ? $_SESSION['email'] : '' ?>" required>
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" name="shopname" placeholder="Shop Name" value="<?php echo (isset($_SESSION['shopname'])) ? $_SESSION['shopname'] : '' ?>" required>
                            <span class="glyphicon glyphicon-shopping-cart form-control-feedback"></span>
                        </div>
                    </div>

                </div>

                <input type="hidden" name="is_vendor" value="1">

                <!-- ... Previous code ... -->

                <!-- Category Dropdown -->
                <!-- <div class="form-group">
                    <label for="category">Select Category</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="">Select a category</option>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div> -->

                <!-- Subcategory Dropdown -->
                <!-- <div class="form-group">
                    <label for="subcategory">Select Subcategory</label>
                    <select class="form-control" id="subcategory" name="subcategory" required>
                        <option value="">Select a subcategory</option>
                        <?php foreach ($subcategory as $subcategory) : ?>
                            <option value="<?php echo $subcategory['id']; ?>"><?php echo $subcategory['name']; ?></option>
                        <?php endforeach; ?>
                      
                    </select>
                </div> -->

                <!-- Location Dropdown -->
                <!-- <div class="form-group">
                    <label for="location">Select Location</label>
                    <select class="form-control" id="location" name="location" required>
                        <option value="">Select a location</option>
                        <?php foreach ($counties as $counties) : ?>
                            <option value="<?php echo $counties['id']; ?>"><?php echo $counties['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div> -->

                <!-- ... Remaining code ... -->

                <!-- Password and Repeat Password Fields -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <input type="password" class="form-control" name="repassword" placeholder="Retype password" required>
                            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                        </div>
                    </div>
                </div>

                <!--
        Uncomment the following code if you want to include reCAPTCHA
        Replace "YOUR_RECAPTCHA_SITE_KEY" with your actual reCAPTCHA site key
        -->
                <!--
        <div class="form-group">
          <div class="g-recaptcha" data-sitekey="YOUR_RECAPTCHA_SITE_KEY"></div>
        </div>
        -->
                <hr>
                <div class="row">
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat" name="signupseller"><i class="fa fa-pencil"></i> Sign Up</button>
                    </div>
                </div>
            </form>
            <br>
            <a href="login.php">I already have a membership</a><br>
            <a href="index.php"><i class="fa fa-home"></i> Home</a>
        </div>
    </div>

    <?php include 'includes/scripts.php' ?>
</body>

</html>