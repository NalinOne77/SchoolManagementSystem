<?php
/**
 * Created by PhpStorm.
 * User: nalin
 * Date: 7/10/2018
 * Time: 4:17 PM
 */
include('inc/header.php');

?>
<?php
$uid = Session::get('uid');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $Notification_response = $notification->sendNotification($_POST,$uid);
}
?>
<?php
if(isset($_GET['notid'])){
    $notid = $_GET['notid'];
    $delNotifications = $notification->delNotification($notid);
}
?>
<?php
$teacher = Session::get('role');
if(strcmp($teacher,"Teacher")!=0){
    header("Location:404.php");
}
?>

<body>
<?php include('inc/navbar.php')?>

<section id="authors" class="">
    <div class="container">
        <div class="row">
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
        </div>
    </div>
</section>
<?php include('inc/footer.php')?>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>