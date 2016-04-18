<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 16-04-2016
 * Time: 21:35
 */


session_start();


$inventory=217;

if(isset($_SESSION["sessionInventoryID"])) {
    $inventory = $_SESSION["sessionInventoryID"];
}
include('headernav.php');
include('managernav.php');
include('table&queryutility.php');
include "../libchart/classes/libchart.php";



$qUtility = new MyQueryUtility();
$conn = $qUtility->establishConnection();

$a=array(0,150,250,350,450,550,650);
$b=array("LAPTOP","DESKTOP","PRINTER");
$c=array();
for($b1=0;$b1<=2;$b1++) {
    $image = $b[$b1];
    $chart = new VerticalBarChart(500, 200);
    $dataSet = new XYDataSet();
    $i = 0;
    if ($b1 == 2) {
        $d2 = 6;
        $d1=2;
    } else {
        $d2 = 4;
        $d1=0;
    }
    for ($a1 = $d1; $a1 < $d2; $a1++) {

        $query1 = " select count(*) from
 (select sum1+sum2 as refurbprice from
 (select price as sum1,product_id as p1 from products where inventory=" . $inventory . " and
  refurbished_date is not null and product_type='" . $b[$b1] . "'),
 (select sum(price) as sum2,product_id as p2 from refurbishes r,parts p where r.part_id=p.part_id group by product_id) where p1=p2)
 where refurbprice between " . $a[$a1] . " and " . $a[$a1 + 1];

        $query2 = " select count(*) from
 (select sum1+sum2 as refurbprice from
 (select price as sum1,product_id as p1 from products where inventory=" . $inventory . " and
  shipped_date is not null and product_type='" . $b[$b1] . "'),
 (select sum(price) as sum2,product_id as p2 from refurbishes r,parts p where r.part_id=p.part_id group by product_id) where p1=p2)
 where refurbprice between " . $a[$a1] . " and  " . $a[$a1 + 1];



        $result1 = $qUtility->runQuery($conn, $query1);
        $result2 = $qUtility->runQuery($conn, $query2);
        if (($row1 = oci_fetch_array($result1, OCI_BOTH)) != null) {
             $count1 = $row1[0];
         }
         if (($row2 = oci_fetch_array($result2, OCI_BOTH)) != null) {
             $count2 = $row2[0];
         }
/*
        if(($count1==0)||($count2==0))
        {
            $c[$i]=0;
        }else*/
        if($count1!=0){
            $c[$i] = intval(($count2/$count1) * 100);
      //  }

             $dataSet->addPoint(new Point($a[$a1] . " - " . $a[$a1 + 1], $c[$i]));
             $i++;}


    }
     $chart->setDataSet($dataSet);
    $chart->setTitle($b[$b1]);
     //$chart->getPlot()->getPalette()->setLineColor(new Color(195, 171, 47));
     $chart->render("generatedimages/".$image.".png");

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

            <div id="firstcontainer" style="text-align=center;float: left;width: 1170px;height: 50px">

                <div id="left" style="text-align=center;float: left;width: 1170px;height: 50px;margin-left: 25%">

                <h3 style="color: #0069d3"><b><u>Sales statistics for different categories in different price ranges</u></b></h3>
                </div>

            </div>
            <div id="secondcontainer" style="float: left;width: 1170px;height: 210px">
                <div id="left" style="float: left;width: 570px;height: 210px;border: solid;border-width: thin">
                    <img alt="Vertical bars chart" src="generatedimages/LAPTOP.png" />
                </div>
                <div id="right" style="float: left;width: 570px;height: 210px;border: solid;border-width: thin">
                    <img alt="Vertical bars chart" src="generatedimages/DESKTOP.png" />
                </div>

            </div>
            <div id="thirdcontainer" style="padding-left:25%;text-align=center;padding-top:5%;float: left;width: 1170px;height: 210px">
                <img alt="Vertical bars chart" src="generatedimages/PRINTER.png" />

            </div>


        </div>

    </section>
</body>