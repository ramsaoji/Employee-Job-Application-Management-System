<?php
session_start();
include('db.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
else{

include_once 'get_json.php';

date_default_timezone_set('Asia/Kolkata');
 
    $error = "";
    $modal_data = "";
    $admin = "";
    $user = "";

    $user_id = $_POST["user_id"];
 
    //ALL IN ONE

    $query = "SELECT * FROM login WHERE login_id = '$user_id';";
    
    $result = mysqli_query($con, $query);
 
    if(mysqli_num_rows($result) > 0){
            
            while($row = mysqli_fetch_array($result)){

                $login_id = $row["login_id"];
                $full_name = $row["user_name"];
                $user_name = $row["login_name"];
                $password = $row["login_pass"];
                $role = $row["role"];
                
            }

    }else{
            $error = "Error"; 

        }

        if($_SESSION['alogin'] == "superadmin" && $login_id == 1){

            $admin = '<input type="radio" id="admin" name="role" value="admin" checked required>';
            $user = '<input type="radio" id="user" name="role" value="user" style="margin-left:15px;" required disabled>';
            

        }elseif($role == "admin"){  

            $admin = '<input type="radio" id="admin" name="role" value="admin" checked required>';
            $user = '<input type="radio" id="user" name="role" value="user" style="margin-left:15px;" required>';

        } else {

            $admin = '<input type="radio" id="admin" name="role" value="admin" required>';
            $user = '<input type="radio" id="user" name="role" value="user" style="margin-left:15px;" checked required>';
        }


        $modal_data ='
        
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>Update Login Users -</h3>
            </div>
            <form id="usersFormUpdate" name="contact" role="form" onsubmit = "event.preventDefault(); submitFormUpdate();">
                <div class="modal-body">
                
                    <div class="form-group">
                        <label for="id"> Login Id - </label>
                        <input type="text" name="id_modal" id="id_modal" class="form-control" style="margin-left:35px; width:50%;" value="'.$login_id.'" readonly>
                    </div>

                    <div class="form-group">
                        <label for="fullname"> Name - </label>
                        <input type="text" name="name_modal" id="name_modal" class="form-control" style="margin-left:47px; width:50%;" placeholder="Full Name..." value="'.$full_name.'" required>
                    </div>

                    <div class="form-group">
                        <label for="name">Username - </label>
                        <input type="text" name="username_modal" id="username_modal" class="form-control" style="margin-left:20px; width:50%;" placeholder="User Name..." value="'.$user_name.'" required>
                    </div>

                    <div class="form-group">
                        <label for="name">Password - </label>
                        <input type="password" name="password_modal" id="password_modal" class="form-control" style="margin-left:24px; width:50%;" placeholder="Password..." value="'.$password.'" required>
                    </div>

                    <div class="form-group">
                        '.$admin.'
                        <label for="admin" style="margin-left:15px; margin-top:8px;">Admin</label>
                        '.$user.'
                        <label for="user" style="margin-left:15px; margin-top:8px;">User</label>
                    </div>
                                    
                </div>
                <div class="modal-footer">					
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-success" id="submit">
                </div>
            </form>
        </div>
    </div>';

    echo json_encode($modal_data);

}
?>