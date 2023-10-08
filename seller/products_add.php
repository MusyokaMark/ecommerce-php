<?php
	include 'includes/session.php';
	include 'includes/slugify.php';

	if(isset($_POST['add'])){
		$name = $_POST['name'];
		$slug = slugify($name);
		$category_id = $_POST['category'];
		$subcategory_id = $_POST['subcategory_id'];
		$price = $_POST['price'];
		$description = $_POST['description'];
		$filename = $_FILES['photo']['name'];

		// Check if the user is logged in and their user ID is stored in the session
		if(isset($_SESSION['user'])){
			$user_id = $_SESSION['user']; // Assuming the user ID is stored in 'id' key of the session array
		}
		else{
			// Handle the case where the user is not logged in or user ID is not available in the session
			$_SESSION['error'] = 'User not logged in.';
			header('location: login.php'); // Redirect to the login page or handle the error as needed.
			exit(); // Terminate script execution
		}

		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM products WHERE slug=:slug");
		$stmt->execute(['slug'=>$slug]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Product already exists';
		}
		else{
			if(!empty($filename)){
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$new_filename = $slug.'.'.$ext;
				move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$new_filename);	
			}
			else{
				$new_filename = '';
			}

			try{
				$stmt = $conn->prepare("INSERT INTO products (user_id, category_id, subcategory_id, name, description, slug, price, photo) VALUES (:user_id, :category_id, :subcategory_id, :name, :description, :slug, :price, :photo)");
				$stmt->execute(['user_id' => $user_id, 'category_id' => $category_id, 'subcategory_id' => 7, 'name' => $name, 'description' => $description, 'slug' => $slug, 'price' => $price, 'photo' => $new_filename]);
				$_SESSION['success'] = 'Product added successfully';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	} 
	else{
		$_SESSION['error'] = 'Fill up the product form first';
	}

	header('location: products.php');
?>
