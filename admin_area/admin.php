
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
                            <a href="index.php" class="list-group-item list-group-item-action active">Home</a>
                            <a href="addRoles.php" class="list-group-item list-group-item-action">Add User Roles</a>
                            <a href="addSchools.php" class="list-group-item list-group-item-action">Add Schools</a>
                            <a href="signup_request.php" class="list-group-item list-group-item-action">Signup requests</a>

                        </div>
                    </div>
                </div

             <!--End Slidebar-->

            <div class="col col-md-9 col-lg-9 dashboard">
             <div class="jumbotron jumbotron-fluid text-center welcome">
                 <div class="container">
                    <h1 class="display-4">Welcome to Admin area</h1>
                 </div>
              </div>

                <br/>
                    <!--Display Schools count-->
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="card schools">
                            <div class="card-body">
                                <i class="fa fa-building fa-3x"></i>
                                <h3 class="text-uppercase">Schools</h3>
                                <h1>34</h1>
                            </div>
                        </div>
                    </div>

                    <!--Display Student count-->
                    <div class="col-md-4 text-center">
                        <div class="card students">
                            <div class="card-body">
                                <i class="fa fa-user fa-3x"></i>
                                <h3 class="text-uppercase">Students</h3>
                                <h1>34</h1>
                            </div>
                        </div>
                    </div>

                    <!--Display Prefects Count-->
                    <div class="col-md-4 text-center">
                        <div class="card prefects">
                            <div class="card-body">
                                <i class="fa fa-chalkboard-teacher fa-3x"></i>
                                <h3 class="text-uppercase">Prefects</h3>
                                <h1>34</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--Footer Section-->
<?php include('../inc/footer.php')?>
