<!--Include header from another file-->
<?php include('inc/header.php'); ?>

<!--Get log details from the form and add log record to the database-->
<?php
$uid = Session::get('uid');
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $log_response = $log->addLog($_POST,$uid);
    }
?>

<!--Delete particular log record using log_id-->
<?php
if(isset($_GET['logid'])){
    $logid = $_GET['logid'];
    $dellog = $log->delLog($logid);
}
?>

<!--Redirect page if wrong user try to access this page-->
<?php
$coordinator= Session::get('role');
    if(strcmp($coordinator,"Coordinator")!=0){
        header("Location:404.php");
    }
?>

<!--Include navbar from another file-->
<?php include('inc/navbar.php')?>

<section id="authors">
    <div class="container">
        <div class="row">

            <!--Start Sidebar Section-->
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
                            <a href="sendNotifications.php" class="list-group-item list-group-item-action" style="<?php if(Session::get('role')!="Teacher"){echo "display:none";}?>">Send Notices</a>
                            <a href="addLog.php" class="list-group-item list-group-item-action active" style="<?php if(Session::get('role')!="Coordinator"){echo "display:none";}?>">Add Logs</a>
                            <a href="logHistory.php" class="list-group-item list-group-item-action" style="<?php if(Session::get('role')!="Coordinator"){echo "display:none";}?>">Log history</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--End sidebar section-->

            <!--Start main section-->
            <div class="col col-md-9 col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Add a Log</div>

                        <form action="addlog.php" method="post">

                            <div class="form-row">
                                <div class="input-group col-md-8">
                                    <span class="input-group-addon"><i class="fa fa-graduation-cap"></i></span>
                                    <select class="form-control" name="school" id="school">
                                        <option value="">Select school</option>
                                        <?php
                                        $schools = $school->getSchools();
                                        if($schools){
                                            while($result=$schools->fetch_assoc()){
                                                ?>
                                                <option value="<?php echo $result['school_id'];?>"><?php echo $result['sclname'];?></option>
                                            <?php }}?>
                                    </select>
                                </div>

                                <div class="input-group col-md-4">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <select class="form-control" name="role" id="role">
                                        <option value="">Select role</option>
                                        <?php
                                        $roles = $role->getRoles();
                                        if($roles){
                                            while($result=$roles->fetch_assoc()){
                                                ?>
                                                <option value="<?php echo $result['user_type_id'];?>"><?php echo $result['userType'];?></option>
                                            <?php }}?>
                                    </select>
                                </div>
                            </div>

                            <br/>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="input-group ">
                                        <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                        <select class="form-control" name="rname" id="name">
                                            <option>Select name</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <div class="input-group ">
                                        <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                        <select class="form-control" name="action" id="action">
                                            <option>Select Action</option>
                                            <option value="Call">Call</option>
                                            <option value="email">Email</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group ">
                                    <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                    <textarea class="form-control" name="comment" rows="3" id="action" placeholder="Comment"></textarea>
                                </div>
                            </div>

                            <br/>
                            <button type="submit" class="btn btn-info"> Add</button>
                            <?php if(isset($log_response)){echo $log_response;}?>
                        </form>

                    </div>
                </div>

                <br/>

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Recent Logs</div>
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Date</th>
                                <th scope="col">School</th>
                                <th scope="col">Role</th>
                                <th scope="col">Name</th>
                                <th scope="col">Action</th>
                                <th scope="col">Comment</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!--Display Logs in a Table-->
                            <?php
                            $uid = Session::get('uid');
                            $logs = $log->getRecentLogs($uid);
                            if($logs){
                                $i=0;
                                while($result=$logs->fetch_assoc()){
                                    $i++;
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $i;?></th>
                                        <td><?php echo $result['time'];?></td>
                                        <td><?php echo $result['sclname'];?></td>
                                        <td><?php echo $result['userType'];?></td>
                                        <td><?php echo $result['name'];?></td>
                                        <td><?php echo $result['action'];?></td>
                                        <td><?php echo $result['comment'];?></td>
                                        <td><a onclick="return confirm('Are sure to delete?')" href="?logid=<?php echo $result['log_id'];?>" class="btn btn-danger btn-sm">Remove</a></td>
                                    </tr>
                                <?php }}?>
                            </tbody>
                        </table>
                        <?php if(isset($dellog)){echo $dellog;}?>
                    </div>

                </div>
            </div>
            <!--End main section-->

        </div>
    </div>
</section>

<!--Footer section-->
<?php include('inc/footer.php')?>

<!--Get school and user roles and pass them to javascript function to get name of particular user-->
<script>
    $(document).ready(function(){
        $("#role").change(function(){
            var school_id = $("#school").val();
            var role_id = $("#role").val();
            $.ajax({
                url:"search.php",
                type:"POST",
                data:{
                    role_id:+role_id,
                    school_id:+school_id
                },
                success:function(data)
                {
                    $('#name').html(data);

                }
            });
        });


    });
</script>