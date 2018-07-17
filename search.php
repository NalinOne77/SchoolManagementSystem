<?php
include 'lib/Database.php';
$db = new Database();
?>
<?php
    $rid = $_POST['role_id'];
    $sid = $_POST['school_id'];
    $query = "SELECT DISTINCT * FROM users WHERE user_type='$rid' AND school='$sid'";

    $result = $db->select($query);
        if($result) {
            while ($row =$result->fetch_assoc()) {
                echo '<option value="'.$row['user_id'].'">'.$row['name'].'</option>';
            }
        }else{
            echo '<option>User not found!</option>';
        }


?>
