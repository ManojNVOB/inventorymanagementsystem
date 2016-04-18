<?php
/**
 * Created by PhpStorm.
 * User: akarpm
 * Date: 3/18/2016
 * Time: 12:25 AM
 */

session_start();
   include("table&queryutility.php");




//phpinfo();

   if($_SERVER["REQUEST_METHOD"] == "POST") {
       // username and password sent from form

       $myusername = $_POST['username'];
       $mypassword = $_POST['password'];

       $loginQuery = "SELECT userid,empid FROM admin WHERE userid = '$myusername' and password1 = '$mypassword'";

       $qUtility = new MyQueryUtility();
       $conn = $qUtility->establishConnection();

       $loginResult = $qUtility->runQuery($conn,$loginQuery);

       if(($row = oci_fetch_array($loginResult,OCI_BOTH)) != null){
           // get the employee id and inventory
           $userDetailQuery = "select emp_id,works_for,emp_type from  employee where emp_id=".$row['EMPID'];
           $userDetailsResult = $qUtility->runQuery($conn,$userDetailQuery);

           if(($row = oci_fetch_array($userDetailsResult,OCI_BOTH))!=null){
               $empId = $row['EMP_ID'];
               $inventoryId = $row['WORKS_FOR'];
               $empType = $row['EMP_TYPE'];

               $_SESSION["sessionEmpID"] = $empId;
               $_SESSION["sessionInventoryID"] = $inventoryId;

               $_POST["sessionEmpID"] = $empId;
               $_POST["sessionInventoryID"] = $inventoryId;

               if($empType == "Technician"){
                   echo '<script type="text/javascript" language="javascript">
                    window.open("itemlist.php","_self");
                    </script>';
               }

               if($empType == "Manager"){
                   echo '<script type="text/javascript" language="javascript">
                    window.open("Dashboard.php","_self");
                    </script>';
               }



           }

           echo("Successfully logged in");
       }else{
           $error = "Your Login Name or Password is invalid";
       }


   }
?>
<html >
<head>
    <meta charset="UTF-8">
    <title>Flat HTML5/CSS3 Login Form</title>




    <link rel="stylesheet" href="../TestPHP/css/style.css">




</head>

<body>

<div class="login-page">
    <div class="form">
        <!-- <form class="register-form">
           <input type="text" placeholder="name"/>
           <input type="password" placeholder="password"/>
           <input type="text" placeholder="email address"/>
           <button>create</button>
           <p class="message">Already registered? <a href="#">Sign In</a></p>
         </form>-->
        <form class="login-form" action="" method="post">
            <input type="text" name="username" placeholder="username"/>
            <input type="password" name="password" placeholder="password"/>
            <input type = "submit" value = " login "/>

            <!-- <p class="message">Not registered? <a href="#">Create an account</a></p>-->
        </form>
    </div>
</div>




</body>
</html>
