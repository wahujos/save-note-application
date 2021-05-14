<?php
// session_start();
include_once('partials/header.php');

    $inputemail = $inputpassword = '';
    $error = array("email"=>'', "password"=>'');
    if(isset($_POST['action'])){
        
        $inputemail = trim(htmlspecialchars($_POST['email']));
        $inputpassword = trim(htmlspecialchars($_POST['password']));

        // validate email
        if(empty($inputemail)){
            $error['email'] = "Email is required";
        }elseif(!filter_var($inputemail, FILTER_VALIDATE_EMAIL)){
            $error['email'] = "Input a valid email";
        }else{
            $email = $inputemail;
        }

        // validate password

        if(empty($inputpassword)){
            $error['password'] = "Password is required";
        }else{
            $password = $inputpassword;
        }


        if(empty($error['email']) && empty($error['password'])){
            // check whether the user is registered
            // prepare statement
            $sql = "SELECT user_id, name, email, password FROM tbl_user WHERE email = ?";
            $stmt = mysqli_prepare($link, $sql);
            // bind variables to the statement

            mysqli_stmt_bind_param($stmt, 's', $param_email);

                // set parameter
            $param_email = $email;
            // attempt to execute
            if(mysqli_stmt_execute($stmt)){
                // store the result
                mysqli_stmt_store_result($stmt);

                // check if user exits if yes verify password.

                if(mysqli_stmt_num_rows($stmt) === 1){
                    // bind results

                    mysqli_stmt_bind_result($stmt, $id, $name, $email, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password) == 1){
                            // password correct start a session
                            // echo "logged in sucessfully";
                                session_start();
                                $_SESSION['loggedin'] = true;
                                $_SESSION['id'] = $id;
                                
                                $_SESSION['name'] = $name;
                                $_SESSION['email'] = $email;

                                // Redirect user
                                header('Location: notepage.php');
                                exit();
                        }else{
                            // echo "password entered not valid";
                            $error['password'] = "password entered not valid";
                        }
                    }

                }else{
                    // echo "Enter correct Email";
                    $error['email'] = "enter correct email";
                }

                // echo "Logged in successfully";
            }
            else{
                // echo "failed to login ";
                header('Location: error.php');
                exit();
            }

            mysqli_stmt_close($stmt);
        }

        mysqli_close($link);


    }

?>

<main>
    <section>
        <div class="container">
            <div class="row ">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">
                            Login
                        </span>
                        <div class="row">
                            <div class="col s12 m6 l6">
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST"> 
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
                                    <p>Do not have an account yet? <a href="register.php">Register</a></p>
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