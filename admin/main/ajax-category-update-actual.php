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

    $array_encode = $_SESSION['category_json'];
    $array_decode = json_decode($array_encode, true);
    $length = count($array_decode);

    $new_category = $_POST["category_name_modal"];

    for($i = 0; $i < $length; $i++){

        $category_name = $array_decode[$i]["category_name"];
        if($new_category === $category_name){
    
            $flag_name = 1;
            break;
        }
        
    }

    if($_POST['category_name_modal'] == "" || ctype_space($_POST['category_name_modal'])){

        $flag_name = 2;

    }elseif(is_numeric($_POST['category_name_modal'])){

        $flag_name = 3;
    }
    else{

        $cat_id = strip_tags($_POST['category_id_modal']);
        $cat_name = strip_tags($_POST['category_name_modal']);

        $updatesql= "UPDATE `categories` SET category_name = '$cat_name' WHERE category_id='$cat_id' ";

        $sqlcheck = 1;
    }


    if($flag_name == 1){
    
        $response['message'] = 
    
        alertMessage("Category Already Exists!!","Please insert unique category.");

    }elseif($flag_name == 2){

        $response['message'] = 

        alertMessage("Only Whitespaces not allowed!!","Please provide input properly.");

    }elseif($flag_name == 3){

        $response['message'] = 

        alertMessage("Category cannot be Numeric!!","Please provide input properly.");

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