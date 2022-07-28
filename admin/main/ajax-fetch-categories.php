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

    $categoryData = "";

    $check_cat_query = "SELECT DISTINCT emp_category_id FROM employee_details";

    $check_result = mysqli_query($con, $check_cat_query);

    $category_emptable = array();

    if(mysqli_num_rows($check_result) > 0){

        while($row_check = mysqli_fetch_array($check_result)){

            array_push($category_emptable, $row_check["emp_category_id"]);

        }
    }

    $query = "SELECT * FROM categories;";
    
    $result = mysqli_query($con, $query);
 
    if(mysqli_num_rows($result) > 0)
    {
            $categoryData .='
            <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example" style="border:none; width:100%">
 
                <thead>
                <tr>
                    <td>Category Id</td>
                    <td>Category Name</td>
                    <td>Manage</td>
                </tr>
                </thead>';

            while($row = mysqli_fetch_array($result))
            {
                
                if(in_array($row["category_id"], $category_emptable) || $row["category_id"] == 1){

                    $button_delete = '<button type="button" name="delete" id="sub-btn-delete" del-id="'.$row["category_id"].'" class="btn btn-danger delete" style="width: 100px; margin-left: 5px;" disabled><i class="fa fa-trash"></i>  Delete</button>';     
                }
                else{

                    $button_delete = '<button type="button" name="delete" id="sub-btn-delete" del-id="'.$row["category_id"].'" class="btn btn-danger delete" style="width: 100px; margin-left: 5px;"><i class="fa fa-trash"></i>  Delete</button>';

                }

                $button_update = '<button type="button" name="update" id="sub-btn-update" update-id="'.$row["category_id"].'" class="btn btn-primary update" style="width: 100px;" data-toggle="modal" data-target="#category-modal"><i class="fa fa-sync"></i>  Update</button>';
                
                $categoryData .='
                
                <tr>

                <td style="width: 10%">'.$row["category_id"].'</td>
                <td >'.$row["category_name"].'</td>
                
                <td style="width: 20%" colspan="2">'.$button_update.' '.$button_delete.'</td>
                
                
                </tr>';
                
            }
            

            // <!-- DATA TABLE SCRIPTS -->
            
            $categoryData .='

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
                        { "targets": [0,2], "searchable": false },
                    ],
                    "language": {
                        "search": "Search Category : " 
                    },
                    "scrollY": 250,
                    "scrollX": true,
                    "scrollCollapse": true
                    // fixedColumns: true
                    
                    });
                });
                </script>';

                $categoryData .='

                <script>
                
                $("#dataTables-example").on("click", ".delete", function(){
                    var category_id = $(this).attr("del-id");
                    
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
                                url:"ajax-delete-category.php",
                                method:"POST",
                                data:{category_id:category_id},
                                success:function(data) {					
                                    $.ajax({
                                        url: "ajax-fetch-categories.php",
                                        method: "POST",
                                        success: function (data) {
                
                                            $("#category_data").html(data);
                                        }
                                        });
                                }
                            })
                        } 
                    });
                    
                    
                });
               
                </script>';

                $categoryData .='

                <script>

                $("#dataTables-example").on("click", ".update", function(){
                    var category_id = $(this).attr("update-id");
                    $.ajax({
                        url:"ajax-category-update.php",
                        method:"POST",
                        data:{category_id:category_id},
                        dataType:"json",
                        success:function(data){
                            
                            $("#category-modal").html(data);
                            
                        }
                    })
                });
                
                </script>';

        
        }else{

            $categoryData .= '<div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
            <tr>
                <td colspan="12">No Data Found.</td>
            </tr>
            </table>
            </div>'; 

        }

        echo $categoryData;

        echo $main_body;

}
?>