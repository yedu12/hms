<?php include('header.php');?>
<?php 
    if($_POST['id']){
        $servername = "localhost";
        $username = "root";

        // Create connection
        $conn = new mysqli($servername, $username, '','hms');
        // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
        $status = '';
        $sql = "select * from users where id = '$_POST[id]'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['who'] = $row['who'];
            header("Location: index.php"); 
        } else {
            $status=  "Invali id/password";
        }
        $conn->close();
    }
?>
    <div class="container" id='nav-below-nody'>
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4" >
                    <h3 style="font-family: fantasy;">Student Login</h3>
                    <form id="login_form" method="POST">
                            <div id="username">
                                <i class="fa fa-user fa-lg fa-fw" aria-hidden="true"></i>
                                <input name="id" id="username" type="text" placeholder="Username" required="">
                                
                            </div>
                            <div id="password"> 
                                <i class="fa fa-key fa-lg fa-fw" aria-hidden="true"></i>
                                <input name="password" id="password" type="password" placeholder="Password" required="">
                            </div>
                            <div>
                                <input name="submit" value="Submit" type="submit" >
                             </div>
                                <br>
                            <p><a href="./signup.php" id="links">I don't have accout</a>

                            <a href="#" id="links" style="color: crimson;">Forgot password</a></p>

                            <p id="Error"></p>
                            
                        </form>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>
</body>
</html>

