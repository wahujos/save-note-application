<?php 

	include_once('partials/header.php');

	if(isset($_GET['id']) && !empty(trim($_GET['id']))){

		$id = trim($_GET['id']);

		// echo $id;
		// exit();

		// Query the database
		$sql = "SELECT * FROM tbl_note WHERE note_id = ?";
		if($stmt = mysqli_prepare($link, $sql)){
			// bind variables as parameters to the prepared statement
			mysqli_stmt_bind_param($stmt, 'i', $param_id);
			// set parameters
			$param_id = $id;

			// Attempt to execute the statement
			if(mysqli_stmt_execute($stmt)){
				// echo "executed successfully";
				// exit();
				$result = mysqli_stmt_get_result($stmt);
				if(mysqli_num_rows($result) == 1){

					$row = mysqli_fetch_array($result);

					$title = $row['title'];
					$body = $row['body'];
				// 	echo $title."<br>";
				// 	echo $body;
				 }
			}
		}
	}

 ?>

 <main>
 	<div class="container">
 		<div class="row">
 			<div class="col s12">
 				<h2>Read Note</h2>
 				<div class="row">
 					<div class="card">
 						<div class="card-content">
 							<span class="card-title">
 								<h4><?php echo $title; ?></h4>
 							</span>
 							<p class="flow-text"><?php echo $body; ?></p>
 						</div>
 						<div class="card-action">
 							<a href="notepage.php">Back</a>
 						</div>
 					</div>
 				</div>
 			</div>
 		</div>
 	</div>
 </main>



<?php
	include_once('partials/footer.php');

?>