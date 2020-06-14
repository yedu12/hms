<?php 
    $servername = "localhost";
    $username = "root";
    session_start();
    // Create connection
    $conn = new mysqli($servername, $username, '','hms');
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    $status = '';
    if($_POST['what']=="updates"){

        $sql = "delete from notification where id='$_POST[id]'";
        if ($conn->query($sql) === TRUE) {
        $status =  "SUCCESS";
        } else {
            $status=  "ERROR" . $conn->error;
        }

    }
    else if ($_POST['what']=="events"){

        $sql = "delete from events where id='$_POST[id]'";
        if ($conn->query($sql) === TRUE) {
        $status =  "SUCCESS";
        } else {
            $status=  "ERROR" . $conn->error;
        }

    }
    echo $status;
    $conn->close();

?>