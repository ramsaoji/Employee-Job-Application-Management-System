<?php
session_start();
include('db.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
elseif($_SESSION['role'] == 'admin'){

date_default_timezone_set('Asia/Kolkata');

// Generating Emp Id 

$emp_tableid = "SELECT max(emp_id)+1 as `cnt` FROM employee_details";
$rsp = mysqli_query($con,$emp_tableid);
$rows = mysqli_fetch_assoc($rsp);

if($rows['cnt'] == NULL){
    $count_emp = 1;
}else{
    $count_emp = $rows['cnt'];
}


// Upload File

$uploadDir = '../uploads/';

$response = array( 
    'message' => '' 
); 
$date = date('mdy-his', time());
$uploadedFile = ''; 
$uploadStatus = 0;

if(!empty($_FILES["file"]["name"])){ 

    // File path config 
    $fileName = "Emp-" . $count_emp . "-" . $date . "-" . basename($_FILES["file"]["name"]); 
    $targetFilePath = $uploadDir . $fileName; 
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
     
    // Allow certain file formats 
    $allowTypes = array('pdf', 'doc', 'docx'); 
    if(in_array($fileType, $allowTypes)){ 
        // Upload file to the server 
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){ 
            $uploadedFile = $fileName;
            $uploadStatus = 1; 
        }else{ 

            $uploadStatus = 2; 
        } 
    }else{ 
        $uploadStatus = 3; 

    } 
    
}
if($uploadStatus == 2){

    $response['message'] = 

    alertMessage("Error in uploading file!!","");
    
}elseif($uploadStatus == 3){

    $response['message'] = 

    alertMessage("Invalid File Type.","Only PDF and WORD files allowed!!");
}
//Upload File End

$alogin = $_SESSION['alogin'];
$array_encode = $_SESSION['category_json'];
$array_decode = json_decode($array_encode, true);
$length = count($array_decode);

$addslashes = addslashes($_POST['expertise']);

$category_search = $_POST["category"];
$flag_name = 0;
$sql_check = 0;

for($i = 0; $i < $length; $i++){

    $category_name = $array_decode[$i]["category_name"];
    if($_POST['category'] === $category_name){

        $category_id = $array_decode[$i]["category_id"];
        $flag_name = 1;
        break;
    }
    
}

if($flag_name == 1) {

        if($uploadStatus == 0){

            $targetFilePath = "";
        }

        if($uploadStatus == 0 || $uploadStatus == 1){

            $newUser="INSERT INTO `employee_details`(`emp_id`,`fname`,`lname`,`email`,`phone`,`emp_category_id`,`profile`,`expertise`,`joining_date`,`exp_year`,`current_salary`,`expected_salary`,`created_by`,`file_name`) 
        VALUES ('$count_emp','$_POST[fname]','$_POST[lname]','$_POST[email]','$_POST[phone]','$category_id','$_POST[profile]',trim('$addslashes'),'$_POST[joining_date]','$_POST[exp]','$_POST[c_salary]','$_POST[e_salary]','$alogin','$targetFilePath')";

        $sql_check = 1;

        }
        

}else{
    
    $response['message'] = 

    alertMessage("Invalid Category Name.","Please select from search results only!!");

}

if($sql_check == 1){

    if (mysqli_query($con,$newUser))
    {

        $response['message'] = 

        alertMessage("Successfully Submitted!","");

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
  swal({ title:"'.$title.'", text:"'.$message.'"}).then(function(){ $("input:not(#joining_date)").val(""); $("textarea#expertise").val(""); });</script>';
       
}
?>


