
<?php
/**
 * Created by PhpStorm.
 * User: nalin
 * Date: 7/11/2018
 * Time: 11:59 AM
 */
include '../lib/Session.php';
Session::checkLogin();
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php')
?>

<?php
class Admin
{
    private $db;
    private $fm;
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

  /*  Implementation of Admin Login method*/
    public function login($adminUsername,$adminPassword){
        $username = $this->fm->validation($adminUsername);
        $password = $this->fm->validation($adminPassword);

        $username = mysqli_real_escape_string($this->db->link,$username);
        $password = mysqli_real_escape_string($this->db->link,$password);

        if(empty($adminUsername) || empty($adminPassword)){
            $message = "Username or Password is Empty!!";
            return $message;
        }else{
            $query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
            $result= $this->db->select($query);
            if($result != false){
                $value = $result->fetch_assoc();
                Session::set("adminLogin",true);
                Session::set("admin_id",$value['admin_id']);
                Session::set("username",$value['username']);
                Session::set("adminName",$value['adminName']);
                Session::set("role",$value['role']);
                Session::set("photo",$value['photo']);
                header("Location:admin.php");
            }else{
                $message = "Username or Password is invalid!!";
                return $message;
            }
        }
    }
}
?>