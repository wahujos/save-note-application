<?php
    session_start();
    include_once('./config/dbconnect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Document</title>
</head>
<body>

    <header>
        
            <nav class="teal">
                <div class="container">
                    <div class="nav-wrapper">
                    <a href="" class="brand-logo">Note</a>
                    <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                    <ul class="right hide-on-med-and-down">
                        <li><a href="">Welcome <?php echo (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) ? '<strong>'.ucwords($_SESSION['name']).'</strong>' : "Guest"; ?></a></li>

                        <?php echo (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) ? '<li><a href="logout.php"><strong>'.ucwords('Logout').'</strong></a></li>' : ""; ?>
                        
                    </ul>
                    </div>
                </div> 
          </nav>
            
          <ul class="sidenav" id="mobile-demo">
            <li><a href="">Welcome <?php echo (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) ? '<strong>'.ucwords($_SESSION['name']).'</strong>' : "Guest"; ?></a></li>
            <?php echo (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) ? '<li><a href="logout.php"><strong>'.ucwords('Logout').'</strong></a></li>' : ""; ?>

            
          </ul>       
    </header>