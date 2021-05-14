<?php

include_once 'partials/header.php';
?>
<?php

	if(isset($_POST['id']) && !empty($_POST['id'])){
		// echo "data deleting";
		// var_dump($_POST);
		// delete the record
		$sql = "DELETE FROM tbl_note WHERE note_id = ?";
		if($stmt = mysqli_prepare($link, $sql)){
			// bind variables to statement
			mysqli_stmt_bind_param($stmt, 'i', $param_id);

			// set parameters
			$param_id = trim($_POST['id']);

			if(mysqli_stmt_execute($stmt)){
				header('Location: notepage.php');
			}else{
				// echo "Could not delete record";
				header("location: error.php");
				exit();
			}
		}

		mysqli_stmt_close($stmt);
		
		mysqli_close($link);
	}
	

?>

<main>
	<div class="container">
		<div class="row">
			<div class="col s12">
				<div class="card">
					<div class="card-content">
						
					
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

							<span class="card-header">
								Are You Sure You Want to DELETE This Note?
							</span>
							<input type="hidden" name="id" value="<?php echo isset($_GET['id'])? $_GET['id']:'' ;?>">
							<div class="row">
								<!-- <input type="submit" name="submit" class="btn" value="Yes"> -->
								<button class="btn waves-effect waves-light" type="submit" name="action">Yes</button>
							
						</form>

						<a href="notepage.php" class="btn">No</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


</main>

<?php include_once 'partials/footer.php';?>