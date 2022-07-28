<?php
session_start();
include('db.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
else{

    include_once 'get_json.php';

    // Alert Function
    function alertMessage($title, $message) {
    
        return '<script type="text/javascript">
        swal({ title:"'.$title.'", text:"'.$message.'"}).then(function(){
        });</script>';
            
    }

    $response = array( 
        'message' => '' 
    );

    $flag_name = 0;
    $sqlcheck = 0;

    $array_encode = $_SESSION['login_json'];
    $array_decode = json_decode($array_encode, true);
    $length = count($array_decode);

    $new_user = $_POST["username_modal"];
    $new_password = $_POST["password_modal"];

    for($i = 0; $i < $length; $i++){

        $user_name = $array_decode[$i]["login_name"];
        if($new_user === $user_name){
    
            $flag_name = 1;
            break;
        }
        
    }

    for($i = 0; $i < $length; $i++){

        $pass = $array_decode[$i]["login_pass"];
        if($new_password === $pass){
    
            $flag_name = 4;
            break;
        }
        
    }

    if(ctype_space($_POST['name_modal']) || ctype_space($_POST['username_modal']) || ctype_space($_POST['password_modal'])){

        $flag_name = 2;

    }elseif(is_numeric($_POST['name_modal']) || is_numeric($_POST['username_modal'])){

        $flag_name = 3;

    }elseif($flag_name == 1){

        $user_id = strip_tags($_POST['id_modal']);
        $full_name = strip_tags($_POST['name_modal']);
        $username = strip_tags($_POST['username_modal']);
        $password = strip_tags(md5($_POST['password_modal']));
        $role = strip_tags($_POST['role']);

        $updatesql= "UPDATE `login` SET user_name = '$full_name',
        login_pass = '$password', role = '$role' WHERE login_id='$user_id' ";

        $sqlcheck = 1;

        $flag_name = "one";

    }elseif($flag_name == 4){

        $user_id = strip_tags($_POST['id_modal']);
        $full_name = strip_tags($_POST['name_modal']);
        $username = strip_tags($_POST['username_modal']);
        $password = strip_tags($_POST['password_modal']);
        $role = strip_tags($_POST['role']);

        $updatesql= "UPDATE `login` SET user_name = '$full_name', login_name = '$username',
        login_pass = '$password', role = '$role' WHERE login_id='$user_id' ";

        $sqlcheck = 1;

        $flag_name = "four";

    }else{

        $user_id = strip_tags($_POST['id_modal']);
        $full_name = strip_tags($_POST['name_modal']);
        $username = strip_tags($_POST['username_modal']);
        $password = strip_tags(md5($_POST['password_modal']));
        $role = strip_tags($_POST['role']);

        $updatesql= "UPDATE `login` SET user_name = '$full_name', login_name = '$username',
        login_pass = '$password', role = '$role' WHERE login_id='$user_id' ";

        $sqlcheck = 1;

        $flag_name = "zero";

    }


    if($flag_name == 1){
    
        $response['message'] = 

        alertMessage("User Already Exists!!","Please insert unique username.");

    }elseif($flag_name == 2){

        $response['message'] = 

        alertMessage("Only Whitespaces not allowed!!","Please provide proper input.");

    }elseif($flag_name == 3){

        $response['message'] = 

        alertMessage("Name/Username Cannot be Numeric!!","Please provide proper input.");

    }else{

        if($sqlcheck == 1) {

            mysqli_query($con,$updatesql);

            $response['message'] = 

            alertMessage("Updated Successfully.","");

        }else{

            $response['message'] = 

            alertMessage("Error adding details in database","");
        }
    }

    // Return response 
    echo json_encode($response);

}
?>