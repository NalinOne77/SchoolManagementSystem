
<!--Nav-Bar-->

<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand"><img src="../img/logo.png" width="50px" height="50px" alt="" class="logo">CloudSchool &nbsp;<small class="text-muted">Dashboard</small></a>
        <?php
        if(isset($_GET['action']) && $_GET['action'] == "logout"){
            Session::Admin_session_destroy();
        }
        ?>
        <form class="form-inline" method="get">
            <label>Welcome <?php echo Session::get('role')?>! &nbsp; </label>
            <a class="btn btn-outline-success my-2 my-sm-0" href="?action=logout"> Logout</a>
        </form>
    </div>
</nav>