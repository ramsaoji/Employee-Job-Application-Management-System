<?php
// session_start();
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
else{

      function category_table(){

            include('db.php');

            $query = "SELECT * FROM categories;";
            $result = mysqli_query($con, $query);
            $json_array = array();
            
            if(mysqli_num_rows($result) > 0)  
            {  
                  while($row = mysqli_fetch_assoc($result))  
                  {    
                        $json_array[] = $row;
                  }  
            }  
            else  
            {  
                  $output = "Error";
                  echo $output;
            } 

            $array_encode = json_encode($json_array,true);

            $_SESSION['category_json'] = $array_encode;

            // $fo = fopen("../json/category_data.json","w");
            // $fr = fwrite($fo,$array_encode);

      }

      function login_table(){

            include('db.php');

            $query = "SELECT login_name,login_pass FROM login;";
            $result = mysqli_query($con, $query);
            $json_array = array();
            
            if(mysqli_num_rows($result) > 0)  
            {  
                  while($row = mysqli_fetch_assoc($result))  
                  {    
                        $json_array[] = $row;
                  }  
            }  
            else  
            {  
                  $output = "Error";
                  echo $output;
            } 

            $array_encode = json_encode($json_array,true);

            $_SESSION['login_json'] = $array_encode;

            // $fo = fopen("../json/category_data.json","w");
            // $fr = fwrite($fo,$array_encode);

      }

      category_table();
      login_table();

}

?>