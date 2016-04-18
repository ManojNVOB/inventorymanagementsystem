<?php
/**
 * Created by PhpStorm.
 * User: akarpm
 * Date: 3/18/2016
 * Time: 8:55 PM
 */


$inventory=217;

if(isset($_SESSION["sessionInventoryID"])) {
    $inventory = $_SESSION["sessionInventoryID"];
}

include('headernav.php');
include("managernav.php");
include("table&queryutility.php");


function showTable()
{



    global $inventory;



    $RefurbishQuery =  "select product_id,product_name,modelno,product_type,emp_name,refurbished_date from
                        (select * from products,employee where emp_id=refurbished_by and
                        product_status='Refurbished' and assign_status is null
                        and inventory=".$inventory." order by refurbished_date desc) where rownum<=10";


    $queryUtility = new MyQueryUtility();
    $conn = $queryUtility->establishConnection();
    $result1 = $queryUtility->runQuery($conn, $RefurbishQuery);

    $headers = array('product_id' => 'PRODUCT_ID',
        'product_name' => 'PRODUCT_NAME',
        'modelno' => 'MODELNO',
        'product_type'=>'PRODUCT_TYPE',
        'emp_name'=>'REFURBISHED_BY',
        'refurbished_date' => 'REFURBISHED_DATE');

    // Get row content.
    $data_cells = array();

    $i = 0;

    while (($row = oci_fetch_array($result1,OCI_BOTH)) != false) {
        $data_cells[$i] = $row;


       /* for ($j = 0; $j < count($headers); $j++) {
            $data_cell[$j] = $row[$j];

        }*/

        // $data_cells[$i] = $data_cell;
        //unset($data_cell);
        $i++;
    }

    $utility = new MyTableUtility();

    $utility->createTable($headers, $data_cells);


    //close connection
    oci_close($conn);

}




?>


<body>



<section>

 <h1 style="margin-left: 35%;color: #0069d3"><u>Recently refurbished products</u></h1>

    <?php
    showTable();
    ?>

</section>

<body>

<?php
include ('footer.php');
//oci_close($conn);

?>

</body>

