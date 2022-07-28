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


$array_encode = $_SESSION['category_json'];
$array_decode = json_decode($array_encode, true);
$length = count($array_decode);

// Generating Emp Id 

$emp_tableid = "SELECT max(category_id)+1 as `cnt` FROM categories";
$rsp = mysqli_query($con,$emp_tableid);
$rows = mysqli_fetch_assoc($rsp);

if($rows['cnt'] == NULL){
    
    $count_emp = 1;
}else{
    $count_emp = $rows['cnt'];
}


$new_category = $_POST["new_category"];
$flag_name = 0;
$sql_check = 0;

for($i = 0; $i < $length; $i++){

    $category_name = $array_decode[$i]["category_name"];
    if($new_category === $category_name){

        $flag_name = 1;
        break;
    }
    
}
if($_POST['new_category'] == "" || ctype_space($_POST['new_category'])){

    $flag_name = 2;

}elseif(is_numeric($_POST['new_category'])){

    $flag_name = 3;

}

if($flag_name == 0) {

        $newUser="INSERT INTO `categories`(`category_id`,`category_name`) 
        VALUES ('$count_emp','$_POST[new_category]')";

        $sql_check = 1;
        

}elseif($flag_name == 1){
    
    $response['message'] = 

    alertMessage("Category Already Exists!!","Please insert unique category.");

}elseif($flag_name == 2){
    
    $response['message'] = 

    alertMessage("Category Cannot be Empty!!","Please provide proper input.");

}elseif($flag_name == 3){

    $response['message'] = 

    alertMessage("Category Cannot be Numeric!!","Please provide proper input.");
}

if($sql_check == 1){

    if (mysqli_query($con,$newUser))
    {

        $response['message'] = 

        '<script type="text/javascript">
        swal({ title:"Successfully Inserted."}).then(function(){
            $("input:not(#btn_new_category)").val("");
                        
            $.ajax({
            url: "ajax-fetch-categories.php",
            method: "POST",
            success: function (data) {

                $("#category_data").html(data);
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
    $("input:not(#btn_new_category)").val("");
          
});</script>';
       
}
?>


