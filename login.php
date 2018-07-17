<!--Include header from another file-->
<?php include('inc/header.php'); ?>

<!--Get the user login details and send to the database for check user details-->
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $logUser = $user->logUser($_POST);
    }
?>

<!--Check user login.If session found redirect the user to Main page-->
<?php
$login = Session::get('userLogin');
    if($login==true){
            header("Location:index.php");

}
?>

<!-- Start Inline Stylesheet-->
<style>
    body{
        margin-top:50px;
    }
    .login{
        margin-top:140px;
    }
    .loginbtn{
        width:50%;
    }
    .blockquote-footer{
       color:#f5f5f5;
    }
</style>
<!-- End Inline Stylesheet-->

<!--Start navbar-->
<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand"><img src="img/logo.png" width="50px" height="50px" alt="" class="logo">CloudSchool</a>

        <form class="form-inline">
            <label>Welcome Guest &nbsp; </label>
            <a href="register.php" class="btn btn-outline-info my-2 my-sm-0" type="submit">Register here</a>
        </form>
    </div>
</nav>
<!--End navbar-->


<section id="showcase" class="py-5">
    <div class="primary-overlay">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-white"><h1 class="display-5 pt-5 text-center">Welcome to CloudSchool</h1></div>

                <!--Start testimonial-->
                <div class="col-lg-7 text-center text-white py-5">
                    <div class="slider">
                        <div>
                            <img src="img/1.png" class="rounded mx-auto d-block" height="350" width="300"/>
                            <blockquote class="blockquote">
                                <p>
                                    “In order to create an engaging learning experience, the role of instructor is optional, but the role of learner is essential.”
                                </p>
                                <footer class="blockquote-footer">
                                    Bernard Bull
                                </footer>
                            </blockquote>
                        </div>
                        <div>
                            <img src="img/2.png" class="rounded mx-auto d-block" height="350" width="300"/>
                            <blockquote class="blockquote">
                                <p>
                                    “One of the most important areas we can develop as professionals is competence in accessing and sharing knowledge.”
                                </p>
                                <footer class="blockquote-footer">
                                    Connie Malamed
                                </footer>
                            </blockquote>
                        </div>
                        <div>
                            <img src="img/3.png" class="rounded mx-auto d-block" height="350" width="300"/>
                            <blockquote class="blockquote">
                                <p>
                                    “People often tout interactivity as the great benefit offered by eLearning, yet most interactivity does nothing to either engage or instruct.”
                                </p>
                                <footer class="blockquote-footer">
                                    Ethan Edwards
                                </footer>
                            </blockquote>
                        </div>
                    </div>
                </div>
                <!--End testimonial-->

                <!--Start login form-->
                <div class="col-lg-5 text-center py-5 pl-lg-5">
                    <div class="container">
                        <div class="row">
                                <form class="login" action="login.php" method="post">
                                    <div class="form-group">
                                        <div class="input-group ">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            <input type="text" class="form-control" name="email" placeholder="Username">
                                        </div>
                                    </div>
                                    <div class="form-group">

                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                            <input type="password" class="form-control" name="password" placeholder="Password">
                                        </div>
                                    </div>

                                    <input type="submit" name="submit" class="btn btn-info loginbtn" value="Login">
                                    <br/>
                                    <br/>
                                    <?php if(isset($logUser)){echo $logUser;}?>
                                </form>
                        </div>
                    </div>
                </div>
                <!--End login form-->

            </div>
        </div>
    </div>
</section>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/slick.js"></script>
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>
