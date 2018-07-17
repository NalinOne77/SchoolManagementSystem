<?php
/**
 * Created by PhpStorm.
 * User: nalin
 * Date: 7/13/2018
 * Time: 3:36 PM
 */
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php')
?>
<?php
class Notification
{
    private $db;
    private $fm;
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

  /*  This method send notifications to users*/
    public function sendNotification($data,$uid){
        $to =  mysqli_real_escape_string($this->db->link,$data['to']);
        $title =  mysqli_real_escape_string($this->db->link,$data['title']);
        $message =  mysqli_real_escape_string($this->db->link,$data['message']);

        if(empty($to) || empty($title) || empty($message)){
            $msg = "<span class='alert alert-warning'>Field cannot be Empty!</span>";
            return $msg;
        }else{
            $query="INSERT INTO notifications(sent_by, send_to,title, message) VALUES('$uid','$to','$title','$message')";
            $result = $this->db->insert($query);

            if($result){
                $msg = "<span class='alert alert-success'>Notification Sent!</span>";
                return $msg;
            }else{
                $msg = "<span class='alert alert-danger'>Notification cannot send!</span>";
                return $msg;
            }
        }
    }

    /*This method return notifications which are sent by each Teachers*/
    public function getTeacherNotifications($uid){
        $query = "SELECT n.n_id,ut.userType,n.sent_date,n.title,n.message
                  FROM notifications n,user_types ut
                  WHERE n.send_to=ut.user_type_id
                   AND sent_by='$uid' ORDER BY sent_date";
        $result = $this->db->select($query);
        return $result;
    }

    /*This method delete notifications by using user id*/
    public function delNotification($uid){
        $query = "DELETE FROM notifications WHERE n_id='$uid'";
        $result = $this->db->delete($query);
        if($result){
            $msg = "<span class='alert alert-success'>Deleted!</span>";
            return $msg;
        }else{
            $msg = "<span class='alert alert-danger'>Cannot Delete!</span>";
            return $msg;
        }
    }

}