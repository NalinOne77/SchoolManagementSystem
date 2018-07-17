<?php
/**
 * Created by PhpStorm.
 * User: nalin
 * Date: 7/12/2018
 * Time: 6:32 PM
 */
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
?>

<?php
class Subject
{
    private $db;
    private $fm;
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    /*This method add new subject to the system*/
    public function addSubject($data,$uid){
        $subjectName = mysqli_real_escape_string($this->db->link,$data['subjectName']);
        $learningHours = mysqli_real_escape_string($this->db->link,$data['learningHours']);

        if(empty($subjectName) || empty($learningHours)){
            $msg = "<span class='alert alert-danger'>Fields cannot be empty!</span>";
            return $msg;
        }else{
            $query = "INSERT INTO subjects(subjectName,teacher,learningHours) VALUES('$subjectName','$uid','$learningHours') ";
            $result = $this->db->insert($query);

            if($result){
                $msg = "<span class='alert alert-success'>Successfully Inserted!</span>";
                return $msg;
            }else{
                $msg = "<span class='alert alert-danger'>Cannot insert!</span>";
                return $msg;
            }

        }

    }

    /*This method return all subjects belongs to a particular teacher*/
    public function getAllSubjects($uid,$start_from,$num_of_pages){
        $query = "SELECT * FROM subjects WHERE teacher='$uid' ORDER BY subjects_id DESC LIMIT $start_from,$num_of_pages";
        $result = $this->db->select($query);
        return $result;
    }

    /*This method delete subject using subject_id*/
    public function delSubject($sid){
        $query = "DELETE FROM subjects WHERE subjects_id='$sid'";
        $result = $this->db->delete($query);
        if($result){
            $msg = "<span class='alert alert-success'>Successfully Deleted!</span>";
            return $msg;
        }else{
            $msg = "<span class='alert alert-danger'>Cannot Delete!</span>";
            return $msg;
        }
    }
}