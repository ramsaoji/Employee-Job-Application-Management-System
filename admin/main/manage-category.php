<?php
session_start();
include('db.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
elseif($_SESSION['role'] == 'admin'){

include_once 'get_json.php';

date_default_timezone_set('Asia/Kolkata');
?>
<!DOCTYPE html>
<!-- <html xmlns="http://www.w3.org/1999/xhtml"> -->

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Category</title>
    <!-- Bootstrap Styles-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />  

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.0.1/js/dataTables.fixedColumns.min.js"></script>
   
    <link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet" />

    <!-- MODAL -->
    <script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

    <!-- Custom Styles-->
    <link href="../assets/css/custom-styles.css" rel="stylesheet" />
    <link href="../assets/css/datepicker.css" rel="stylesheet" />
    <link href="../assets/css/custom-datatables.css" rel="stylesheet" />
        
</head>

<body>
    <div id="wrapper">

        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="new_employee.php"><i class="fa fa-user"></i> <?php echo $_SESSION['user_name'] ?></a>
            </div>

           
        </nav>
        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a href="new_employee.php"><i class="fa fa-plus"></i> New</a>
                    </li>

                    <li>
                        <a href="reports.php"><i class="far fa-file-alt"></i> Reports</a>
                    </li>

                    <li>
                        <a class="active-menu" href="manage-category.php"><i class="fa-solid fa-list-check"></i> Category</a>
                    </li>

                    <li>
                        <a href="manage-login-users.php"><i class="fa-solid fa-user"></i> Users</a>
                    </li>

                    <!-- <li>
                        <a  href="record-manage-show.php"><i class="fa fa-database"></i> Manage</a>
                    </li> -->

                    <li id="logout" style="cursor: pointer;">
                        <a><i class="fa fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            </div>

        </nav>
        <!-- /. NAV SIDE  -->

        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Manage Categories -
                        </h1>
                    </div>
                </div>
                
                <form name="form" id="form">
                    
                    
                    <div id="structure" class="form-group" class="date">

                        <input id='new_category' name='new_category' class="form-control" autocomplete="off" placeholder="Add New Category...">

                        <input type="submit" name="btn_new_category" id="btn_new_category" class="btn btn-primary" value="Insert" ></input>

                        <!-- <button type="button" name="btn_all_category" id="btn_all_category" class="btn btn-primary" > Show all Categories</button> -->
        
                        
                    </div>
                </form>


                <!-- Modal -->
                <div id="category-modal" class="modal fade" role="dialog">
                
                </div>

                                           
                <!-- <div class="row">
                    <div class="col-md-12" > -->
                        
                        <div class="panel panel-default" id="main-body" style="width: 70%; display:none">
                            <div class="panel-body">
                                <div id="category_data">
                                    
                                    <!-- <p id="msg">Please select date range for report. (Category - Optional) </p> -->
        
                                </div>
                                
                            </div>
                        </div>
                    <!-- </div> -->

                    <div id="alerts"></div>

                    

                <!-- </form> -->
                </div>
                <!-- /. PAGE INNER  -->
            </div>
            <!-- /. PAGE WRAPPER  -->
            <!-- /. WRAPPER  -->
               
            <script>

                // $(document).ready(function () {
                
                                   
                //     $('#btn_all_category').click(function () {
                        $.ajax({
                        url: "ajax-fetch-categories.php",
                        method: "POST",
                        success: function (data) {

                            $('#category_data').html(data);
                        }
                        });
                    
                    // });
                // });

            </script>

            <script>

            $(document).ready(function(e){
                // Submit new_category form data via Ajax
                $("#form").on('submit', function(e){
                    e.preventDefault();
                    $.ajax({

                        type: "POST",
                        url: "ajax-insert-categories.php",
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        data: new FormData(this),	

                        success: function(response){ 
                            $('#alerts').html(response.message);
                        }
                    });
                });
                
            });

            </script>

            <script>

                function submitForm(){
                $.ajax({
                    type: "POST",
                    url: "ajax-category-update-actual.php",
                    cache:false,
                    data: $('form#categoryForm').serialize(),
                    success: function(response){

                        $("#category-modal").modal('hide');

                        const myObj = JSON.parse(response)

                        $('#alerts').html(myObj.message);
                        // alert(myObj.message);
                        
                        $.ajax({
                        url: "ajax-fetch-categories.php",
                        method: "POST",
                        success: function (data) {

                            $("#category_data").html(data);
                        }
                        });

                    },
                    error: function(){
                        alert("Error");
                    }
                });
            }

            </script>

            <script>
               
                //LOGUT ARELT FUNCTION
                $(document).on('click', '#main-menu #logout', function () {

                    swal({
                        title: "Are you sure?",
                        text: "You want to logout!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        buttons: ['Cancel', 'Logout']
                    }).then((willLogout) => {
                        if (willLogout) {
                            window.location = "logout.php";
                        } 
                    });


                    });

            </script>

</body>

</html>

<?php 
}else{
    header('location:../index.php');
}
?>