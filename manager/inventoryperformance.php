<?php
/**
 * Created by PhpStorm.
 * User: akarpm
 * Date: 4/16/2016
 * Time: 11:05 AM
 */

session_start();


$inventory=217;


if(isset($_SESSION["sessionInventoryID"])){
    $inventory = $_SESSION["sessionInventoryID"];
}

include('headernav.php');
include('managernav.php');
include('table&queryutility.php');
include "../libchart/classes/libchart.php";



    $qUtility = new MyQueryUtility();
    $conn = $qUtility->establishConnection();

    $year = 2015;
    $productType = 'LAPTOP';

    if(isset($_GET['submit'])){
        $year = $_GET['year'];
        $productType = strtoupper($_GET['prodtype']);
    }

    $queryMap = array(
        "refurbished_date" =>"refurbishment",
        "shipped_date" =>"shipping",
        "entry_date" =>"entry",
    );

    foreach($queryMap as $dateType => $imageName){
        runQuery($dateType,$year,$productType,$imageName);
    }

    function runQuery($dateType,$year,$productType,$imageName){

        global $qUtility;
        global $conn;

        $processedQueryStatement  = getQueryStatement($dateType,$year,$productType);




        $shippedProductsResult = $qUtility->runQuery($conn,$processedQueryStatement);

        $chart = new VerticalBarChart(500,200);

        $dataSet = new XYDataSet();


        $count = 0;
        while(($row = oci_fetch_array($shippedProductsResult,OCI_BOTH))!=null){
            $year = $row['YEAR'];
            $month = $row['MONTH'];
            $prodCount = $row['PROD'];

            $dataSet->addPoint(new Point($month." - ".$year, $prodCount));
            $count++;

        }



        if($count!=0){
            $chart->setTitle("Months with highest no. of ".$imageName);

        }else{
            $chart->setTitle("No ".$productType." ".$imageName." in ".$year);
        }

        $chart->setDataSet($dataSet);
        //$chart->getPlot()->getPalette()->setLineColor(new Color(195, 171, 47));
        $chart->render("generatedimages/".$imageName.".png");

        oci_close($conn);
    }






function getQueryStatement($queryTypeDate,$year,$productType){
    global $inventory;

    if($productType == 'ALL'){
        $shippedProductStatement = "select shipped.year,shipped.month,shipped.prod from (
                                    select  extract(year from ".$queryTypeDate.") year,extract(month from ".$queryTypeDate.") month
                                    ,count(*) prod from products
                                    where inventory=".$inventory." and extract(year from ".$queryTypeDate.")=".$year." and ".$queryTypeDate." is not null
                                    group by extract(year from ".$queryTypeDate."), (extract(month from ".$queryTypeDate.") )
                                    order by  prod desc)  shipped  where rownum <=6";
    }else{
        $shippedProductStatement = "select shipped.year,shipped.month,shipped.prod from (
                                select  extract(year from ".$queryTypeDate.") year,extract(month from ".$queryTypeDate.") month
                                ,count(*) prod from products
                                where inventory=".$inventory." and product_type='".$productType."'
                                and extract(year from ".$queryTypeDate.")=".$year." and ".$queryTypeDate." is not null
                                group by extract(year from ".$queryTypeDate."), (extract(month from ".$queryTypeDate.") )
                                order by  prod desc)  shipped  where rownum <=6";

    }

    return $shippedProductStatement;
}



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

            <div id="firstcontainer" style="float: left;width: 1170px;height: 50px">

                <div id="left" style="float: left;width: 1170px;height: 50px;margin-left: 5%">
                    <form>
                        Product Type:
                        <select id="prodtype" name="prodtype" >
                            <option  value="all">All</option>
                            <option  value="laptop">Laptop</option>
                            <option value="printer">Printer</option>
                            <option value="desktop">Desktop</option>
                        </select>
                        &nbsp;
                        &nbsp;
                        &nbsp;

                        Year:
                        <input type="text"  placeholder="year in yyyy" style="width: 100px" name="year" value="<?php echo $year?>">
                        &nbsp;
                        <input type="submit" name="submit">
                    </form>

                </div>



            </div>
            <div id="secondcontainer" style="float: left;width: 1170px;height: 210px">
                <div id="left" style="float: left;width: 570px;height: 210px;border: solid;border-width: thin">
                    <img alt="Vertical bars chart" src="generatedimages/shipping.png" />
                </div>
                <div id="right" style="float: left;width: 570px;height: 210px;border: solid;border-width: thin">
                    <img alt="Vertical bars chart" src="generatedimages/refurbishment.png" />
                </div>

            </div>
            <div id="thirdcontainer" style="padding-left:25%;padding-top:0.5%;float: left;width: 1170px;height: 210px">
                <img alt="Vertical bars chart" src="generatedimages/entry.png" />

            </div>


        </div>

    </section>




</body>
</html>

<?php include('footer.php')?>



