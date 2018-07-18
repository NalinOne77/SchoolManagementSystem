<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php')
?>
<?php
class Log
{
    private $db;
    private $fm;
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    /*This method add a Log to the System*/
    public function addLog($data,$uid){

        $school =  mysqli_real_escape_string($this->db->link,$data['school']);
        $role =  mysqli_real_escape_string($this->db->link,$data['role']);
        $name =  mysqli_real_escape_string($this->db->link,$data['rname']);
        $action =  mysqli_real_escape_string($this->db->link,$data['action']);
        $comment =  mysqli_real_escape_string($this->db->link,$data['comment']);

        if(empty($school) || empty($role) || empty($name) || empty($action) || empty($comment)){
            $msg = "<span class='alert alert-danger'>Fields cannot be empty!</span>";
            return $msg;
        }else{
            $query = "INSERT INTO logs(school,action, comment, recipient,role,coordinator_id) VALUES('$school','$action','$comment','$name','$role','$uid')";
            $result = $this->db->insert($query);
            if($result){
                $msg = "<span class='alert alert-success'>Log added!</span>";
                return $msg;
            }else{
                $msg = "<span class='alert alert-danger'>Cannot add log!</span>";
                return $msg;
            }
        }

    }

    /*This method will return recent logs added by the particular coordinator*/
    public function getRecentLogs($uid){
        $query = "SELECT *
          FROM logs
          INNER JOIN schools ON logs.school=schools.school_id
          INNER JOIN user_types ON logs.role=user_types.user_type_id
          INNER JOIN users ON logs.recipient = users.user_id 
          WHERE coordinator_id='$uid' AND logs.delStatus=1
          ORDER BY log_id DESC LIMIT 10";
        $result = $this->db->select($query);
       return $result;
    }

    /*This method will return all the logs added by the particular user*/
    public function getAllLogs($uid){
        $query = "SELECT *
          FROM logs
          INNER JOIN schools ON logs.school=schools.school_id
          INNER JOIN user_types ON logs.role=user_types.user_type_id
          INNER JOIN users ON logs.recipient = users.user_id 
          WHERE coordinator_id='$uid' AND delStatus=1
          ORDER BY log_id DESC";
        $result = $this->db->select($query);
        return $result;
    }

    /*This method delete a Log using log_id*/
    public function delLog($logid){
        $query ="UPDATE logs SET delStatus=0 WHERE log_id='$logid'";
        $result = $this->db->update($query);
        if($result){
            $msg = "<span class='alert alert-success'>Deleted!</span>";
            return $msg;
        }else{
            $msg = "<span class='alert alert-danger'>Cannot delete!</span>";
            return $msg;
        }
    }

    /*This method will return search log results*/
    public function search($data,$uid){

        $school =  mysqli_real_escape_string($this->db->link,$data['school']);
        $role =  mysqli_real_escape_string($this->db->link,$data['role']);
        $action =  mysqli_real_escape_string($this->db->link,$data['action']);
        $from =  mysqli_real_escape_string($this->db->link,$data['from']);
        $to =  mysqli_real_escape_string($this->db->link,$data['to']);


        $query = "SELECT *
          FROM logs
          INNER JOIN schools ON logs.school=schools.school_id
          INNER JOIN user_types ON logs.role=user_types.user_type_id
          INNER JOIN users ON logs.recipient = users.user_id 
          WHERE coordinator_id='$uid' AND delStatus=1 ";

        if ($school != "") {
            $query .= " AND `school_id` ='$school'";
        }
        if ($role != "") {
            $query .= " AND `user_type_id` ='$role'";
        }
        if ($from!= "" || $to!="") {
            $query .= " AND `time` BETWEEN '$from' AND '$to'";
        }
        if ($action != "") {
            $query .= " AND `action` = '$action'";
        }

        $query .= " ORDER BY `log_id` DESC";

        $result = $this->db->select($query);
        if($query){
            return $result;
        }else{
            return "Result Not Found!";
        }


    }

}