<?php
/**
 * Created by PhpStorm.
 * User: nalin
 * Date: 7/12/2018
 * Time: 10:07 AM
 */
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
?>

<?php

class User
{
    private $db;
    private $fm;
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function addUser($data){
        $school =  mysqli_real_escape_string($this->db->link,$data['school']);
        $role=  mysqli_real_escape_string($this->db->link,$data['role']);
        $fullname =  mysqli_real_escape_string($this->db->link,$data['fullname']);
        $dob =  mysqli_real_escape_string($this->db->link,$data['dob']);
        $nic =  mysqli_real_escape_string($this->db->link,$data['nic']);
        $address =  mysqli_real_escape_string($this->db->link,$data['address']);
        $email =  mysqli_real_escape_string($this->db->link,$data['email']);
        $password =  mysqli_real_escape_string($this->db->link,md5($data['password']));
        $cpassword =  mysqli_real_escape_string($this->db->link,md5($data['cpassword']));
        $status=null;

        if($school=="" || $role=="" || $fullname=="" || $dob=="" || $nic=="" || $address=="" || $email=="" || $password=="" || $cpassword==""){
            $msg = "<span class='alert alert-warning'>Field cannot be Empty!</span>";
            return $msg;
        }


        $getmail = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $res = $this->db->select($getmail);

        $getUserType = "SELECT * FROM user_types WHERE user_type_id = '$role'";
        $usertype=$this->db->select($getUserType);
        $data = $usertype->fetch_assoc();

        if(strcmp($data['userType'],"Student")==0 || strcmp($data['userType'],"Prefect")==0 ){
            $status = 1;
        }else{
            $status = 0;
        }

        if(strcmp($password,$cpassword)!=0){
            $msg = "<span class='alert alert-danger'>Passwords is does not match!</span>";
            return $msg;
        }else if($res!=false){
            $msg = "<span class='alert alert-danger'>Email already exists!</span>";
            return $msg;
        }else{
            $query = "INSERT INTO users(name,user_type,address,password,school,status,email,dob,nic)
                      VALUES(
                          '$fullname',
                          '$role',
                          '$address',
                          '$password',
                          '$school',
                          '$status',
                          '$email',
                          '$dob',
                          '$nic'
                      )";
            $result = $this->db->insert($query);
            if($result){
                $msg = "<span class='alert alert-success msg'>Registered Successfully!</span>";
                return $msg;
            }else{
                $msg = "<span class='alert alert-danger msg'>Cannot Register!</span>";
                return $msg;
            }
        }
    }
    public function logUser($data){
        $email=  mysqli_real_escape_string($this->db->link,$data['email']);
        $password=  mysqli_real_escape_string($this->db->link,md5($data['password']));

        $query = "SELECT user_id,name,users.status,photo,user_types.userType,email,users.address,schools.sclname,schools.school_id
          FROM users
          INNER JOIN schools ON users.school=schools.school_id
          INNER JOIN user_types ON users.user_type=user_types.user_type_id
          WHERE email='$email' AND password='$password'";

        $res = $this->db->select($query);

        if(empty($email) || empty($password)){
            $msg = "<span class='alert alert-warning'>Field cannot be Empty!</span>";
            return $msg;
        }else if($res==true){
            $data = $res->fetch_assoc();

            if($data['status']==0){
                $msg = "<span class='alert alert-warning'>Your account is not activated!</span>";
                return $msg;
            }else{
                Session::set("userLogin",true);
                Session::set("name",$data['name']);
                Session::set("uid",$data['user_id']);
                Session::set("photo",$data['photo']);
                Session::set("email",$data['email']);
                Session::set("school",$data['sclname']);
                Session::set("schoolid",$data['school_id']);
                Session::set("role",$data['userType']);
                header("Location:index.php");
            }

        }else{
            $msg = "<span class='alert alert-danger'>Invalid Credentials!</span>";
            return $msg;
        }

    }

    public function getDeactivateUsers(){
        $query = "SELECT user_id,name,users.registered_date,users.status,photo,user_types.userType,email,users.address,schools.sclname
          FROM users
          INNER JOIN schools ON users.school=schools.school_id
          INNER JOIN user_types ON users.user_type=user_types.user_type_id WHERE status=0 ORDER BY user_id DESC";

        $result = $this->db->select($query);
        return $result;
    }

    public function activateAccount($uid){
        $query = "UPDATE users SET status=1 WHERE user_id='$uid'";
        $result=$this->db->update($query);
        if($result){
            $msg = "<span class='alert alert-success'>Activated!</span>";
            return $msg;
        }else{
            $msg = "<span class='alert alert-danger'>Cannot Activated!</span>";
            return $msg;
        }
    }

    public function deleteUsers($uid){
        $query = "DELETE FROM users WHERE user_id='$uid'";
        $result =$this->db->delete($query);
        if($result){
            $msg = "<span class='alert alert-warning'>Rejected!</span>";
            return $msg;
        }else{
            $msg = "<span class='alert alert-success'>Cannot Reject!</span>";
            return $msg;
        }
    }

    public function getStudents($school_id,$start_from,$num_of_pages){

        $query = "SELECT user_id,name,users.registered_date,user_types.userType,email,users.address,schools.school_id
          FROM users
          INNER JOIN schools ON users.school=schools.school_id
          INNER JOIN user_types ON users.user_type=user_types.user_type_id 
          WHERE school_id='$school_id' AND userType IN ('Student','Prefect') 
          ORDER BY user_id DESC limit $start_from,$num_of_pages";

        $result = $this->db->select($query);
        return $result;
    }

}
?>