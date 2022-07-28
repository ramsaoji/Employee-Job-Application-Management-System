<?php
session_start();
include('db.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
elseif($_SESSION['role'] == 'admin'){

date_default_timezone_set('Asia/Kolkata');

include_once 'get_json.php';

$response = array( 
    'message' => '' 
); 

$password = md5($_POST['password_modal']);

$array_encode = $_SESSION['login_json'];
$array_decode = json_decode($array_encode, true);
$length = count($array_decode);

// Generating Emp Id 

$login_tableid = "SELECT max(login_id)+1 as `cnt` FROM login";
$rsp = mysqli_query($con,$login_tableid);
$rows = mysqli_fetch_assoc($rsp);

if($rows['cnt'] == NULL){
    $count_user = 1;
}else{
    $count_user = $rows['cnt'];
}


$new_user = $_POST["username_modal"];
$flag_name = 0;
$sql_check = 0;

for($i = 0; $i < $length; $i++){

    $user_name = $array_decode[$i]["login_name"];
    if($new_user === $user_name){

        $flag_name = 1;
        break;
    }
    
}
if(ctype_space($_POST['name_modal']) || ctype_space($_POST['username_modal']) || ctype_space($_POST['password_modal'])){

    $flag_name = 2;

}elseif(is_numeric($_POST['name_modal']) || is_numeric($_POST['username_modal'])){

    $flag_name = 3;

}

if($flag_name == 0) {

        $newUser="INSERT INTO `login`(`login_id`,`user_name`,`login_name`,`login_pass`,`role`) 
        VALUES ('$count_user','$_POST[name_modal]', '$_POST[username_modal]', '$password',
        '$_POST[role]')";

        $sql_check = 1;
        

}elseif($flag_name == 1){
    
    $response['message'] = 

    alertMessage("Username Already Exists!!","Please insert unique username.");

}elseif($flag_name == 2){
    
    $response['message'] = 

    alertMessage("Only Whitespaces not allowed!!","Please provide proper input.");

}elseif($flag_name == 3){

    $response['message'] = 

    alertMessage("Name/Username Cannot be Numeric!!","Please provide proper input.");
}

if($sql_check == 1){

    if (mysqli_query($con,$newUser))
    {

        $response['message'] = 

        '<script type="text/javascript">
        swal({ title:"Successfully Inserted."}).then(function(){
            $("input:not(#submit)").val("");
            $("[name=admin]").removeAttr("checked");
            $("[name=user]").removeAttr("checked");
                        
            $.ajax({
            url: "ajax-fetch-users.php",
            method: "POST",
            success: function (data) {

                $("#users_data").html(data);
            }
            });
                
                    
        });</script>';

    }
    else
    {
        $response['message'] = 

        alertMessage("Error adding details in database","");
    
    }

}
}else{
    header('location:../index.php');
}
// Return response 
echo json_encode($response);

// Alert Function
function alertMessage($title, $message) {
 
  return '<script type="text/javascript">
  swal({ title:"'.$title.'", text:"'.$message.'"}).then(function(){
    $("input:not(#submit)").val("");
    $("[name=admin]").removeAttr("checked");
    $("[name=user]").removeAttr("checked");
    
          
});</script>';
       
}
?>


