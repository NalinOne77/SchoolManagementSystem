<?php include('../classes/User.php') ?>

<!--Get request_id and activate users using Method in a User class-->
<?php
$user = new User();
if(isset($_GET['uid'])){
    $uid = $_GET['uid'];
    $activateUser = $user->activateAccount($uid);
}
?>

<!--Get request_id and Delete that record using Method in a User class-->
<?php
if(isset($_GET['ruid'])){
    $uid = $_GET['ruid'];
    $rejectUser = $user->deleteUsers($uid);
}
?>

<!--Include header and Nav bar from a another file-->
<?php include('inc/header.php')?>
<?php include('inc/navbar.php')?>

<section id="users" class="">
    <div class="container">
        <div class="row">

            <!--Start Sidebar-->

            <div class="col col-md-3 col-lg-3 text-center">
                <div class="card">
                    <div class="card-body">
                        <img src="<?php echo Session::get('photo')?>" alt="" class="img-fluid rounded-circle w-50 mb-1">
                        <h4><?php echo Session::get('adminName')?></h4>
                        <h5 class="text-muted"><?php echo Session::get('role')?></h5>
                        <div class="list-group">
                            <a href="index.php" class="list-group-item list-group-item-action">Home</a>
                            <a href="addRoles.php" class="list-group-item list-group-item-action">Add User Roles</a>
                            <a href="addSchools.php" class="list-group-item list-group-item-action">Add Schools</a>
                            <a href="signup_request.php" class="list-group-item list-group-item-action  active">Signup requests</a>
                        </div>
                    </div>
                </div>
            </div>

            <!--End Sidebar-->

            <!--Start Main Section-->
            <div class="col col-md-9 col-lg-9 dashboard">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title h5">Requests</div>
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">User</th>
                                <th scope="col">Role</th>
                                <th scope="col">School</th>
                                <th scope="col">Joined Date</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                           <!-- Get Deactivates users from the system and activate or delete them-->
                            <?php
                                $users = $user->getDeactivateUsers();
                                if($users){
                                    $i=0;
                                    while($result=$users->fetch_assoc()){
                                        $i++;
                            ?>
                            <tr>
                                <th scope="row"><?php echo $i;?></th>
                                <td><?php echo $result['name'];?></td>
                                <td><?php echo $result['userType'];?></td>
                                <td><?php echo $result['sclname'];?></td>
                                <td><?php echo $result['registered_date'];?></td>
                                <td><a href="?uid=<?php echo $result['user_id'];?>" class="btn btn-success btn-sm">Accept</a>  <a onclick="return confirm('Are you sure to Delete?')" href="?ruid=<?php echo $result['user_id'];?>" class="btn btn-danger btn-sm">Reject</a></td>
                            </tr>
                            <?php }}?>
                            </tbody>
                        </table>
                        <?php if(isset($activateUser)){echo $activateUser;}?>
                        <?php if(isset($rejectUser)){echo $rejectUser;}?>
                    </div>
                </div>
            </div>

            <!--End Main Section-->

        </div>
    </div>
</section>

<!--Footer Section-->
<?php include('../inc/footer.php')?>
