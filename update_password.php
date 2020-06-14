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
    $c = $conn->query("select * from users where id='$_SESSION[id]' and password='$_POST[password]'");
    if($c->num_rows<1){
        echo "Invalid Password!!";
        die();
    }
    $sql = "update users set password='$_POST[newpassword]' where id='$_SESSION[id]'";
    if ($conn->query($sql) === TRUE) {
    $status =  "SUCCESS";
    } else {
        $status=  "ERROR" . $conn->error;
    }
    echo $status;
    $conn->close();

?>