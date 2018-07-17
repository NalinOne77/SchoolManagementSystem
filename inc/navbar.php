<?php if(isset($_GET['uid'])){
    Session::Client_session_destroy();
}?>
<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand"><img src="img/logo.png" width="50px" height="50px" alt="" class="logo">CloudSchool</a>
        <form class="form-inline">
            <label>Welcome User &nbsp; </label>
            <a href="?uid=<?php Session::get('uid')?>" class="btn btn-outline-info my-2 my-sm-0" type="submit"> Logout</a>
        </form>
    </div>
</nav>