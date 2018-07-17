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
    $Subject_response = $subject->addLog($_POST,$uid);
}
?>
<?php
if(isset($_GET['subid'])){
    $sid = $_GET['subid'];
    $delSubject = $subject->delSubject($sid);
}
?>
<?php
$coordinator= Session::get('role');
if(strcmp($coordinator,"Coordinator")!=0){
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
                            <a href="sendNotifications.php" class="list-group-item list-group-item-action" style="<?php if(Session::get('role')!="Teacher"){echo "display:none";}?>">Send Notices</a>
                            <a href="addLog.php" class="list-group-item list-group-item-action active" style="<?php if(Session::get('role')!="Coordinator"){echo "display:none";}?>">Add Logs</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-md-9 col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Add a Log</div>
                        <form action="addSubject.php" method="post">
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
                                        <select class="form-control" name="name" id="name">
                                            <option>Select name</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <dic id="result"></dic>


                            <br/>
                            <input type="submit" class="btn btn-info" value="Add">
                            <?php if(isset($Subject_response)){echo $Subject_response;}?>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include('inc/footer.php')?>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
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
</body>
</html>