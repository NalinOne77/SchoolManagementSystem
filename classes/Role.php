<?php
/**
 * Created by PhpStorm.
 * User: nalin
 * Date: 7/11/2018
 * Time: 4:34 PM
 */
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php')
?>

<?php
class Role
{
    private $db;
    private $fm;
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }
    /*This method add new user role to the system*/
    public function addRole($roleName){
        $roleName = $this->fm->validation($roleName);
        $roleName = mysqli_real_escape_string($this->db->link,$roleName);
        $getQuery = "SELECT COUNT(userType) FROM user_types WHERE userType = '$roleName'";
        $count = $this->db->select($getQuery);

        if(empty($roleName)){
            $msg = "<span class='alert alert-warning'>Field cannot be Empty!</span>";
            return $msg;
        }else if($count->num_rows>1){
            $msg = "<span class='alert alert-warning'>Name Already Exists!</span>";
            return $msg;
        }else{
            $query = "INSERT IGNORE INTO user_types(userType) VALUES('$roleName')";
            $insertRole = $this->db->insert($query);
            if($insertRole){
                $msg = "<span class='alert alert-success'>Added Successfully!</span>";
                return $msg;
            }else{
                $msg = "<span class='alert alert-danger'>Cannot insert!</span>";
                return $msg;
            }

        }
    }
    /*This method get all user Roles by descending order*/
    public function getRoles(){
        $query="SELECT * FROM user_types ORDER BY user_type_id DESC";
        $result = $this->db->select($query);
        return $result;
    }

    /*This method delete user roles by using user_type_id*/
    public function deleteRole($id){
        $query = "DELETE FROM user_types WHERE user_type_id='$id'";
        $result = $this->db->delete($query);
        if($result){
            $msg = "<span class='alert alert-success'>Deleted Successfully!</span>";
            return $msg;
        }else{
            $msg = "<span class='alert alert-danger'>Cannot Delete!</span>";
            return $msg;
        }
    }

    /*This method return only students and prefects*/
    public function getStudents(){
        $query = "SELECT * FROM user_types WHERE userType IN('Student','Prefect')";
        $result = $this->db->select($query);
        return $result;
    }
}?>