<?php include_once('partials/header.php'); ?>
<?php 
	$title = $body = '';
	$error = array("title"=>"","body"=>"");
	if(isset($_POST['id']) && !empty($_POST['id'])){

		$input_title = trim($_POST['title']);
		$input_body = trim($_POST['body']);

		// validate title
		if(empty($input_title)){
			$error['title'] = "Title is required";
			
		}else{
			$title = $input_title;
			
		}

		// validate body
		if(empty($input_body)){
			$error['body'] = "Body required";
			
		}else{
			$body = $input_body;

		}

		if(empty($error['title']) && empty($error['body'])){
			// prepare a statement
			$sql = "UPDATE tbl_note SET `title` = ?, `body` = ? WHERE `note_id` = ?";
			if($stmt = mysqli_prepare($link, $sql)){
				// bind variables to the statement as params
				mysqli_stmt_bind_param($stmt, 'ssi', $param_title, $param_body, $param_id);

				// set parameters
				$param_title = $title;
				$param_body = $body;
				$param_id = trim($_POST['id']);

				if(mysqli_stmt_execute($stmt)){
					
					header('Location: notepage.php');
					exit();
				}else{
					// echo "could not execute";
					header("location: error.php");
					exit();
				}
			}else{
				// echo "error occurred";
				header("location: error.php");
				exit();
			}
		}



	}elseif(isset($_GET['id']) && !empty($_GET['id'])){
		$id = trim($_GET['id']);
		

		// prepare a statement
		$sql = "SELECT * FROM tbl_note WHERE note_id = ?";
		if($stmt = mysqli_prepare($link, $sql)){
			// bind variables to the prepared statemnet as parameters.
			mysqli_stmt_bind_param($stmt, 'i', $param_id);

			// set parameters
			$param_id = $id;

			if(mysqli_stmt_execute($stmt)){
				// execute sucessfully get data
				$result = mysqli_stmt_get_result($stmt);
				if(mysqli_num_rows($result) == 1){
					// fetch data
					$row = mysqli_fetch_array($result);

					$title = $row['title'];
					$body = $row['body'];

				}else{
					// echo "no record found";
					header("location: error.php");
					exit();
				}
			}else{
				// echo 'unable to execute';
				header("location: error.php");
				exit();
			}
		}

		
	}
?>

<main>
	<div class="container">
            <div class="row">
                <div class="col s12">
                    <h2>Update Note</h2>
                    <form action = "update.php" method="POST">
                        <div class="row">
                            <div class="col s12 input-field">
                                <input id="title" type="text" name="title" class="validate" value="<?php echo $title; ?>">
                                <label for="title">Title</label>
                                <div class="red-text"><?php echo $error['title']; ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 input-field">
                                <textarea name="body" id="body" class="materialize-textarea"><?php echo $body; ?></textarea>
                                <label for="body">Note</label>
                                <div class="red-text"><?php echo $error['body']; ?></div>
                            </div>
                        </div>
                        <!-- <a href="" type="submit" name="action" class="btn">Submit</a> -->
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <button type="submit" name="action" class="btn btn-small">Update</button>
                        <a href="notepage.php" class="btn btn-small">Back</a>
                    </form>
                </div>
            </div>
        </div>
</main>

<?php include_once('partials/footer.php'); ?>