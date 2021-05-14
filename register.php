
<?php 
// session_start();
	include_once('partials/header.php');

    $inputname = $inputemail = $inputpassword = '';
    $error = array('name'=> '','email'=>'','password'=>'');

    if(isset($_POST['action'])){
        $inputname = trim(htmlspecialchars($_POST['name']));
        $inputemail = trim(htmlspecialchars($_POST['email']));
        $inputpassword = trim(htmlspecialchars($_POST['password']));

       
        // validate name
        if(empty($inputname)){
            $error['name'] = "Name is required";

        }elseif(!preg_match('/^([a-zA-Z\' ])+$/', $inputname)){
            $error['name'] = "Name cannot contain numbers";
            
        }else{
            $name = $inputname;
        }

        // validate email
        if(empty($inputemail)){
            $error['email'] = "Email is required";
        }else
        if(!filter_var($inputemail, FILTER_VALIDATE_EMAIL)){
            $error['email'] = "Input a valid email";
            
        }else{
            // $email = $email;

            // prepare statement
            $sql = "SELECT * FROM tbl_user WHERE email = ?";
            $stmt = mysqli_prepare($link, $sql);

            // bind variables to the prepared statement

            mysqli_stmt_bind_param($stmt, 's', $param1_email);

            // Set Parameters
            $param1_email = $inputemail;

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                // $row = mysqli_stmt_num_rows($stmt);
                // echo $row;
                // exit();
                if(mysqli_stmt_num_rows($stmt) >= 1){
                    $error['email'] = "Email already taken";
                    
                }else{
                    $email = $inputemail;
                   
                }
            }

            mysqli_stmt_close($stmt);
        }


        // validate password
        if(empty($inputpassword)){
            $error['password'] = "Password required";
        }else{
            $password = $inputpassword;
        }
        
        if(empty($error['name']) && empty($error['email']) && empty($error['password'])){


            // prepare statement.
            $sql = "INSERT INTO tbl_user (name, email, password) VALUES (?,?,?)";
            $stmt = mysqli_prepare($link, $sql);

            // bind variables to statement as param

            mysqli_stmt_bind_param($stmt, 'sss', $param_name, $param_email, $param_password);

            // Set Parameters
            $param_name = $name;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if(mysqli_execute($stmt)){
                $_SESSION['register'] = "Sucessfully registered";
                header('Location: login.php');
                exit();

            }else{
                // echo "Something went Wrong";
                header("Location: error.php");
            }

            mysqli_stmt_close($stmt);

            mysqli_close($link);
        }

    }

 ?>

    <main>
    <section>
        <div class="container">
            <div class="row ">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">
                            Register
                        </span>
                        <div class="row">
                            <div class="col s12 m6 l6">
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method ="POST"> 
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="name" type="text" name="name" class="validate">
                                            <label for="name">Your Name</label>
                                            <div class="red-text"><?php echo $error['name']; ?></div>
                                          </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="email" type="email" name="email" class="validate">
                                            <label for="email">Email</label>
                                            <div class="red-text"><?php echo $error['email']; ?></div>
                                          </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="password" type="password" name="password" class="validate">
                                            <label for="password">Password</label>
                                            <div class="red-text"><?php echo $error['password']; ?></div>
                                          </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12 input-field">
                                            
                                            <button class="btn waves-effect waves-light" type="submit" name="action">Submit</button>
                                        </div>
                                    </div>
                                    <p>Already have an account? <a href="login.php">Login</a></p>
                                </form>
                            </div>
                            <div class="col s12 m6 l6 hide-on-small-only">
                                <img src="img/book.jpg" alt="book-image" class="responsive-img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
include_once('partials/footer.php');

?>