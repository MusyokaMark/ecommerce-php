<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue layout-top-nav" style="margin-top: 0px;">
	<div class="wrapper">

		<?php include 'includes/navbar.php'; ?>

		<div class="content-wrapper">
			<div class="container">

				<!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-sm-9">
							<?php
							if (isset($_SESSION['error'])) {
								echo "
	        					<div class='alert alert-danger'>
	        						" . $_SESSION['error'] . "
	        					</div>
	        				";
								unset($_SESSION['error']);
							}
							?>
							<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
								<ol class="carousel-indicators">
									<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
									<li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
									<li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
								</ol>
								<div class="carousel-inner">
									<div class="item active">
										<img src="images/banner1.png" alt="First slide">
									</div>
									<div class="item">
										<img src="images/banner2.png" alt="Second slide">
									</div>
									<div class="item">
										<img src="images/banner3.png" alt="Third slide">
									</div>
								</div>
								<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
									<span class="fa fa-angle-left"></span>
								</a>
								<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
									<span class="fa fa-angle-right"></span>
								</a>
							</div>

							<h2>Random Products</h2>
							<div class="row">
								<?php
								$conn = $pdo->open();
								try {
									$stmt = $conn->prepare("SELECT * FROM products ORDER BY RAND() LIMIT 6");
									$stmt->execute();
									foreach ($stmt as $row) {
										$image = (!empty($row['photo'])) ? 'images/' . $row['photo'] : 'images/noimage.jpg';
								?>
										<div class="col-sm-4">
											<div class="box box-solid">
												<div class="box-body prod-body" style="max-width: 100px; max-height: 150px; display: flex; flex-direction: column; align-items: center; text-align: left;">
													<img src="<?php echo $image; ?>" class="img-responsive" alt="<?php echo $row['name']; ?>" style="max-width: 100px; max-height: 100px; margin: auto;">
													<h5><a href="product.php?product=<?php echo $row['slug']; ?>" style="font-size: 12px;"><?php echo $row['name']; ?></a></h5>
												</div>
												<div class="box-footer" style="font-size: 12px;">
													<b>Ksh <?php echo number_format($row['price'], 2); ?></b>
												</div>
											</div>
										</div>
								<?php
									}
								} catch (PDOException $e) {
									echo "There is some problem in connection: " . $e->getMessage();
								}
								$pdo->close();
								?>
							</div>

						</div>
						<div class="col-sm-3">
							<?php include 'includes/sidebar.php'; ?>
						</div>
					</div>
				</section>

			</div>
		</div>

		<?php include 'includes/footer.php'; ?>
	</div>

	<?php include 'includes/scripts.php'; ?>
</body>

</html>