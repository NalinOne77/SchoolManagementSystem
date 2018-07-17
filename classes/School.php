<?php
/**
 * Created by PhpStorm.
 * User: nalin
 * Date: 7/11/2018
 * Time: 6:41 PM
 */
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
?>
<?php
class School
{
    private $db;
    private $fm;
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    /*This method add a new School to the system*/
    public function addSchool($data,$file){

        $name =  mysqli_real_escape_string($this->db->link,$data['sclname']);
        $city =  mysqli_real_escape_string($this->db->link,$data['city']);
        $type=  mysqli_real_escape_string($this->db->link,$data['type']);
        $numofstudents =  mysqli_real_escape_string($this->db->link,$data['numofstudents']);
        $address =  mysqli_real_escape_string($this->db->link,$data['address']);

        $permit = array('jpg','jpeg','png','gif');
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.',$file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()),0,10).'.'.$file_ext;
        $uploaded_image = "uploads/".$unique_image;

        $getSchools = "SELECT COUNT(sclname) from schools WHERE sclname='$name'";
        $res = $this->db->select($getSchools);

        if($name=="" || $city=="" || $type=="" || $numofstudents=="" || $address==""){
            $msg = "<span class='alert alert-warning'>Field cannot be Empty!</span>";
            return $msg;
        }else if($file_size>1048567){
            $msg = "<span class='alert alert-warning'>File is too large!</span>";
            return $msg;
        }else if(in_array($file_ext,$permit)==false){
            $msg = "<span class='alert alert-warning'>Invalid file type!</span>";
            return $msg;
        }else if($res->num_rows>1){
            $msg = "<span class='alert alert-warning'>School Already Exists!</span>";
            return $msg;
        }else{
            move_uploaded_file($file_temp,$uploaded_image);
            $insertSchool = "INSERT INTO schools(sclname,address,city,school_type,numofstudents,logo)VALUES('$name','$address','$city','$type','$numofstudents','$uploaded_image')";
            $result = $this->db->insert($insertSchool);
            if($result){
                $msg = "<span class='alert alert-success'>Successfully Added!</span>";
                return $msg;
            }else{
                $msg = "<span class='alert alert-danger'>Cannot insert!</span>";
                return $msg;
            }
        }
    }

    /*This method return all schools*/
    public function getSchools(){
        $query = "SELECT * from schools ORDER BY school_id DESC ";
        $result = $this->db->select($query);
        return $result;
    }

    /*This method return Delete schools by using school_id*/
    public function delSchool($id){
        $getquery = "SELECT * FROM schools WHERE school_id= '$id'";
        $getdata = $this->db->delete($getquery);
        if($getdata){
            while($delimg = $getdata->fetch_assoc()){
                $dellink = $delimg['logo'];
                unlink($dellink);
            }
        }
        $query="DELETE FROM schools WHERE school_id='$id'";
        $result = $this->db->delete($query);
        if($result){
            $msg = "<span class='alert alert-success'>Successfully deleted!</span>";
            return $msg;
        }else{
            $msg = "<span class='alert alert-danger'>Cannot Delete!</span>";
            return $msg;
        }
    }

}
?>