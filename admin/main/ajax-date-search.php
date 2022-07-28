<?php
session_start();
include('db.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
else{
date_default_timezone_set('Asia/Kolkata');
 
if(isset($_POST["from_date"], $_POST["to_date"])) {


    $main_body = '<script>

    $("#main-body").css("width", "100%");

    </script>';

    $from_date = $_POST["from_date"];
    $to_date = $_POST["to_date"];
    $category_name = $_POST["category_name"];
    $dtToday = date('Y-m-d h:i:sa');

    $output = "";

    if($category_name != ""){

        $array_encode = $_SESSION['category_json'];
        $array_decode = json_decode($array_encode, true);
        $length = count($array_decode);

        for($i = 0; $i < $length; $i++){

            if($category_name == $array_decode[$i]["category_name"]){

                $output = $array_decode[$i]["category_name"];

            }

        }
        if($category_name != $output){

            echo '<script type="text/javascript">
                    swal({
                        title: "Invalid Category.",
                        text: "Please select from search results only!!"
                        });
                    </script>';
            
        }
        
    }
 
    //ALL IN ONE

    $reportData = "";

    if($category_name != ''){
        $query = "call all_report_category('$from_date','$to_date','$category_name');";
    }
    else{
        $query = "call all_report('$from_date','$to_date');";
    }
    
    $result = mysqli_query($con, $query);
 
    if(mysqli_num_rows($result) > 0)
    {
        if($category_name != ''){

            $reportData .='
            <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example" style="border:none; width:100%">
 
                <thead>
                <tr>
                    <td>Name</td>
                    <td>Email</td>
                    <td>Phone</td>
                    <td>Profile</td>
                    <td>Expertise (Hover for more)</td>
                    <td style="visibility:collapse; display:none;">Expertise</td>
                    <td>Joining Date</td>
                    <td>Experience</td>
                    <td>Current Salary</td>
                    <td>Expected Salary</td>
                </tr>
                </thead>';

            while($row = mysqli_fetch_array($result))
            {
                
                if($row["File_Path"] == ""){
                    $resume = '<td style="background: #EDDDFB;">'.$row["Fname"].' '.$row["Lname"].'</td>';
                }else{
                    $resume = '<td class="emp_name"><a href="download.php?FileNo='.$row["File_Path"].'">'.$row["Fname"].' '.$row["Lname"].' </a></td>';
                }

                $reportData .='
                
                <tr>
                '.$resume.'
                <td>'.$row["Email"].'</td>
                <td>'.$row["Phone"].'</td>
                <td>'.$row["Profile"].'</td>
                <td class="expertise_hover" data-toggle="tooltip" data-placement="bottom" title="'.$row["Expertise"].'">'.substr($row["Expertise"], 0, 20).'...</td>
                <td style="visibility:collapse; display:none;">'.$row["Expertise"].'</td>
                <td>'.$row["Joining_Date"].'</td>
                <td>'.$row["Experience_Year"].'</td>
                <td>'.preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $row["Current_Salary"]).'</td>
                <td>'.preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $row["Expected_Salary"]).'</td>
                </tr>';
                
            }
            

            // <!-- DATA TABLE SCRIPTS -->
            
            $reportData .='

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
                    dom: "Blfrtip",
                    "columnDefs": [
                        { "targets": [1,2,3,4,5,6,7,8,9], "searchable": false },
                    ],
                    "language": {
                        "search": "Search Emp Name : " 
                    },
                    "scrollY": 250,
                    "scrollX": true,
                    "scrollCollapse": true,
                    fixedColumns: true,
                    
                    buttons: [

                        // {
                        //     extend: "pdfHtml5",
                        //     title: "Employee - Report",
                        //     messageTop: "Only '.$category_name.' (From '.$from_date.' to '.$to_date.')",
                        //     messageBottom:"\n(Generated On - '.$dtToday.')",
                        //     footer: true,
                        //     orientation: "protrait",
                        //     pageSize: "A4",
                        //     filename: "'.$category_name.' Report - '.$dtToday.'",
                        //     customize: function(doc) {
                        //         doc.styles.message = {
                        //           alignment: "center"
                        //         },
                        //         doc.styles.tableHeader = {
                        //             fillColor: "#223B52",
                        //             alignment: "left",
                        //             bold:!0,
                        //             fontSize:11,
                        //             color: "#fff"
                        //         },
                        //         doc.styles.tableBodyOdd = {
                        //             fillColor: "#E6E6E6"
                        //         }
                        //         // doc.pageMargins = [120,20,100,20]; 
                        //         doc.defaultStyle.fontSize = 11;
                                                             
                        //     }
                               
                        // },
                        {
                            extend: "excelHtml5",
                            title: "Employee - Report",
                            messageTop: "Only '.$category_name.' (From '.$from_date.' to '.$to_date.')",
                            messageBottom:"(Generated On - '.$dtToday.')",
                            footer: true,
                            filename: "'.$category_name.' Report - '.$dtToday.'",
                            exportOptions: {
                                columns: ":not(:nth-child(5))"
                            }
                        }
                        ]
                    });
                });
                </script>';

        
        }
        else{

            $reportData .='
            <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example" style="border:none; width:100%">

            <thead>
                <tr>
                    
                    <td>Name</td>
                    <td>Email</td>
                    <td>Phone</td>
                    <td>Category</td>
                    <td>Profile</td>
                    <td>Expertise (Hover for more)</td>
                    <td style="visibility:collapse; display:none;">Expertise</td>
                    <td>Joining Date</td>
                    <td>Experience</td>
                    <td>Current Salary</td>
                    <td>Expected Salary</td>
                </tr>
            </thead>';

            while($row = mysqli_fetch_array($result))
            {
                if($row["File_Path"] == ""){
                    $resume = '<td style="background: #EDDDFB;">'.$row["Fname"].' '.$row["Lname"].'</td>';
                }else{
                    $resume = '<td class="emp_name"><a href="download.php?FileNo='.$row["File_Path"].'">'.$row["Fname"].' '.$row["Lname"].' </a></td>';
                }

                $reportData .='
                
                <tr>
                '.$resume.' 
                <td>'.$row["Email"].'</td>
                <td>'.$row["Phone"].'</td>
                <td>'.$row["Category_Name"].'</td>
                <td>'.$row["Profile"].'</td>

                <td class="expertise_hover" data-toggle="tooltip" data-placement="bottom" title="'.$row["Expertise"].'">'.substr($row["Expertise"], 0, 20).'...</td>

                <td style="visibility:collapse; display:none;">'.$row["Expertise"].'</td>

                <td>'.$row["Joining_Date"].'</td>
                <td>'.$row["Experience_Year"].'</td>
                <td>'.preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $row["Current_Salary"]).'</td>
                <td>'.preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $row["Expected_Salary"]).'</td>
                </tr>';
            }
            // <!-- DATA TABLE SCRIPTS -->

            $reportData .='

            <script>
            
            $(document).ready(function() {

                $("#dataTables-example").DataTable({
                    "fixHeader": true,
                    "searching": true,
                    "ordering" : false,
                    pageLength: -1,
                    "bLengthChange": false,
                    "bPaginate": false,
                    // lengthMenu: [ [5, 25, 50, -1], [5, 25, 50, "All"] ],
                    dom: "Blfrtip",
                    "language": {
                        "search": "Search Emp Name : " 
                    },
                    "columnDefs": [
                        { "targets": [1,2,3,4,5,6,7,8,9,10], "searchable": false },
                    ],
                    "scrollY": 250,
                    "scrollX": true,
                    "scrollCollapse": true,
                    fixedColumns: true,
          
                     buttons: [

                        // {
                        //     extend: "pdfHtml5",
                        //     title: "Employee - Report",
                        //     messageTop: "(From '.$from_date.' to '.$to_date.')",
                        //     messageBottom:"\n(Generated On - '.$dtToday.')",
                        //     footer: true,
                        //     orientation: "landscape",
                        //     pageSize: "A4",
                            
                        //     filename: "All Report - '.$dtToday.'",
                        //     customize: function(doc) {
                        //         doc.styles.message = {
                        //           alignment: "center"
                        //         },
                        //         doc.styles.tableHeader = {
                        //             fillColor: "#223B52",
                        //             alignment: "left",
                        //             bold:!0,
                        //             fontSize:11,
                        //             color: "#fff"
                        //         },
                        //         doc.styles.tableBodyOdd = {
                        //             fillColor: "#E6E6E6"
                        //         }
                        //         // doc.pageMargins = [30,20,20,0]; 
                        //         doc.defaultStyle.fontSize = 11;
                                                        
                        //     }

                        // },
                        {
                            extend: "excelHtml5",
                            title: "Employee - Report",
                            messageTop: "(From '.$from_date.' to '.$to_date.')",
                            messageBottom:"(Generated On - '.$dtToday.')",
                            footer: true,
                            filename: "All Report - '.$dtToday.'",
                            exportOptions: {
                                columns: ":not(:nth-child(6))"
                            }
                        }
                        ]
                    });
                });
                </script>';
            
        }

        $reportData .='

        </table>
        </div>';  
        
        echo $main_body;
    }   
    else
    {
        $reportData .= '<div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
        <tr>
            <td colspan="12">No Data Found.</td>
        </tr>
        </table>
        </div>';
        
    }
    
    echo $reportData;
}
}
?>