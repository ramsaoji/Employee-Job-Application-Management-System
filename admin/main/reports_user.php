<?php
session_start();
include('db.php');
if(strlen($_SESSION['alogin']) == 0)
	{	
header('location:../index.php');
}
else{
include_once 'get_json.php';
date_default_timezone_set('Asia/Kolkata');
?>
<!DOCTYPE html>
<!-- <html xmlns="http://www.w3.org/1999/xhtml"> -->

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reports Search</title>
    <!-- Bootstrap Styles-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />  

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.0.1/js/dataTables.fixedColumns.min.js"></script>
    
   
    <link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet" />

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
                <a class="navbar-brand" href="reports_user.php"><i class="fa fa-user"></i> <?php echo $_SESSION['user_name'] ?></a>
            </div>

           
        </nav>
        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <!-- <li>
                        <a href="new_employee.php"><i class="fa fa-plus"></i> New</a>
                    </li> -->

                    <li>
                        <a class="active-menu" href="reports_user.php"><i class="far fa-file-alt"></i> Reports</a>
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
                            Report Details -
                        </h1>
                    </div>
                </div>
                
                <form name="form" action='print-user.php' target="_blank">
                    
                    <div id="structure" class="form-group" class="date">

                        <label class="from-label1">From</label>
                        <input type="text" name="from_date" id="from_date" class="form-control dateFilter" placeholder="From Date" autocomplete="off" value="<?php echo date('Y-m-d'); ?>" required readonly/>


                        <label class="from-label2">To</label>
                        <input type="text" name="to_date" id="to_date" class="form-control dateFilter" placeholder="To Date" autocomplete="off" value="<?php echo date('Y-m-d'); ?>" required readonly/>

                        <label class="from-label4">Category</label>
                       
                        <div>
                            <input id='category' name='category' class="form-control category_search" autocomplete="off" placeholder="Search Category...">
                            <div id="category_list" class="category_list"></div>
                        </div>



                        <button type="button" name="search" id="btn_search" value="Search" class="btn btn-primary" ><i class="fa fa-search"></i> Search</button>
                  
                        <!-- <button type="submit" name="print" id="btn_print" class="btn btn-primary" >Preview</button> -->
                        
                    </div>
                </form>

                             
                <!-- <div class="row">
                    <div class="col-md-12" > -->
                        
                        <div class="panel panel-default" id="main-body" style="width: 70%;">
                            <div class="panel-body">
                                <div id="report_data">
                                    
                                    <p id="msg">Please select date range for report. (Category - Optional) </p>
        
                                </div>
                            </div>
                        </div>
                    <!-- </div> -->

                    

                <!-- </form> -->
                </div>
                <!-- /. PAGE INNER  -->
            </div>
            <!-- /. PAGE WRAPPER  -->
            <!-- /. WRAPPER  -->
               
            <script>
                
                const todayDate = new Date();
                $( ".dateFilter" ).datepicker({
                    dateFormat: 'yy-mm-dd',//check change
                    changeMonth: true,
                    changeYear: true
                });
                // var todayM = todayDate.getMonth();
                // var todayD = todayDate.getDate();
                // var pastM = todayM - 3;
                // var todayY = todayDate.getFullYear();
                // var x = 1;

                $(document).ready(function () {
                
                    $(".dateFilter").datepicker({ maxDate: todayDate});
                   
                
                    $('#btn_search').click(function () {
                    var from_date = $('#from_date').val();
                    var to_date = $('#to_date').val();
                    var category_name = $('#category').val();

                    if (from_date != '' && to_date != '') {
                        $.ajax({
                        url: "ajax-date-search-user.php",
                        method: "POST",
                        data: { from_date: from_date, to_date: to_date, category_name:category_name},
                        success: function (data) {
                            $('#report_data').html(data);
                 
                            if (x <= 1){
                                $("#structure").append('<button type="submit" name="print" id="btn_print" class="btn btn-primary"><i class="far fa-file"></i> Preview</button>');
                                x++;
                            }
                        }
                        });
                    }
                    else {
                        
                        alert("Please Select the Date");
                    }
                    });
                });

            </script>


            <script>
                var active;

                $(document).ready(function () {

                    $("#category").keyup(function (e) {

                        var code = e.which;

                        if (code == 40) { //key down                     
                            active++;

                            if (active >= $('#category_list ul li').length)
                                active = 0;//$('#drList ul li').length;

                            switchActiveElement();
                            console.log(active);
                        } else if (code == 38) { //key up
                            active--;
                            if (active < 0)
                                active = $('#category_list ul li').length - 1;

                            switchActiveElement();
                            console.log(active);
                        } else if (code == 13) { //enter key
                            selectOption($('.active'));


                        } else {
                            var query = $("#category").val();
                            // print(query);

                            if (query.length > 0) {
                                $.ajax(
                                    {
                                        url: 'ajax-category-search.php',
                                        method: 'POST',
                                        data: {
                                            // search: 1,
                                            query: query
                                        },
                                        success: function (data) {
                                            $('#category_list').fadeIn("fast");
                                            $('#category_list').html(data);
                                            active = -1
                                            if (code = 38)
                                                active = $('#category_list ul li').length;
                                        },
                                        dataType: 'text'
                                    }
                                );
                            }
                            else {
                                $('#category_list').fadeOut();
                            }
                        }

                    });

                    $(document).on('click', '#category_list li', function () {

                        $('#category').val($(this).text());
                        // $('#search_dr_id').val($(this).attr('value'));
                        $('#category_list').fadeOut();
                    });
                    $(document).on('click', function () {
                        $('#category_list').fadeOut();
                    });

                });

                function switchActiveElement() {
                    $('.active').removeAttr('class');
                    $('#category_list ul li:eq(' + active + ')').attr('class', 'active');
                }

                function selectOption(caller) {
                    var country = caller.text();
                    $("#category").val(country);
                    $("#category_list").html("");
                    $('#category_list').fadeOut();

                }

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
}
?>