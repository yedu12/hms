<?php include('header.php');?>
<?php 
    if(!$_SESSION['id']){
        header("Location: login.php");
    }
    if($_SESSION['who']!=2){
        header("Location: index.php");
    }

?>
<?php 
    $servername = "localhost";
    $username = "root";

    // Create connection
    $conn = new mysqli($servername, $username, '','hms');
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    $status = '';
    $sql = "select * from users  where users.id = '$_SESSION[id]'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
       $error = "Something is wrong!";
    }

    $query3 = "select * from leave_request,users where approved='0' and users.id = leave_request.student_id ";
    $leave_requests = $conn->query($query3);


    $query4 = "select * from notification";
    $notifications = $conn->query($query4) ;


    $query5 = "select * from events";
    $events = $conn->query($query5) ;

    $query6 = "select room.id,count(student_id) as count from room left join allocation on room.id = allocation.room_id group by room.id";
    $rooms = $conn->query($query6) ;

    $conn->close();
?>

    <h3>Warden</h3>    
    <div class="tab">
        <button class="tablinks" onclick="openTab(event, 'Profile')" id="defaultOpen">Profile</button>
        <button class="tablinks" onclick="openTab(event, 'Change password')">Change password</button>
        <button class="tablinks" onclick="openTab(event, 'Leave approval')">Leave approval</button>
        <button class="tablinks" onclick="openTab(event, 'Updates/Announcement')" id="defaultOpen">Updates/Announcement</button>
        <button class="tablinks" onclick="openTab(event, 'Evens/Activites')">Evens/Activites</button>
        <button class="tablinks" onclick="openTab(event, 'rooms')">Rooms</button>
        <button class="tablinks" onclick="openTab(event, 'Logout')">Logout</button>
    </div>
    
    <div id="Profile" class="tabcontent">
        <div class="panel panel-success">
            <div class="panel-heading">Profile</div>
            <div class="panel-body">
                <form class="update" method="POST" action='#' name="user_details_form">
                    <div id="username">
                        <label >FullName: </label>
                        <input name="name" id="username" type="text" placeholder="KV Narayan" value="<?php  echo $row['name'];?>" required="">
                    </div>
                    <div id="phone"> 
                        <label>Mobile No:</label>
                        <input name="phone"  type="number" id="phone1" placeholder="9876543210" value = "<?php echo $row['phone'];?>"required> 
                    </div>
                </form>
                <div>
                    <button class='btn btn-primary' onclick="update_user_details()">Update</button>
                </div>
                

            </div>
        </div>
    </div>
    
    <div id="Change password" class="tabcontent">
        <div class="panel panel-success">
            <div class="panel-heading">Change password</div>
            <div class="panel-body">
            <form class="update" method="POST" name="update_password_form" >
                <div id="oldpassword">
                    <label >Old Password: </label>
                    <input name="password" id="password" type="password" required="">
                </div>
                <div id="newpassword"> 
                    <label>New Password:</label>
                    <input name="newpassword"  type="password" id="newpassword" required> 
                </div>
            </form>
            <div>
                <button class='btn btn-primary' onclick="update_password()">Update</button>
            </div>
        </div>
    </div>
    </div>
    <div id="Leave approval" class="tabcontent">
        <div class="panel panel-success">
            <div class="panel-heading">Leave approval</div>
            <div class="panel-body">

            <table class=table>
                    <thead><tr><td>Who</td><td>To</td><td>Reason</td><td>From Date</td><td>To Date</td><td>Approve</td></tr></thead>
                    <?php
                        while( $leave = $leave_requests -> fetch_assoc()){
                    ?>
                        <tr><td><?php echo $leave['name']; ?></td><td><?php echo $leave['where_to'];?></td><td><?php echo $leave['reason'];?></td><td><?php echo $leave['from_date'];?></td><td><?php echo $leave['to_date'];?></td><td><button onclick="leave_approve(this, '<?php echo $leave['leave_id'];?>')" >Approve</button></td></tr>
                        <?php } ?>
                </table>                    
                </table>

            </div>
        </div>
    </div>
    <div id="Updates/Announcement" class="tabcontent">
        <div class="panel panel-success">
            <div class="panel-heading">Update/Announcement</div>
            <div class="panel-body">
                <p>Recent</p>
                <table>
                    <thead>
                            <td>Time</td>
                            <td>Update/Announcement</td>
                            <td>Edit</td>
                            <td>Delete</td>                
                    </thead>
                    <?php while($notification = $notifications->fetch_assoc()){ ?>
                    <tr>
                    <td><?php echo $notification['time']; ?></td>
                        <td><?php echo $notification['notification']; ?></td>
                        <td><a href="javascript:open_modal('updates','edit',<?php echo $notification['id']; ?>, {notification:'<?php echo $notification['notification']; ?>'})">Edit</a></td>
                        <td><a href="javascript:delete_notification(<?php  echo $notification['id'];  ?>)">Delete</a></td>
                    </tr>
                    <?php }?>
                </table>
                <div>
                    <button onclick="open_modal('updates','new',1)" class="btn btn-primary">Add new</button>
                 </div>
            </div>
        </div>

      </div>
      <div id="Evens/Activites" class="tabcontent">
        <div class="panel panel-success">
            <div class="panel-heading">Event/Activity</div>
            <div class="panel-body">

                <table>
                    <thead>
                            <td>Event/Activity</td>
                            <td>From</td>
                            <td>To</td>
                            <td>Edit</td>
                            <td>Delete</td>
                        
                    </thead>
                    <?php while($event = $events->fetch_assoc()){ ?>
                    <tr>
                        <td><?php echo $event['event']; ?></td>
                        <td><?php echo $event['from_date']; ?></td>
                        <td><?php echo $event['to_date']; ?></td>
                        <td><a href="javascript:open_modal('events','edit',<?php echo $event['id']; ?>,{ event : '<?php echo $event['event']?>', from_date: '<?php echo $event['from_date']?>', to_date: '<?php echo $event['to_date']?>'})">Edit</a></td>
                        <td><a href="javascript:delete_event(<?php  echo $event['id'];  ?>)">Delete</a></td>
                    </tr>
                    <?php }?>
                </table>
                <button  onclick="open_modal('events','new',1)" class="btn btn-primary">Add new</button>
            </div>
        </div>
      </div>

      <div id="rooms" class="tabcontent">
        <div class="panel panel-success">
            <div class="panel-heading">Rooms</div>
            <div class="panel-body" style = 'color:black'>
                    <table class='table table-hover'>
                        <thead>
                            <tr>
                                <th>Room</th>
                                <th>Numer of students</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while($room = $rooms->fetch_assoc()){ ?>
                        <tr>
                            <td><?php echo $room['id']; ?></td>
                            <td><?php echo $room['count']; ?></td>
                        </tr>
                        <?php }?>
                        </tbody>
                    </table>
                    <div>
                        <label>New Room</label>
                        <input id = 'new_room'>
                        <button onclick='add_newroom(this)'>Add</button>
                    </div>
            </div>
        </div>
      </div>
      <div id="Logout" class="tabcontent">
        <div class="panel panel-success">
            <div class="panel-heading">Logout</div>
            <div class="panel-body">
                <h3>
                    <a href="logout.php">Click here to logout</a>
                </h3>
            </div>
        </div>
      </div>
<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="which_form" name="form">
        <form id="updates" name="updates_form">
            <input type="hidden" name="type" value="new">
            <input type="hidden" name="id" >
            <textarea name='update' placeholder="Enter notification here" class="form-control"></textarea>
        </form>
        <form id="events" name="events_form">
            <input type="hidden" name="type" value="new">
            <input type="hidden" name="id" >
            <input type="text" placeholder="Event" name="event"class="form-control" >
            <input type="text" placeholder="From date" name="from"class="form-control" >
            <input type="text" placeholder="To date" name="to"class="form-control" >
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="save_changes()">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
    <script>
    function openTab(evt, cityName) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(cityName).style.display = "block";
      evt.currentTarget.className += " active";
    }
    
    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();

    function leave_approve(a, id){
        a.innerHTML = 'updaing..';
        $.post("leave_approve.php", { id : id}, function(data,status){
                a.innerHTML = "Approved";
                if (data == 'SUCCESS'){
                    alert("Approved!!");
                }
                else{
                    alert(data);
                    a.innerHTML = "Approve";
                }
        });

    }
    function open_modal(which, type, id, data){
        $("#updates").hide();
        $("#events").hide();
        $("#"+which).show();
        $("#which_form").val(which);
        $('#myModal').modal('show');
        if(which == "updates"){
            if(type=="new"){
                $(".modal-title").text("New update");
            }
            else{
                $(".modal-title").text("Edit update");
                document.updates_form.id.value = id;
                document.updates_form.type.value = type;
                document.updates_form.update.value = data.notification;
            }
        }
        else if(which == "events"){
            if(type=="new"){
                $(".modal-title").text("New Event");
            }
            else{
                $(".modal-title").text("Edit Event");
                document.events_form.id.value = id;
                document.events_form.type.value = type;
                document.events_form.from.value = data.from_date;
                document.events_form.to.value = data.to_date;
                document.events_form.event.value = data.event;
            }
        }
    }
    function update_password(){
        $.ajax({
            type: "POST",
            url: "update_password.php",
            data: $(document.update_password_form).serialize(),
            success: function(data,status,xhr) {
                alert(data);
            },
            error: function (xhr, status, error){
                alert(error);
            }
        });
    }
    function save_changes(){
        which = $("#which_form").val();
        if(which == "events"){
            $.ajax({
                type: 'POST',
                url : 'events_handler.php',
                data: $(document.events_form).serialize(),
                success: function(data,status, jqXHR)  {
                    alert(data);
                    $('#myModal').modal('hide');
                },
                error: function(jqXHR, textStatus, errorThrown)  {
                    alert(errorThrown);
                }
            });
        }
        else if (which == "updates"){

            $.ajax({
                type: 'POST',
                url : 'update_handler.php',
                data: $(document.updates_form).serialize(),
                success: function(data,status, jqXHR)  {
                    alert(data);
                    $('#myModal').modal('hide');
                },
                error: function(jqXHR, textStatus, errorThrown)  {
                    alert(errorThrown);
                }
            });
            
        }
        else{
            alert("Something is wrong!!");
        }
    }
    function delete_notification(id){
        if(confirm("Are you sure you want to delete it?")){
            $.post("delete.php", {what : 'updates', id: id}, (data,status) => {
                alert(data);
            });
        }
    }
    function delete_event(id){
        if(confirm("Are you sure you want to delete it?")){
            $.post("delete.php", {what : 'events', id: id}, (data,status) => {
                alert(data);
            });
        }
    }
    function update_user_details(e){
        $.ajax({
            type: "POST",
            url: "update_user_details.php",
            data: $(document.user_details_form).serialize(),
            success: function(data,status,xhr) {
                alert(data);
            },
            error: function (xhr, status, error){
                alert(error);
            }
        });
        return false;
    }
    function add_newroom(a){
        var data  = $('#new_room').val();
        a.innerHTML = 'Adding.....';
        $.ajax({
            type: "POST",
            url: "new_room_add.php",
            data: { room : data},
            success: function(data,status,xhr) {
                alert(data);
            },
            error: function (xhr, status, error){
                alert(error);
            }
        });
    }
    </script>
       
</body>
</html>

<style>
        * {box-sizing: border-box}
        body {font-family: "Lato", sans-serif;}
        
        /* Style the tab */
        .tab {
        float: left;
        border: 1px solid white;
        background-color: rgba(245, 241, 241, 0.822);
        width: 30%;
        height: 300px;
        }
        
        /* Style the buttons inside the tab */
        .tab button {
        display: block;
        background-color: inherit;
        color: black;
        padding: 22px 16px;
        width: 100%;
        border: none;
        outline: none;
        text-align: left;
        cursor: pointer;
        transition: 0.3s;
        font-size: 17px;
        }
        
        /* Change background color of buttons on hover */
        .tab button:hover {
        background-color: #ccc;
        color: yellow;
        }
        
        /* Create an active/current "tab button" class */
        .tab button.active {
        background-color: black;
        color: yellow;
        }
        
        /* Style the tab content */
        .tabcontent {
        float: left;
        padding: 0px 12px;
        border: 1px solid white;
        width: 70%;
        border-left: none;
        text-align: center;
    
        }
        .panel > .panel-heading {
            background-color: black;
            color: yellow;
            font-size: large;
            height: 70px;
        }
        .panel > .panel-body{
            background-color: white;
            color: yellow;
            font-size: large;
            height: 340px;
        }
        form div{

            color: black;
            padding: 15px;
        }
        table{
            color: black;
        }
        table thead td{
            color: red;
        }
        table td{
            width: 10%;
            padding: 10px;
        }
        </style>