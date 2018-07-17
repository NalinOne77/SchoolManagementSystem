<!--Include header from another file-->
<?php include('inc/header.php'); ?>

<!--Get subject details from the form and send them to the database by using method in a Subject Class-->
<?php
$uid = Session::get('uid');
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $Subject_response = $subject->addSubject($_POST,$uid);
    }
?>

<!--Delete subject by using subject_id-->
<?php
    if(isset($_GET['subid'])){
        $sid = $_GET['subid'];
        $delSubject = $subject->delSubject($sid);
    }
?>

<!--Redirect page if wrong user try to access this page-->
<?php
$teacher = Session::get('role');
    if(strcmp($teacher,"Teacher")!=0){
        header("Location:404.php");
    }
?>

<!--Get page number-->
<?php
    if(isset($_GET['page']) ){
        $pg = $_GET['page'];
    }else{
        $pg=1;
    }
?>

<!--Include Navbar from another file-->
<?php include('inc/navbar.php')?>

<section id="authors" class="">
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
                            <a href="addSubject.php" class="list-group-item list-group-item-action active" style="<?php if(Session::get('role')!="Teacher"){echo "display:none";}?>">Add Subjects</a>
                            <a href="addStudent.php" class="list-group-item list-group-item-action" style="<?php if(Session::get('role')!="Teacher"){echo "display:none";}?>">Add User</a>
                            <a href="sendNotifications.php" class="list-group-item list-group-item-action" style="<?php if(Session::get('role')!="Teacher"){echo "display:none";}?>">Send Notices</a>
                            <a href="addLog.php" class="list-group-item list-group-item-action" style="<?php if(Session::get('role')!="Coordinator"){echo "display:none";}?>">Add Logs</a>
                            <a href="logHistory.php" class="list-group-item list-group-item-action" style="<?php if(Session::get('role')!="Coordinator"){echo "display:none";}?>">Log history</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Sidebar Section-->

            <!--Start main section-->
            <div class="col col-md-9 col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Add a Subject</div>

                        <form action="addSubject.php" method="post">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="subjectName">Subject Name</label>
                                    <input type="text" class="form-control" name="subjectName" placeholder="Subject Name">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="hours">Hours</label>
                                    <input type="number" class="form-control" name="learningHours" placeholder="Hours">
                                </div>
                            </div>

                            <input type="submit" class="btn btn-info" value="Add">
                            <?php if(isset($Subject_response)){echo $Subject_response;}?>
                        </form>

                    </div>
                </div>

                <br/>

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">My Subjects</div>
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Subject Name</th>
                                <th scope="col">Learning hours</th>
                                <th scope="col">actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!--Display all subjects in a table-->
                            <?php
                            $start_from = ($pg-1)*5;
                                $subjects = $subject->getAllSubjects($uid,$start_from,5);
                                if($subjects){
                                    $i=0;
                                    while($result=$subjects->fetch_assoc()){
                                        $i++;
                            ?>
                            <tr>
                                <th scope="row"><?php echo $i;?></th>
                                <td><?php echo $result['subjectName'];?></td>
                                <td><?php echo $result['learningHours'];?></td>
                                <td><a onclick="return confirm('Are sure to delete?')" href="?subid=<?php echo $result['subjects_id'];?>" class="btn btn-danger btn-sm">Remove</a></td>
                            </tr>
                            <?php }}?>
                            </tbody>
                        </table>
                        <?php if(isset($delSubject)){echo $delSubject;}?>

                        <!--Start pagination-->
                        <nav aria-label="Subject Pagination">
                            <ul class="pagination">
                                <?php
                                $pages = $page->addPagination(5,'subjects');
                                if($pages){
                                    for($i=1;$i<=$pages;$i++){
                                        echo "<li class='page-item'><a class='page-link ' href='?page=".$i."'>".$i."</a></li>";
                                    }
                                }
                                ?>
                            </ul>
                        </nav>
                        <!--End pagination-->

                    </div>

                </div>
            </div>
            <!--End main Section-->

        </div>
    </div>
</section>

<!--Footer section-->
<?php include('inc/footer.php')?>