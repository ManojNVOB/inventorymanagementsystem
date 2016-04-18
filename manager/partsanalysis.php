<?php
/**
 * Created by PhpStorm.
 * User: akarpm
 * Date: 4/16/2016
 * Time: 8:20 PM
 */


session_start();

include('headernav.php');
include('managernav.php');
include('table&queryutility.php');
include "../libchart/classes/libchart.php";


$inventory_id = 217;

if(isset($_SESSION["sessionInventoryID"])){
    $inventory_id = $_SESSION["sessionInventoryID"];
}

$qUtility = new MyQueryUtility();
$conn = $qUtility->establishConnection();



$queryMap = array(
    "LAPTOP" =>"RAM,PROCESSOR,HDD,KEYBOARD,BATTERY",
    "DESKTOP" =>"RAM,PROCESSOR,HDD,KEYBOARD",
    "PRINTER" =>"PRINTHDD,PRINTHEAD,SCANNER,PRINTMEMORY,CATRIDGE"
);




    $line = array();
    $wholeTable = array();

    $allTables=array();
    $header = array(
        "PART NAME",
        "CONSUMED %",
        "NOT CONSUMED %"
    );


    foreach($queryMap as $productType => $partTypes){



        $i = 0;

        $partTypes = explode(",",$partTypes);


        unset($wholeTable);
        foreach($partTypes as $partType){


            $refurbishedPercent =  getPercentRefurbishedWithPart($partType,$inventory_id,$productType);
            $noRefurbishedPercent =  getNonRefurbishedPartsPercent($partType,$inventory_id,$productType);

            $line[0] = $partType;
            $line[1] = sprintf ("%.2f", $refurbishedPercent);
            $line[2] = sprintf("%.2f",$noRefurbishedPercent);

            $wholeTable[$i] = $line;
            $i++;

        }

        $allTables[$productType] = $wholeTable;


    }


    function drawLaptopTable(){
        global $allTables;
        global $header;

        $dataCells = $allTables['LAPTOP'];
        drawTables($header,$dataCells,"LAPTOP PARTS ANALYSIS");

    }

    function drawDesktopTable(){
        global $allTables;
        global $header;

        $dataCells = $allTables['DESKTOP'];
        drawTables($header,$dataCells,"DESKTOP PARTS ANALYSIS");
    }

    function drawPrinterTable(){
        global $allTables;
        global $header;

        $dataCells = $allTables['PRINTER'];
        drawTables($header,$dataCells,"PRINTER PARTS ANALYSIS");
    }











    function getPercentRefurbishedWithPart($partType,$inventoryID,$productType){

        global $conn;
        global $qUtility;
        $percent = 0;


        $refurbishPartCountQueryStatement = "select count(*) partcount from products p,refurbishes r,parts pa
                                        where p.product_status = 'Refurbished'
                                        and p.inventory=".$inventoryID." and p.product_type = '".$productType."'
                                        and p.product_id=r.product_id
                                        and r.part_id=pa.part_id and pa.part_name='".$partType."' ";




        $refurbishedProductCountQueryStatement = "select count(*) refprod from products p  where p.product_status = 'Refurbished'
                                                and p.inventory=".$inventoryID."
                                                and p.product_type = '".$productType."'";



        $partCountResult = $qUtility->runQuery($conn,$refurbishPartCountQueryStatement);
        $productCountResult = $qUtility->runQuery($conn,$refurbishedProductCountQueryStatement);

        if(($row = oci_fetch_array($partCountResult,OCI_BOTH))!=null){

            $partCount = $row[0];
            if(($row = oci_fetch_array($productCountResult,OCI_BOTH))!=null){
                $productCount = $row[0];
            }

            if($partCount !=0 and $productCount!=0){
                $percent = ($partCount/$productCount)*100;
            }



        }

        return $percent;
    }

    function getNonRefurbishedPartsPercent($partType,$inventoryID,$productType){
        global $conn;
        global $qUtility;
        $percent = 0;
        $productCount = 0;
        $partCount = 0;

        $notUsedPartsQuery = "select count(*) from parts where consume_status = 'Not used'
                              and inventory=".$inventoryID." and part_name='".$partType."'";



        $notRefurbishedProductsQuery = "select count(*) from products where product_status = 'Non-Refurbished'
                                        and inventory=".$inventoryID." and product_type='".$productType."'";

        $partCountResult = $qUtility->runQuery($conn,$notUsedPartsQuery);
        $productCountResult = $qUtility->runQuery($conn,$notRefurbishedProductsQuery);

        if(($row = oci_fetch_array($partCountResult,OCI_BOTH))!=null){
            $partCount = $row[0];
            if(($row = oci_fetch_array($productCountResult,OCI_BOTH))!=null){
                $productCount = $row[0];
            }

        }
        if($partCount !=0 and $productCount!=0){
            $percent = ($partCount/$productCount)*100;
        }

        return $percent;

}


    function drawTables($headers,$data_cells,$caption){?>
        <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
            <html>
            <div>

            </div>
               <head>
                        <link rel="stylesheet" href="css/table.css" type="text/css"/>
            </head>
            <body >
            <table  class="CSS_Table_Example" style="background-color:#4affed; margin-left: 5%;width: 400px" border="1">
                <caption><?php $caption?></caption>
                <tr>
                    <?php foreach ($headers as $header): ?>
            <th><?php echo $header; ?></th>
        <?php endforeach; ?>
        </tr>
        <?php foreach ($data_cells as $data_cell): ?>
            <tr>

                <?php for ($k = 0; $k < count($headers); $k++):
                    ?>
                    <td>
                        <?php echo $data_cell[$k]; ?>
                    </td>

                <?php endfor;

                ?>


            </tr>
        <?php endforeach; ?>
        </table>
        </body>
        </html>

    <?php
    }


oci_close($conn);

?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Libchart vertical bars demonstration</title>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>

<section>
    <div id="topcontainer" style="float: left;width: 1170px;height: 470px">

        <div id="secondcontainer" style="float: left;width: 1170px;height: 225px">
            <div id="left" style="float: left;width: 570px;height: 225px">
                <h4 style="color: #0069d3;margin-left: 20%"><b>Laptop Stats</b></h4>
                <?php drawLaptopTable()?>
            </div>
            <div id="right" style="float: left;width: 570px;height: 225px">
                <h4 style="color: #0069d3;margin-left: 20%"><b>Desktop Stats</b></h4>
                <?php drawDesktopTable()?>
            </div>

        </div>

        <div id="thirdcontainer" style="float: left;width: 1170px;height: 225px">
            <div id="thirdcontainer" style="float: left;width: 570px;height: 225px;padding-top: 10px">
                <h4 style="color: #0069d3;margin-left: 20%"><b>Printer Stats</b></h4>
                <?php drawPrinterTable()?>

            </div>
            <div id="right" style="float: left;width: 570px;height: 225px;border: thin;border-width: 1px">
                <div style="float: left;width: 570px;height: 100px;padding-top: 10%">
                   <h3 style="color: #0069d3">Consumed % = Products refurbished with this part/Total no of products refurbished</h3>
                </div>
                <div style="float: left;width: 570px;height: 100px">
                    <h3 style="color: #0069d3">Not Consumed % = No. of unused part of this type/Total no of non-refurbished products</h3>
                </div>
            </div>

        </div>


    </div>

</section>




</body>
</html>

<?php include('footer.php')?>
