<?php
session_start();
include('db.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
elseif($_SESSION['role'] == 'admin'){
?>

<html>

<head>
    <meta charset="utf-8">
    <title>Report Preview</title>
    <link rel="stylesheet" href="style.css">
    <link rel="license" href="https://www.opensource.org/licenses/mit-license/">

    <script src="script.js"></script>
    
    <style>
    /* reset */

        @font-face {
        font-family: Poppins;
        src: url(../fonts/Poppins-Regular.ttf);
        }

    * {
        border: 0;
        box-sizing: content-box;
        color: inherit;
        font-family: "Poppins", sans-serif;
        font-size: inherit;
        font-style: inherit;
        /* font-weight: inherit;
        line-height: inherit; */
        list-style: none;
        margin: 0;
        padding: 0;
        text-decoration: none;
        vertical-align: top;
    }

    /* content editable */

    /* *[contenteditable] {
        border-radius: 0.25em;
        min-width: 1em;
        outline: 0;
    } */

    *[contenteditable] {
        cursor: pointer;
    }

    *[contenteditable]:hover,
    *[contenteditable]:focus,
    td:hover *[contenteditable],
    td:focus *[contenteditable],
    img.hover {
        background: #DEF;
        box-shadow: 0 0 1em 0.5em #DEF;
    }

    span[contenteditable] {
        display: inline-block;
    }

    /* heading */
    
    h1 {
        font: bold 100% "Poppins", sans-serif;;
        letter-spacing: 0.5em;
        text-align: center;
        text-transform: uppercase;
    }

    /* table */

    table {
        /* border-radius: 2px; */
        font-size: 80%;
        /* table-layout: fixed; */
        width: 100%;

    }

    .tb {
        margin-top: 40px;
        float: right;
        width: 35%;
        /* margin-bottom: 40px; */
    }

    table {
        
        border-collapse: collapse;
        border-spacing: 2px;
        /* border: 1.5px solid grey; */

    }
    thead, tfoot{
        background: #deb6ff;
    }

    th {
        /* border-width: 1.5px; */
        /* padding: 0.5em; */
        position: relative;
        text-align: left;
        /* border-color: grey; */
        /* border-style: solid; */
        /* background-color: #deb6ff; */
        /* border-color: #BBB; */
        color: #2e2c2c;
        letter-spacing: 0.02em;

    }

    
    
    table, td, th, tr {
            position: relative;
            text-align: left;
            padding: 0.5em;
            border: 1px solid #BBB;
        }

    /* th,
    td {
        border-radius: 0.25em;
        border-style: solid;
    }
    */
   
    /* page */

    html {
        font: 16px/1 'Open Sans', sans-serif;
        overflow: auto;
        /* padding: 0.5in; */
    }

    html {
        background: #999;
        cursor: default;
    }

    body {
        box-sizing: border-box;
        height: auto;
        margin: 0 auto;
        overflow: hidden;
        padding: 0.5in;
        width: 8.3in;
    }

    body {
        background: #FFF;
        border-radius: 1px;
        box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
    }

    /* header */

    header {
        margin: 0 0 1em;
    }

    header .report_date{
        /* float: right; */
        text-align:center;
    }

    header:after {
        clear: both;
        content: "";
        display: table;
    }

    header h1 {
        background-color : #CD96FA;
        border-radius: 0.25em;
        color: #FFF;
        margin: 0 0 1em;
        padding: 0.5em 0;
        box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
    }

    header address {
        float: left;
        font-size: 75%;
        font-style: normal;
        line-height: 1.25;
        margin: 0 1em 1em 0;
    }

    header address p {
        margin: 0 0 0.25em;
    }

    header span,
    header img {
        display: block;
        float: right;
    }

    header span {
        margin: 0 0 1em 1em;
        max-height: 25%;
        max-width: 60%;
        position: relative;
    }

    header img {
        max-height: 100%;
        max-width: 100%;
    }

    header input {
        cursor: pointer;
        -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
        height: 100%;
        left: 0;
        opacity: 0;
        position: absolute;
        top: 0;
        width: 100%;
    }

    /* article */

    article,
    article address,
    table.meta,
    table.inventory {
        margin: 0 0 3em;
    }

    article:after {
        clear: both;
        content: "";
        display: table;
    }

    article h1 {
        clip: rect(0 0 0 0);
        position: absolute;
    }

    article address {
        float: left;
        font-size: 125%;
        font-weight: bold;
    }

    /* table meta & balance */

    table.meta,
    table.balance {
        float: right;
        width: 36%;
    }

    table.meta:after,
    table.balance:after {
        clear: both;
        content: "";
        display: table;
    }

    /* table meta */

    table.meta th {
        width: 40%;
    }

    table.meta td {
        width: 60%;
    }

    /* table items */

    table.inventory {
        clear: both;
        width: 100%;
    }

    aside h1 {
        border: none;
        border-width: 0 0 1px;
        margin: 0 0 1em;
    }

    aside h1 {
        border-color: #999;
        border-bottom-style: solid;
    }

    /* javascript */

    .add,
    .cut {
        border-width: 1.5px;
        display: block;
        font-size: .8rem;
        /* padding: 0.25em 0.5em; */
        float: left;
        text-align: center;
        width: 0.6em;
    }

    .add,
    .cut {
        background: #9AF;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        background-image: -moz-linear-gradient(#00ADEE 5%, #0078A5 100%);
        background-image: -webkit-linear-gradient(#00ADEE 5%, #0078A5 100%);
        border-radius: 0.5em;
        border-color: #0076A3;
        color: #FFF;
        cursor: pointer;
        font-weight: bold;
        text-shadow: 0 -1px 2px rgba(0, 0, 0, 0.333);
    }

    .add {
        margin: -2.5em 0 0;
    }

    .add:hover {
        background: #00ADEE;
    }

    .cut {
        opacity: 0;
        position: absolute;
        top: 0;
        left: -1.5em;
    }

    .cut {
        -webkit-transition: opacity 100ms ease-in;
    }

    tr:hover .cut {
        opacity: 1;
    }
    .table-responsive{
        box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
        border-radius: 5px;
    }
    .report-date, .category, div p.generated{
        text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.24);
        text-align: center;
    }
    td{
        text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.24);
    }
    thead td {
        font-weight: bold;
    }

    @media print {
        * {
            -webkit-print-color-adjust: exact;
        }

        html {
            background: none;
            padding: 0;
        }

        body {
            box-shadow: none;
            margin-bottom: 20px;
        }
        span:empty {
            display: none;
        }

        .add,
        .cut {
            display: none;
        }
        
    }

    @page {
        
        margin-bottom: 93px;
    }
    </style>

</head>

<body>

<?php

ob_start();
include 'db.php';
date_default_timezone_set('Asia/Kolkata');
$from_date = $_GET["from_date"];
$to_date = $_GET["to_date"];
$category_name = $_GET["category"];
$dtToday = date('Y-m-d h:i:sa');

//  $pid = $_GET['pid'];
?>

    <header>
        <?php
            $currentDate = new DateTime();        
        ?>
        <h1>Report</h1>

        <div class="report-date" style="font-weight: bold; color:#2e2c2c;"> From Date : <?php echo $from_date;?> To <?php echo $to_date;?>
        </div>
        <?php

        if($category_name != ""){
            echo
            '<br>
            <div class="category" style="font-weight: bold; color:#2e2c2c;"> Category - '.$category_name.'
            </div>';
        }        
        
        ?>
        
        	
        <!-- <span><img alt="" src="assets/img/sun.png"></span> -->
    </header>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-body">

                                <?php

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
                                                <td >Name</td>
                                                <td>Email & Phone</td>
                                                <td>Profile</td>
                                                <td>Joining Date</td>
                                                <td>Experience</td>
                                                <td>Current Salary</td>
                                                <td>Expected Salary</td>
                                            </tr>
                                            </thead>';

                                        while($row = mysqli_fetch_array($result))
                                        {
                                            
                                            $reportData .='
                                            
                                            <tr>
                                            <td>'.$row["Fname"].' '.$row["Lname"].'</td>
                                            <td>'.$row["Email"].'<br>('.$row["Phone"].')</td>
                                            <td>'.$row["Profile"].'</td>
                                            <td>'.$row["Joining_Date"].'</td>
                                            <td>'.$row["Experience_Year"].'</td>
                                            <td>'.preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $row["Current_Salary"]).'</td>
                                            <td>'.preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $row["Expected_Salary"]).'</td>
                                            </tr>';
                                            
                                        }
                            
                                    
                                    }
                                    else{

                                        $reportData .='
                                        <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example" style="border:none; width:100%">

                                        <thead>
                                            <tr>
                                                
                                                <td >Name</td>
                                                <td>Email</td>
                                                
                                                <td>Category</td>
                                                <td>Profile</td>
                                                <td>Joining Date</td>
                                                <td>Exp<br>(Years)</td>
                                                <td>Current Salary</td>
                                                <td>Expected Salary</td>
                                            </tr>
                                        </thead>';

                                        while($row = mysqli_fetch_array($result))
                                        {
                                            $reportData .='
                                            
                                            <tr>
                                            <td style="background: #f9f9f9">'.$row["Fname"].' '.$row["Lname"].'</td>
                                            <td>'.$row["Email"].'<br>('.$row["Phone"].')</td>
                                            
                                            <td>'.$row["Category_Name"].'</td>
                                            <td>'.$row["Profile"].'</td>
                                            <td>'.$row["Joining_Date"].'</td>
                                            <td>'.$row["Experience_Year"].'</td>
                                            <td>'.preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $row["Current_Salary"]).'</td>
                                            <td>'.preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $row["Expected_Salary"]).'</td>
                                            </tr>';
                                        }
                                       
                                        
                                    }

                                    $reportData .='

                                    </table>
                                    </div>';  
                                    
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
                                                               
                                ?> 

                </div>
                
            </div>
            
          
        </div>
       
    </div>
    <div >
        <p class="generated" style = "text-align:center; font-size: 14px; margin-top: 15px;" >(Generated On - <?php echo $dtToday ?>)</p>
    </div>
</body>

</html>
<?php ob_end_flush();
}else{

    header('location:../index.php');
}
?>
