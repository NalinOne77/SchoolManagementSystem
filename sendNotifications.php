<!--Include header from another file-->
<?php include('inc/header.php'); ?>

<!--Get notice details from the form and send them to the database using method in Notification class-->
<?php
$uid = Session::get('uid');
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $Notification_response = $notification->sendNotification($_POST,$uid);
    }
?>

<!--Delete notification by using notification_id-->
<?php
    if(isset($_GET['notid'])){
        $notid = $_GET['notid'];
        $delNotifications = $notification->delNotification($notid);
    }
?>

<!--Redirect page if wrong user try to access this page-->
<?php
$teacher = Session::get('role');
if(strcmp($teacher,"Teacher")!=0){
    header("Location:404.php");
}
?>

<!--Include navbar from another file-->
<?php include('inc/navbar.php')?>

<section id="authors" class="">
    <div class="container">
        <div class="row">

            <!--Start sidebar section-->
            <div class="col col-md-3 col-lg-3 text-center">
                <div class="card">
                    <div class="card-body">
                        <img src="<?php echo Session::get('photo');?>" alt="" class="img-fluid rounded-circle w-50 mb-1">
                        <h4><?php echo Session::get('name');?></h4>
                        <h5 class="text-muted"><?php echo Session::get('role')?></h5>
                        <div class="list-group">
                            <a href="index.php" class="list-group-item list-group-item-action">Home</a>
                            <a href="addSubject.php" class="list-group-item list-group-item-action" style="<?php if(Session::get('role')!="Teacher"){echo "display:none";}?>">Add Subjects</a>
                            <a href="addStudent.php" class="list-group-item list-group-item-action" style="<?php if(Session::get('role')!="Teacher"){echo "display:none";}?>">Add User</a>
                            <a href="sendNotifications.php" class="list-group-item list-group-item-action active" style="<?php if(Session::get('role')!="Teacher"){echo "display:none";}?>">Send Notices</a>
                            <a href="addLog.php" class="list-group-item list-group-item-action" style="<?php if(Session::get('role')!="Coordinator"){echo "display:none";}?>">Add Logs</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--End sidebar section-->

            <!--Start main section-->
            <div class="col col-md-9 col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Add Notice</div>

                        <form action="sendNotifications.php" method="post">

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="to">To</label>
                                    <select class="form-control" name="to">
                                        <option>Select a role</option>
                                        <?php
                                        $roles = $role->getStudents();
                                        if($roles){
                                            while($result=$roles->fetch_assoc()){

                                                ?>
                                                <option value="<?php echo $result['user_type_id']?>"><?php echo $result['userType']?></option>
                                            <?php }}?>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" name="title" placeholder="Title">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="role">Message</label><br/>
                                <textarea class="form-control" name="message"></textarea>
                            </div>

                            <input type="submit" class="btn btn-info" value="Send">
                            <?php if(isset($Notification_response)){echo $Notification_response;}?>
                        </form>

                    </div>
                </div>
                <br/>
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">My Notices</div>
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Date</th>
                                <th scope="col">To</th>
                                <th scope="col">Title</th>
                                <th scope="col">message</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!--Display Notification in a Table-->
                            <?php
                            $notifications = $notification->getTeacherNotifications($uid);
                            if($notifications){
                                $i=0;
                                while($result=$notifications->fetch_assoc()){
                                    $i++;
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $i;?></th>
                                        <td><?php echo $result['sent_date'];?></td>
                                        <td><?php echo $result['userType'];?></td>
                                        <td><?php echo $result['title'];?></td>
                                        <td><?php echo $result['message'];?></td>
                                        <td><a onclick="return confirm('Are sure to delete?')" href="?notid=<?php echo $result['n_id'];?>" class="btn btn-danger btn-sm">Remove</a></td>
                                    </tr>
                                <?php }}?>
                            </tbody>
                        </table>
                        <?php if(isset($delNotifications)){echo $delNotifications;}?>
                    </div>

                </div>
            </div>
            <!--End main section-->

        </div>
    </div>
</section>

<!--Footer section-->
<?php include('inc/footer.php')?>
