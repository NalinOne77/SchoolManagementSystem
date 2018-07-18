<!--Include header from another file-->
<?php
ob_start();
include('inc/header.php'); ?>

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
                            <a href="addLog.php" class="list-group-item list-group-item-action" style="<?php if(Session::get('role')!="Coordinator"){echo "display:none";}?>">Add Logs</a>
                            <a href="logHistory.php" class="list-group-item list-group-item-action active" style="<?php if(Session::get('role')!="Coordinator"){echo "display:none";}?>">Log history</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--End sidebar section-->

            <!--Start main section-->
            <div class="col col-md-9 col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Search log</div>

                        <form action="logHistory.php" method="post">

                            <div class="form-row">
                                <div class="input-group col-md-4">
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
                                    <div class="input-group col-md-4">
                                        <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                        <select class="form-control" name="action" id="action">
                                            <option value="">Select Action</option>
                                            <option value="Call">Call</option>
                                            <option value="email">Email</option>
                                        </select>
                                    </div>
                            </div>
                            <br/>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="form-group text-center">From</label>
                                    <div class="input-group">

                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <input type="date" class="form-control" name="from">
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="form-group text-center">To</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <input type="date" class="form-control" name="to">
                                    </div>
                                </div>
                            </div>

                            <br/>
                            <button type="submit" name="search" class="btn btn-info"><i class="fa fa-search"></i> Search</button>
                            <button type="submit" name="print" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Print</button>
                        </form>

                    </div>
                </div>
            </div>
            <!--End main section-->

            <!--Display search result here-->
            <div class="col-md-12 col-lg-12 mt-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">All Logs</div>
                        <table class="table">
                            <thead class="thead-inverse">
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
                            <!--Display returned results in a Table-->
                            <?php $uid = Session::get('uid');
                            if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])){
                                $search_response = $log->Search($_POST,$uid);

                            if($search_response){
                                $i=0;
                                while($result=$search_response->fetch_assoc()){
                                    $i++;?>
                                    <tr>
                                        <th scope="row"><?php echo $i;?></th>
                                        <td><?php echo $result['time'];?></td>
                                        <td><?php echo $result['sclname'];?></td>
                                        <td><?php echo $result['userType'];?></td>
                                        <td><?php echo $result['name'];?></td>
                                        <td><?php echo $result['action'];?></td>
                                        <td><?php echo $result['comment'];?></td>
                                    </tr>
                                    <!--Print logs into PDF-->
                                <?php }}}else if(isset($_POST['print'])){?>
                                <?php $logs = $log->Search($_POST,$uid);
                            if($logs) {
                                $i = 0;
                                $data = '';
                                while ($result = $logs->fetch_assoc()) {
                                    $i++;
                                    $data .= '<tr>
                                        <th scope="row">' . $i . '</th>
                                        <td>' . $result['time'] . '</td>
                                        <td>' . $result['sclname'] . '</td>
                                        <td>' . $result['userType'] . '</td>
                                        <td>' . $result['name'] . '</td>
                                        <td>' . $result['action'] . '</td>
                                        <td>' . $result['comment'] . '</td>
                                    </tr>';
                                }


                                require_once('classes/tcpdf/tcpdf.php');
                                $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                                $obj_pdf->SetCreator(PDF_CREATOR);
                                $obj_pdf->SetTitle("Log Records");
                                $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
                                $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                                $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
                                $obj_pdf->SetDefaultMonospacedFont('helvetica');
                                $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
                                $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
                                $obj_pdf->setPrintHeader(false);
                                $obj_pdf->setPrintFooter(false);
                                $obj_pdf->SetAutoPageBreak(TRUE, 10);
                                $obj_pdf->SetFont('helvetica', '', 11);
                                $obj_pdf->AddPage();
                                $content = '';
                                $content .= '  
                                              <h2>Log Records</h2> 
                                          <table border="1" cellspacing="0" cellpadding="3">  
                                               <tr>  
                                                    <th width="5%">Id</th>  
                                                    <th width="15%">Time</th> 
                                                    <th width="15%">School</th> 
                                                    <th width="10%">Role</th>  
                                                    <th width="20%">Name</th> 
                                                    <th width="10%">Action</th>  
                                                    <th width="20%">Comment</th>   
                                               </tr>  
                                          ';
                                $content .= $data;
                                $content .= '</table>';
                                $obj_pdf->writeHTML($content);
                                ob_end_clean();
                                $obj_pdf->Output($uid . microtime() . '.pdf', 'FI');

                            }}else{?>
                                <?php $logs = $log->getAllLogs($uid);
                            if($logs){
                                $i=0;
                                while($result=$logs->fetch_assoc()){
                                    $i++;?>
                                    <tr>
                                        <th scope="row"><?php echo $i;?></th>
                                        <td><?php echo $result['time'];?></td>
                                        <td><?php echo $result['sclname'];?></td>
                                        <td><?php echo $result['userType'];?></td>
                                        <td><?php echo $result['name'];?></td>
                                        <td><?php echo $result['action'];?></td>
                                        <td><?php echo $result['comment'];?></td>
                                    </tr>
                                <?php }}}?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<!--Generate PDF-->
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])){
$search_response = $log->Search($_POST,$uid);}
?>
<!--Footer section-->
<?php include('inc/footer.php')?>
