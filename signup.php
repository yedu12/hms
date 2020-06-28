<?php include('header.php');?>
<?php 
$servername = "localhost";
$username = "root";

// Create connection
$conn = new mysqli($servername, $username, '','hms');
    if($_POST['id']){

        // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
        $status = '';
        $sql = "insert into users values('$_POST[name]','$_POST[id]','$_POST[phone]','$_POST[password]','$_POST[who]')";
        if ($conn->query($sql) === TRUE) {
            $sql2 = "insert into allocation values('$_POST[id]','$_POST[room]')";
            $conn-> query($sql2);
        $status =  "Sucessfully registered!! Go to login page <a href='login.php'>here</a>";
        } else {
            $status=  "Error inserting data: " . $conn->error;
        }

        
    }
$sql  = "select * from room";
$rooms = $conn->query($sql);
$conn->close();
?>
    <div class="container" id='nav-below-nody' >
        <div class="row" >
            <div class="col-sm-4"></div>
            <div class="col-sm-4" >
        <h3 style="font-family: fantasy;">Student Register</h3>
        <p><?php if($status){ echo $status;} ?></p>
            <form id="signup_form" method="POST" action=''>
               
                <div id="username" >
                    <label >CollegeId: </label>
                    <input name="id" id="username" type="text" required="">
                    
                </div>
                <div id="username">
                    <label >FullName: </label>
                    <input name="name" id="username" type="text" required="">
                    
                </div>
                <div id="password"> 
                    <label>Password:</label>
                    <input name="password" id="password" type="password"  required="">
                    <p >
                        <ol style="text-align: left;margin-left: 70px;list-style-type:None">
                            <li>1. 8 characters</li>
                            <li>2. Upper case letter (A-Z) </li>
                            <li>3. Lower case letter (a-z) </li>
                            <li>4. Digit (0-9)</li>
                            <li>5. Special character</li>
                        </ol>
                    </p>
                </div>
    
                <div id="phone"> 
                        <label>Mobile No:</label>
                        <input name="phone"  type="number" id="phone1" required> 
                </div>
                <div id="type"> 
                        <label>Who: </label>
                        <input name="who"  type="radio" id="who" value="1" required> Supervisor
                        <input name="who"  type="radio" id="who" value="2" required> Warden
                        <input name="who"  type="radio" id="who" value="3" required> Student
                </div>
                <div id="room"> 
                        <label>Room</label>
                        <select name='room'>
                            <option value = '' >Select</option>
                            <?php while($row = $rooms->fetch_assoc()){?>
                            <option value='<?php echo $row['id']; ?>'><?php echo $row['id']; ?></option>
                            <?php }?>
                        </select>
                </div>
                <div>
                    <input name="submit" value="Submit" type="submit" >
                 </div>
                   
                        <p><a href="./login.php" id="links">I have an account</a>&nbsp;
                        <a href="#" id="links">Forgot password</a></p>
            </form>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>
</body>

</html>

