<?php
session_start();
include('db.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
elseif($_SESSION['role'] == 'admin'){
include_once 'get_json.php';
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>New Employee</title>
    <!-- Bootstrap Styles-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
        integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
        crossorigin="anonymous" /> -->

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link href="../assets/css/custom-styles.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="../scripts/new_employee_script.js"></script>
    
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
            
                <a class="navbar-brand" href="new_employee.php"><i class="fa fa-user"></i> <?php echo $_SESSION['user_name'] ?></a>
            </div>
        </nav>

        <!--/. NAV TOP -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu" style="z-index: -1;">

                    <li>
                        <a class="active-menu" href="new_employee.php"><i class="fa fa-plus"></i> New</a>
                    </li>

                    <li>
                        <a href="reports.php"><i class="far fa-file-alt"></i> Reports</a>
                    </li>

                    <li>
                        <a href="manage-category.php"><i class="fa-solid fa-list-check"></i> Category</a>
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
                    <div class="col-md-12" style="padding-left: 20px;" >
                        <h1 class="page-header">New Employee -</h1>
                    </div>
                </div>

                <table class="row">
                <form name="form" id="formid" enctype="multipart/form-data">
                    <div class="col-md-11" >
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                EMPLOYEE INFORMATION
                            </div>
                            <div class="panel-body" style="padding-bottom: 4px;">

                                

                                <div class="form-group col-md-4">
                                    <label>First Name*</label>
                                    <input id='fname' name='fname' class="form-control" autocomplete="off" placeholder="First Name" required>
                                </div>


                                <div class="form-group col-md-4">
                                    <label>Last Name</label>
                                    <input id='lname' name='lname' class="form-control" autocomplete="off" placeholder="Last Name">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Email</label>
                                    <input id='email' name='email' class="form-control" autocomplete="off" placeholder="Email ID" type="email">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Phone Number</label>
                                    <input id='phone' name='phone' class="form-control" autocomplete="off" placeholder="Phone Number" maxlength="10" type="number"
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Category*</label>
                                    <input id='category' name='category' class="form-control" autocomplete="off" placeholder="Search category...">
                                    <div id="category_list"></div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Profile</label>
                                    <input id='profile' name='profile' class="form-control" autocomplete="off" placeholder="Profile">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Expertise</label>
                                    <textarea style="resize: none; height: 108px" id='expertise' name='expertise' rows="4" class="form-control" autocomplete="off" placeholder="Expertise Description..."></textarea> 
                                </div>
                                
                                <div class="form-group col-md-4">
                                    <label>Joining Date</label>
                                    <input type="text" name="joining_date" id="joining_date" class="form-control dateFilter" autocomplete="off" value="<?php echo date('Y-m-d'); ?>"/>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Experience (In Years)</label>
                                    <input id='exp' name='exp' class="form-control" autocomplete="off" placeholder="Eg. 2 or 10" type="number" maxlength="2"
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Current Salary</label>
                                    <input id="c_salary" name="c_salary" class="form-control" autocomplete="off" placeholder="Current Salary" maxlength="10" type="number"
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Expected Salary</label>
                                    <input id='e_salary' name='e_salary' class="form-control" autocomplete="off" placeholder="Expected Salary" maxlength="10" type="number"
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="file">Upload Resume</label>
                                    <input type="file" id="file" name="file"/>
                                </div>

                                <div class="form-group col-md-2">
                                    <br>
                                    <button id="sub-btn-emp" type="submit" class="btn btn-primary">
                                    Submit
                                    </button>
                                </div>

                                <div class="form-group col-md-2">
                                    <br>
                                    <button id="reset-btn-emp" name="reset" type="reset" class="btn btn-danger" >
                                    Reset
                                    </button>
                                </div>
                            
                                <div id="alerts">

                                </div>

                            </div>
                        </div>
                    </div>
                    </form>
                        </table>
                        <!-- /. PAGE INNER  -->
                    </div>
                    <!-- /. PAGE WRAPPER  -->
            </div>
    </div>

<script>
    // File type validation
    $("#file").change(function() {
        var file = this.files[0];
        var fileType = file.type;
        var match = ['application/pdf', 'application/msword', 'application/vnd.ms-office','application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

        if(!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]) || (fileType == match[3]))){

            swal({
            title: "Invalid File Type Selected.",
            text: "Only PDF and WORD files allowed!!"
            });
            $("#file").val('');
            return false;
        }
    });


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