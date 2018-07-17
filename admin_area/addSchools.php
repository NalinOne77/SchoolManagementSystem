
<?php include('../classes/School.php') ?>

<!--Get form data and send them to the database by calling method in a School class-->
<?php
$school = new School();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $addSchool = $school->addSchool($_POST, $_FILES);
}
?>

<!--Get school_id and Delete that record using Method in a School class-->
<?php
if(isset($_GET['delschool'])){
    $id = $_GET['delschool'];
    $delSchool = $school->delSchool($id);
}
?>

<!--Include header and Nav bar from a another file-->

<?php include('inc/header.php') ?>
<?php include('inc/navbar.php') ?>

<section id="users" class="">
    <div class="container">
        <div class="row">

            <!--Start Sidebar-->

            <div class="col col-md-3 col-lg-3 text-center">
                <div class="card">
                            <div class="card-body">
                        <img src="<?php echo Session::get('photo') ?>" alt="" class="img-fluid rounded-circle w-50 mb-1">
                        <h4><?php echo Session::get('adminName') ?></h4>
                        <h5 class="text-muted"><?php echo Session::get('role') ?></h5>
                        <div class="list-group">
                            <a href="index.php" class="list-group-item list-group-item-action">Home</a>
                            <a href="addRoles.php" class="list-group-item list-group-item-action">Add User Roles</a>
                            <a href="addSchools.php" class="list-group-item list-group-item-action active">Add
                                Schools</a>
                            <a href="signup_request.php" class="list-group-item list-group-item-action">Signup requests</a>

                        </div>
                    </div>
                </div>
            </div>

            <!--End Sidebar-->

            <!--Start Main Section-->

            <div class="col col-md-9 col-lg-9 dashboard">

                <!--Add a new School to  the system-->

                <div class="card">
                    <div class="card-body">
                        <div class="card-title h5">Add a School</div>
                        <form action="addSchools.php" method="post" enctype="multipart/form-data">
                            <div class="form-row">

                                <div class="form-group col-md-6">
                                    <label for="schoolname">Enter school name</label>
                                    <input type="text" class="form-control" name="sclname" placeholder="School Name"/>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="city">Enter City</label>
                                    <input type="text" class="form-control" name="city" placeholder="City"/>
                                </div>

                            </div>

                            <div class="form-row">

                                <div class="form-group col-md-3">
                                    <label for="role">School type</label><br/>
                                    <select class="form-control" name="type">
                                        <option value="Mixed School">Mixed School</option>
                                        <option value="Boys School">Boys School</option>
                                        <option value="Girls School">Girls School</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="numofstudents">Number of students</label>
                                    <input type="number" name="numofstudents" class="form-control"
                                           placeholder="Students"/>
                                </div>

                            </div>
                            <div class="form-row">

                                <div class="form-group col-md-7">
                                    <label for="city">Address</label>
                                    <textarea class="form-control" name="address" rows="2"></textarea>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="logo">Upload school logo</label>
                                    <input type="file" class="form-control-file" name="image"/>
                                </div>

                            </div>
                            <input type="submit" name="submit" class="btn btn-success" value="Add">
                            <?php if (isset($addSchool)) {
                                echo $addSchool;
                            } ?>
                        </form>
                    </div>
                </div>
                <br/>

                <!--Display Schools in a table-->

                <div class="card">
                    <div class="card-body">
                        <div class="card-title h5">Current Schools</div>
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Type</th>
                                <th scope="col">Students</th>
                                <th scope="col">City</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $scl = $school->getSchools();
                                if($scl){
                                    $i=0;
                                    while($result=$scl->fetch_assoc()){
                                        $i++;
                            ?>
                            <tr>
                                <th scope="row"><?php echo $i;?></th>
                                <td><?php echo $result['sclname'];?></td>
                                <td><?php echo $result['school_type'];?></td>
                                <td><?php echo $result['numofstudents'];?></td>
                                <td><?php echo $result['city'];?></td>
                                <td><a onclick="return confirm('Are you sure to delete')" href="?delschool=<?php echo $result['school_id'];?>" class="btn btn-danger btn-sm">Remove</a></td>
                            </tr>
                           <?php }}?>
                            </tbody>
                        </table>
                        <?php if (isset($delSchool)) {
                            echo $delSchool;
                        } ?>
                    </div>
                </div>

            </div>
            <!--End Main Section-->

        </div>
    </div>
</section>

<!--Footer Section-->
<?php include('../inc/footer.php') ?>
