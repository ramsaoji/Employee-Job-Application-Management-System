<?php
session_start();
include('db.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
else{
date_default_timezone_set('Asia/Kolkata');
 
    $main_body = '<script>

    $("#main-body").css("display", "block");

    </script>';

    $output = "";
 
    //ALL IN ONE

    $usersData = "";

    // $check_cat_query = "SELECT DISTINCT emp_category_id FROM employee_details";

    // $check_result = mysqli_query($con, $check_cat_query);

    // $category_emptable = array();

    // if(mysqli_num_rows($check_result) > 0){

    //     while($row_check = mysqli_fetch_array($check_result)){

    //         array_push($category_emptable, $row_check["emp_category_id"]);

    //     }
    // }

    $query = "SELECT * FROM login;";
    
    $result = mysqli_query($con, $query);
 
    if(mysqli_num_rows($result) > 0)
    {
            $usersData .='
            <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example" style="border:none; width:100%">
 
                <thead>
                <tr>
                    <td>Id</td>
                    <td>Name</td>
                    <td>User Name</td>
                    
                    <td>Role</td>
                    <td>Manage</td>
                </tr>
                </thead>';

            while($row = mysqli_fetch_array($result))
            {
                
                if($_SESSION['alogin'] == "superadmin"){

                    if($row["login_id"] == 1){

                        $button_update = '<button type="button" name="update" id="sub-btn-update" update-id="'.$row["login_id"].'" class="btn btn-primary update" style="width: 100px;" data-toggle="modal" data-target="#users-modal-update"><i class="fa fa-sync"></i>  Update</button>';

                        $button_delete = '<button type="button" name="delete" id="sub-btn-delete" del-id="'.$row["login_id"].'" class="btn btn-danger delete" style="width: 100px; margin-left: 5px;" disabled><i class="fa fa-trash"></i>  Delete</button>';

                    }else{

                        $button_update = '<button type="button" name="update" id="sub-btn-update" update-id="'.$row["login_id"].'" class="btn btn-primary update" style="width: 100px;" data-toggle="modal" data-target="#users-modal-update"><i class="fa fa-sync"></i>  Update</button>';

                        $button_delete = '<button type="button" name="delete" id="sub-btn-delete" del-id="'.$row["login_id"].'" class="btn btn-danger delete" style="width: 100px; margin-left: 5px;"><i class="fa fa-trash"></i>  Delete</button>';

                    }

                }elseif($_SESSION['alogin'] == $row["login_name"]){

                    $button_update = '<button type="button" name="update" id="sub-btn-update" update-id="'.$row["login_id"].'" class="btn btn-primary update" style="width: 100px;" data-toggle="modal" data-target="#users-modal-update"><i class="fa fa-sync"></i>  Update</button>';

                    $button_delete = '<button type="button" name="delete" id="sub-btn-delete" del-id="'.$row["login_id"].'" class="btn btn-danger delete" style="width: 100px; margin-left: 5px;"><i class="fa fa-trash"></i>  Delete</button>';

                }else{

                    $button_update = '<button type="button" name="update" id="sub-btn-update" update-id="'.$row["login_id"].'" class="btn btn-primary update" style="width: 100px;" data-toggle="modal" data-target="#users-modal-update" disabled><i class="fa fa-sync"></i>  Update</button>';

                    $button_delete = '<button type="button" name="delete" id="sub-btn-delete" del-id="'.$row["login_id"].'" class="btn btn-danger delete" style="width: 100px; margin-left: 5px;" disabled><i class="fa fa-trash"></i>  Delete</button>';
                }

                
                $usersData .='
                
                <tr>

                <td style="width: 10%">'.$row["login_id"].'</td>
                <td >'.$row["user_name"].'</td>
                <td >'.$row["login_name"].'</td>
                
                <td >'.$row["role"].'</td>
                
                <td style="width: 20%" colspan="2">'.$button_update.' '.$button_delete.'</td>
                
                
                </tr>';
                
            }
            

            // <!-- DATA TABLE SCRIPTS -->
            
            $usersData .='

            <script>
            
             $(document).ready(function() {

                $("#dataTables-example").DataTable({
                    "fixHeader": true,
                    "searching" : true,
                    "ordering" : false,
                    pageLength: -1,
                    "bLengthChange": false,
                    "bPaginate": false,
                    // lengthMenu: [ [5, 25, 50, -1], [5, 25, 50, "All"] ],
                    dom: "lfrtip",
                    "columnDefs": [
                        { "targets": [0,1,3,4], "searchable": false },
                    ],
                    "language": {
                        "search": "Search Username : " 
                    },
                    "scrollY": 250,
                    "scrollX": true,
                    "scrollCollapse": true
                    // fixedColumns: true
                    
                    });
                });
                </script>';

                $usersData .='

                <script>
                
                $("#dataTables-example").on("click", ".delete", function(){
                    var user_id = $(this).attr("del-id");
                    
                    swal({
                        title: "Are you sure?",
                        text: "You want to delete!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        buttons: ["Cancel", "Delete"]
                    }).then((willDelete) => {
                        if (willDelete) {
                            
                            $.ajax({
                                url:"ajax-delete-users.php",
                                method:"POST",
                                data:{user_id:user_id},
                                success:function(data) {					
                                    $.ajax({
                                        url: "ajax-fetch-users.php",
                                        method: "POST",
                                        success: function (data) {
                
                                            $("#users_data").html(data);
                                        }
                                        });
                                }
                            })
                        } 
                    });
                    
                    
                });
               
                </script>';

                $usersData .='

                <script>

                $("#dataTables-example").on("click", ".update", function(){
                    var user_id = $(this).attr("update-id");
                    $.ajax({
                        url:"ajax-users-update.php",
                        method:"POST",
                        data:{user_id:user_id},
                        dataType:"json",
                        success:function(data){
                            
                            $("#users-modal-update").html(data);
                            
                        }
                    })
                });
                
                </script>';

        
        }else{

            $usersData .= '<div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
            <tr>
                <td colspan="12">No Data Found.</td>
            </tr>
            </table>
            </div>'; 

        }

        echo $usersData;

        echo $main_body;

}
?>