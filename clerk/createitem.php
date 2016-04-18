<?php
/**
 * Created by PhpStorm.
 * User: akarpm
 * Date: 4/17/2016
 * Time: 10:27 AM
 */

session_start();
include('headernav.php');
include('clerknavi.php');
include('table&queryutility.php');



$inventory_id = 217;


$loc_id = 0;
$prod_id;
$name;
$modelno;
$spec_id;
$manufacdate;
$org_id;




if(isset($_SESSION["sessionInventoryID"])){
    $inventory_id = $_SESSION["sessionInventoryID"];
}

$qUtility = new MyQueryUtility();
$conn = $qUtility->establishConnection();


// get unused location
$locQuery = "select loc_seq_id from item_location where inventory_id=".$inventory_id."minus
                (select location from products where inventory=".$inventory_id."
                union select location from parts where inventory=".$inventory_id.")";


$locIDResult = $qUtility->runQuery($conn,$locQuery);


if(($row = oci_fetch_array($locIDResult,OCI_BOTH))!=null){
    global $loc_id;

    $loc_id = $row[0];
}


if( isset($_POST['submit'])){




    $name =  $_POST['field1'];
    $modelno = $_POST['field2'];
    $seller = $_POST['field3'];
    $prod_type = $_POST['field4'];
    $price = $_POST['field5'];
    $manufacdate = $_POST['field6'];
    //$location = $_POST['field7'];

    $ram = $_POST['field8'];
    $processor = $_POST['field9'];
    $hdd = $_POST['field10'];
    $battery = $_POST['field11'];
    $keyboard = $_POST['field12'];
    $resolution = $_POST['field13'];
    $screenSize = $_POST['field14'];

    // get specification with matching parts value if any

    $specQuery  = "select spec_id from specification
                  where ramingb=".$ram." and hddingb=".$hdd." and processor='".$processor."' and
                  screen_size='".$screenSize."' and battery='".$battery."' and keyboard='".$keyboard."' and
                  resolution='".$resolution."'";

    $specResult = $qUtility->runQuery($conn,$specQuery);


    if(($row = oci_fetch_array($specResult,OCI_BOTH))!=null){
        global $spec_id;

        $spec_id = $row[0];

    }

    // get organization ID

    $orgQuery = "select org_id from organization where org_type='Seller' and org_name='".$seller."'";
   $orgResult = $qUtility->runQuery($conn,$orgQuery);


    if(($row = oci_fetch_array($orgResult,OCI_BOTH))!=null){
        global $org_id;
        $org_id = $row[0];

    }



    // get max product_id
    $prodIDQuery  = "select max(product_id) from products";
   $ProdIDResult = $qUtility->runQuery($conn,$prodIDQuery);


    if(($row = oci_fetch_array($ProdIDResult,OCI_BOTH))!=null){
        global $prod_id;
        $prod_id = $row[0]+1;


    }



    // insert product into table

    $createProdQuery = "insert into products values (".$prod_id.",'".$name."','".$modelno."','".$spec_id."'
                        ,TO_DATE('".$manufacdate."','dd/mm/yy'),null,null,
                        'Non-Refurbished',null,'".$org_id."',null,null,
                        null,null,".$price.",".$loc_id.",".$inventory_id.",sysdate,'LAPTOP',null)";
    $createResult = $qUtility->runQuery($conn,$createProdQuery);

   // echo $prodIDQuery;
   // echo $locQuery;
    //echo $specQuery;
    //echo $orgQuery;
   // echo $createProdQuery;


    if($createResult){?>
        <script language="javascript">




            window.alert("Product successfully created !!! Create products page will appear again .");


        </script>

   <?php }

    // get unused location
    $locQuery = "select loc_seq_id from item_location where inventory_id=".$inventory_id."minus
                (select location from products where inventory=".$inventory_id."
                union select location from parts where inventory=".$inventory_id.")";


    $locIDResult = $qUtility->runQuery($conn,$locQuery);


    if(($row = oci_fetch_array($locIDResult,OCI_BOTH))!=null){
        global $loc_id;

        $loc_id = $row[0];
    }




}









?>

<head>
    <h2 style="margin-left: 45%"> <b><u>Create Product</u></b> </h2>
    <link rel="stylesheet" href="css/form.css" type="text/css"/>
</head>

<section>
    <form action="createitem.php" method="post">
        <div style="float: left;width: 1000px;height: 470px">
            <div  style="float: left;width: 500px;height: 300px">

                    <ul class="form-style-1">
                            <li>
                            <label>Product Type</label>
                            <select name="field4" class="field-select">
                                <option value="Laptop">Laptop</option>
                                <option value="Desktop">Desktop</option>
                                <option value="Printer">Printer</option>
                            </select>
                            </li>
                            <li><label>Product Name <span class="required">*</span></label><input type="text" name="field1" class="field-divided" placeholder="Name" />&nbsp;<input type="text" name="field2" class="field-divided" placeholder="Model No." /></li>
                            <li>
                            <li><label>Seller & Price <span class="required">*</span></label><input type="text" name="field3" class="field-divided" placeholder="Organization" />&nbsp;<input type="text" name="field5" class="field-divided" placeholder="Price" /></li>
                            </li>

                            <li>
                            <li><label>Date & Location <span class="required">*</span></label><input type="text" name="field6" class="field-divided" placeholder="Manufacturing Date" />&nbsp;<input type="text" name="field7" class="field-divided" placeholder="Inventory Location" value="<?php echo$loc_id?>" disabled /></li>
                            </li>

                            <li>
                                <br>
                    </ul>

            </div>

            <div  style="float: left;width: 500px;height: 300px">

                    <ul class="form-style-1">
                        <h3 style="margin-left: 30%"> Parts Attributes </h3>
                        <li>
                            <input type="text" name="field8" class="field-divided" placeholder="Ram in GB" />&nbsp;<input type="text" name="field9" class="field-divided" placeholder="Processor" /></li>
                        </li>
                        <br>
                        <li>
                            <input type="text" name="field10" class="field-divided" placeholder="HDD in GB" />&nbsp;<input type="text" name="field11" class="field-divided" placeholder="Battery" /></li>
                        </li>
                        <br>
                        <li>
                            <input type="text" name="field12" class="field-divided" placeholder="Keyboard" />&nbsp;<input type="text" name="field13" class="field-divided" placeholder="Resolution" /></li>
                        </li>
                        <br>
                        <li>
                            <input type="text" name="field14" class="field-divided" placeholder="Screen size" />
                        </li>




                    </ul>

            </div>

            <div  style="float: left;width: 500px;height: 70px;padding-left: 40%">
                <ul class="form-style-1">
                    <li>
                        <input type="submit" value="Submit" name="submit"  />
                    </li>
                </ul>
            </div>

        </div>
    </form>

</section>
<?php include("footer.php")?>