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

    $category_id = $_POST["category_id"];
 
    //ALL IN ONE

    $query = "SELECT * FROM categories WHERE category_id = '$category_id';";
    
    $result = mysqli_query($con, $query);
 
    if(mysqli_num_rows($result) > 0){
            
            while($row = mysqli_fetch_array($result)){

                $cat = $row["category_id"];
                $cat_name = $row["category_name"];
                
            }

    }else{
            $error = "Error"; 

        }

        $modal_data ='
        
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <a class="close" data-dismiss="modal">×</a>
                        <h3>Category Update -</h3>
                    </div>
                    <form id="categoryForm" name="contact" role="form" onsubmit = "event.preventDefault(); submitForm();">
                        <div class="modal-body">				
                            <div class="form-group">
                                <label for="id">Category Id - </label>
                                <input type="text" name="category_id_modal" id="category_id_modal" class="form-control" style="margin-left:47px" value='.$cat.' readonly>
                            </div>

                            <div class="form-group">
                                <label for="name">Category Name - </label>
                                <input type="text" name="category_name_modal" id="category_name_modal" class="form-control" style="margin-left:20px" value="'.$cat_name.'" required>
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