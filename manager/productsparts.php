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
    $b=array("LAPTOP","DESKTOP","PRINTER");

        $query1 =  "select count as partsno,product_type,count(*) as productcount from
        (select count(*) as count,p.product_id,p.product_type
     from refurbishes r,products p where r.product_id=p.product_id and inventory=".$inventory."
     group by p.product_id,p.product_type) group by product_type,count order by product_type";






    ///////

    $desktopMap = array();
    $printerMap = array();
    $laptopMap = array();

    $result1 = $qUtility->runQuery($conn, $query1);
    while(($row = oci_fetch_array($result1,OCI_BOTH))!=null){
        $productType = $row['PRODUCT_TYPE'];
        if($productType == "LAPTOP"){
            $laptopMap[$row['PARTSNO']] = $row['PRODUCTCOUNT'];

        }
        if($productType == "DESKTOP"){
            $desktopMap[$row['PARTSNO']] = $row['PRODUCTCOUNT'];

        }
        if($productType == "PRINTER"){
            $printerMap[$row['PARTSNO']] = $row['PRODUCTCOUNT'];

        }
    }

    createLaptopChart();
    createDesktopChart();
    createPrinterChart();




    function createLaptopChart(){
        global $laptopMap;
        $chart = new PieChart(530,230);
        $dataSet = new XYDataSet();

        foreach($laptopMap as $partno=>$prodCount){
            $dataSet->addPoint(new Point($partno."PART( ".$prodCount." )", $prodCount));
        }

        renderGraph($dataSet,$chart,"LAPTOP");
    }

    function createDesktopChart(){
        global $desktopMap;
        $chart = new PieChart(530,230);
        $dataSet = new XYDataSet();

        foreach($desktopMap as $partno=>$prodCount){
            $dataSet->addPoint(new Point($partno."PART( ".$prodCount." )", $prodCount));
        }

        renderGraph($dataSet,$chart,"DESKTOP");
    }


    function createPrinterChart(){
        global $printerMap;
        $chart = new PieChart(530,230);
        $dataSet = new XYDataSet();

        foreach($printerMap as $partno=>$prodCount){
            $dataSet->addPoint(new Point($partno."PART( ".$prodCount." )", $prodCount));
        }

        renderGraph($dataSet,$chart,"PRINTER");
    }





    function renderGraph($dataSet,$chart,$title){
        $chart->setDataSet($dataSet);
        //$chart->getPlot()->getPalette()->setLineColor(new Color(195, 171, 47));
        $chart->setTitle($title." CATEGORY");
        $chart->render("generatedimages/".$title."1.png");
    }

    /////


/*
    $result1 = $qUtility->runQuery($conn, $query1);
     $chart = new PieChart(530,230);
     $dataSet = new XYDataSet();
    $previous='DESKTOP';
    while(($row = oci_fetch_array($result1,OCI_BOTH))!=null){
            if($row[1]!=$previous)
            {
                $chart->setDataSet($dataSet);
                //$chart->getPlot()->getPalette()->setLineColor(new Color(195, 171, 47));
                $chart->setTitle($previous);
                $chart->render("images/".$previous."1.png");
                 $chart = new PieChart(530,230);
                $dataSet = new XYDataSet();
            }
        if($row[1]=='LAPTOP')
        {      echo "laptop".$row[2];
            $dataSet->addPoint(new Point($row[0]."PART", $row[2]));
        }
        elseif($row[1]=='DESKTOP')
        {
            $dataSet->addPoint(new Point($row[0]."PART", $row[2]));
        }else{
            $dataSet->addPoint(new Point($row[0]."PART", $row[2]));
            echo"printer  ";
            $chart->setDataSet($dataSet);
            //$chart->getPlot()->getPalette()->setLineColor(new Color(195, 171, 47));
            $chart->setTitle($previous);
           $chart->render("images/".$previous."1.png");
        }
      $previous=$row[1];


    }*/





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

                <div id="left" style="float: left;width: 1170px;height: 50px;margin-left: 25%">
      <h3 style="color: #0069d3" ><u><b> Statistics of Product Refurbishment with number of replaced parts</b></u></h3>

                </div>

            </div>
            <div id="secondcontainer" style="float: left;width: 1170px;height: 210px">
                <div id="left" style="float: left;width: 570px;height: 210px;border: solid;border-width: 0px">
                    <img alt="Vertical bars chart" src="generatedimages/DESKTOP1.png" />
                </div>
                <div id="right" style="text-align=center;float: right;width: 570px;height: 210px;border: solid;border-width: 0px">
                    <img alt="Vertical bars chart" src="generatedimages/LAPTOP1.png" />
                </div>

            </div>
            <div id="thirdcontainer" style="padding-left:25%;text-align=center;padding-top:5%;float: left;width: 1170px;height: 210px">
                <img alt="Vertical bars chart" src="generatedimages/PRINTER1.png" />

            </div>


        </div>

    </section>
    </body