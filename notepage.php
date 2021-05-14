<?php

// session_start();
include_once('partials/header.php');


if(!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] !== true)
{
    // redirect to login
     header('Location: login.php');
    exit();
   
}

$error = array('title'=>'','body'=>'');
// $title = $body = '';

if(isset($_POST['action'])){

    $title = trim(htmlspecialchars($_POST['title']));
    $body = trim(htmlspecialchars($_POST['body']));

    if(empty($title)){
        $error['title'] = "Enter title";
        
    }else{
        $title = $title;
    }

    if(empty($body)){
        $error['body'] = "Enter text";
        
    }else{
        $body = $body;
    }

    if(empty($error['title']) && empty($error['body'])){
        // prepare a statement

        $sql = "INSERT INTO tbl_note (title, body, user_id) VALUES (?,?,?)";
        $stmt = mysqli_prepare($link, $sql);

        // bind variables to the statement
        mysqli_stmt_bind_param($stmt, 'ssi', $param_title, $param_body, $param_user_id);

        // set parameters
        $param_title = $title;
        $param_body = $body;
        $param_user_id = $_SESSION['id'];

        // Attemp to execute 

        if(mysqli_stmt_execute($stmt)){
             // echo "Data entered successfully";

             $_SESSION['data'] = "Note Created Successfully";
           // query the database to check whether we have data
            // prepare a statement
            
        }else{
            // echo "unable to execute";
            header('Location: error.php');
            exit();
        }

    }

        
}

?>


  <main>
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <?php
                        if(isset($_SESSION['data'])){
                            echo "<div class='card-panel green lighten-3'>".$_SESSION['data']."</div>";
                            unset($_SESSION['data']);
                        }
                    ?>
                    <h2>Create a Note</h2>
                    <form action = "notepage.php" method="POST">
                        <div class="row">
                            <div class="col s12 input-field">
                                <input id="title" type="text" name="title" class="validate">
                                <label for="title">Title</label>
                                <div class="red-text"><?php echo $error['title']; ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 input-field">
                                <textarea name="body" id="body" class="materialize-textarea"></textarea>
                                <label for="body">Note</label>
                                <div class="red-text"><?php echo $error['body']; ?></div>
                            </div>
                        </div>

                        <button type="submit" name="action" class="btn btn-small">Submit</button>
                        
                        

                    </form>
                </div>
            </div>
            <?php

                $param_userid = mysqli_real_escape_string($link,$_SESSION['id']);
                $sql = "SELECT * FROM tbl_note WHERE user_id =  $param_userid";



            if($result = mysqli_query($link, $sql)){
                if(mysqli_num_rows($result) > 0){
                    // echo "you have data";
                    echo '<div class="row">
                            <div class="col s12">
                                 <h4>Saved Notes</h4>
                <table class="centered responsive-table">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Action</th>
                        
                        
                    </tr>
                    </thead>
                    <tbody>';

                    while($row = mysqli_fetch_assoc($result)){
                        echo "<tr>";
                        echo "<td>".substr($row['title'], 0, 20)."</td>";
                        echo "<td>". date('d/m/Y', strtotime($row['created_at']))."</td>";
                        echo "<td>". date('H:i', strtotime($row['created_at']))."</td>";
                        echo '<td>';

                            echo '<a href="read.php?id='.$row['note_id'].'"><i class="material-icons teal-text tooltipped" data-position="left" data-tooltip="Read Note">event_note</i></a>';
                            echo '<a href="update.php?id='.$row['note_id'].'"><i class="material-icons teal-text tooltipped" data-position="top" data-tooltip="Update Note">update</i></a>';
                            echo '<a href="delete.php?id='.$row['note_id'].'"><i class="material-icons teal-text tooltipped" data-position="right" data-tooltip="Delete Note">delete</i></a>';


                        echo '</td>';
                        $var = $row['note_id'];
                        $_SESSION['noteid'] = $var;
                      
                        echo "</tr>";
                    }

                    echo '
                    </tbody>
                </table>
            </div>
            </div>';
            mysqli_free_result($result);
        }
    }


             ?>
            
        </div>
    </main> 
    
<?php

include_once('partials/footer.php');
?>

