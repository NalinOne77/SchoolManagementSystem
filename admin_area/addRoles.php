<?php include('../classes/Role.php')?>

<!--Get form data and send them to the database by calling Role class method-->
<?php
$role = new Role();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $roleName = $_POST['roleName'];

    $Role_response = $role->addRole($roleName);
}
?>

<!--Get user_type_id and Delete that record using Method in Role class-->
<?php
    if(isset($_GET['delrole'])){
        $id = $_GET['delrole'];
        $delRole = $role->deleteRole($id);
    }
?>
    <!--Include header and Nav bar from a another file-->

<?php include('inc/header.php')?>
<?php include('inc/navbar.php')?>

<section id="users">
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
                            <a href="addRoles.php" class="list-group-item list-group-item-action active">Add User Roles</a>
                            <a href="addSchools.php" class="list-group-item list-group-item-action">Add Schools</a>
                            <a href="signup_request.php" class="list-group-item list-group-item-action">Signup requests</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Sidebar-->

            <!--Start Main Section-->
            <div class="col col-md-9 col-lg-9 dashboard">

                <!--Add a user role to the System-->

                <div class="card">
                    <div class="card-body">
                        <div class="card-title h5">Add a Role</div>
                        <form action="addRoles.php" method="post">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="role">Enter Role Name</label>
                                    <input type="text" class="form-control" name="roleName" placeholder="Role Name" >
                                </div>
                            </div>
                            <input type="submit" href="#" class="btn btn-success" value="Add">&nbsp;
                            <?php if(isset($Role_response)){echo $Role_response;}?>
                        </form>
                    </div>
                </div>

                <br/>

                <!--Display User roles in a table-->

                <div class="card">
                    <div class="card-body">
                        <div class="card-title h5">Current Roles</div>
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Role Name</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!--Get user roles from the database and display them in a table-->
                            <?php
                                $roles = $role->getRoles();
                                if($roles){
                                    $i=0;
                                    while ($result = $roles->fetch_assoc()){
                                        $i++;
                            ?>
                            <tr>
                                <th scope="row"><?php echo $i?></th>
                                <td><?php echo $result['userType']?></td>
                                <td><a onclick="return confirm('Are you sure to delete?')" href="?delrole=<?php echo $result['user_type_id']?>" class="btn btn-danger btn-sm">Remove</a></td>
                            </tr>
                           <?php }}?>
                            </tbody>
                        </table>
                        <?php if(isset($delRole)){echo $delRole;}?>
                    </div>
                </div>
            </div>

            <!--End Main Section-->

        </div>
    </div>
</section>

<!--Footer Section-->
<?php include('../inc/footer.php')?>