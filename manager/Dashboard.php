<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 13-04-2016
 * Time: 08:53
 */



session_start();


$inventory=217;


if(isset($_SESSION["sessionInventoryID"])){
    $inventory = $_SESSION["sessionInventoryID"];
}

include('headernav.php');
//include('utility.php');
include('managernav.php');
include('table&queryutility.php');
include "../libchart/classes/libchart.php";



$utility =  new MyQueryUtility();
$conn = $utility->establishConnection();


global $fromdate;
global $todate;


 if(!isset($_POST["submit"]))
 {
     $fromdate = '1/10/2015';
     $todate = '1/2/2016';
 }

/*function getProducts2($fromdate,$todate){
    global $inventory,$conn;
    $utility =  new QueryUtility();
   // $conn = $utility->establishConnection();

    $countQuery = "select count(*) from products where product_status='Refurbished'
                      and entry_date>TO_DATE('" .$fromdate ."', 'dd/mm/yyyy') and shipped_date is not null
                       and inventory=".$inventory. "and entry_date < TO_DATE('" .$todate ."', 'dd/mm/yyyy')";


    $result = $utility->runQuery($conn,$countQuery);
    $count = 0;
    if(($row = oci_fetch_array($result, OCI_BOTH)) !=null ){
        $count =  $row[0];
    }


    return $count;
}*/



    function renderchart($pos){


        if(!isset($_POST["submit"])) {
            global $fromdate, $todate;

            if ($pos == 1) {

                createChart1($fromdate, $todate);
            }
           if ($pos == 2) {
                createChart2($fromdate, $todate);
            }
            if ($pos == 3) {
                createChart3($fromdate, $todate);
            }
            if ($pos == 4)
            {
                createChart4($fromdate, $todate);
            }

        }else {


            //$_GET["SUBMIT"]; $age = $_POST['age']
            //  global $fromdate,$todate;
            $fromdate = $_POST['fromdate'];
            $todate = $_POST['todate'];
            if ($pos == 1) {

                createChart1($fromdate, $todate);
            }
            if ($pos == 2) {
                createChart2($fromdate, $todate);
            }
            if ($pos == 3) {
                createChart3($fromdate, $todate);
            }
            if ($pos == 4) {
                createChart4($fromdate, $todate);

            }


        }
    }


function createChart1($fromdate,$todate){


    global $inventory,$conn,$utility ;
    //$utility =  new QueryUtility();
    //$conn = $utility->establishConnection();

    $countQuery1 = "select count(*) from products where product_status='Refurbished'
                      and entry_date>TO_DATE('" .$fromdate ."', 'dd/mm/yyyy') and inventory=".$inventory.
        "and entry_date < TO_DATE('" .$todate ."', 'dd/mm/yyyy')";
    $countQuery2= "select count(*) from products where product_status='Non-Refurbished'
                      and entry_date>TO_DATE('" .$fromdate ."', 'dd/mm/yyyy') and inventory=".$inventory.
        "and entry_date < TO_DATE('" .$todate ."', 'dd/mm/yyyy')";




    $result1 = $utility->runQuery($conn,$countQuery1);
    $result2 = $utility->runQuery($conn,$countQuery2);
    $count1=0;
    $count2=0;
    if(($row = oci_fetch_array($result1, OCI_BOTH)) !=null ){
            $count1 =  $row[0];
        }
        if(($row = oci_fetch_array($result2, OCI_BOTH)) !=null ){
            $count2 =  $row[0];
        }

 // create chart here

    $chart = new PieChart(530,230);

    $dataSet = new XYDataSet();
    $dataSet->addPoint(new Point("Refurbished (" .$count1. ")", $count1));
    $dataSet->addPoint(new Point("Non-Refurbished (" .$count2. ")", $count2));

    $chart->setDataSet($dataSet);

    $chart->setTitle("Refurbished/Non-Refurbished - ".$fromdate." to ".$todate);
    $chart->render("generatedimages/demo1.png");
}

function createChart2($fromdate,$todate)
{
        global $inventory,$conn,$utility;
       // $utility =  new QueryUtility();
        //$conn = $utility->establishConnection();

        $countQuery1 = "select count(*) from products where product_status='Refurbished'
                      and entry_date>TO_DATE('" .$fromdate ."', 'dd/mm/yyyy') and shipped_date is not null
                       and inventory=".$inventory. "and entry_date < TO_DATE('" .$todate ."', 'dd/mm/yyyy')";

        $countQuery2 = "select count(*) from products where product_status='Refurbished'
                      and entry_date>TO_DATE('" .$fromdate ."', 'dd/mm/yyyy') and shipped_date is  null
                       and inventory=".$inventory. "and entry_date < TO_DATE('" .$todate ."', 'dd/mm/yyyy')";



        $result1 = $utility->runQuery($conn,$countQuery1);
        $result2 = $utility->runQuery($conn,$countQuery2);
        $count1 = 0;
         $count2=0;
        if(($row = oci_fetch_array($result1, OCI_BOTH)) !=null ){
            $count1 =  $row[0];
        }
        if(($row = oci_fetch_array($result2, OCI_BOTH)) !=null ){
            $count2 =  $row[0];
        }

    // create chart here

    $chart = new PieChart(530,230);

    $dataSet = new XYDataSet();
    $dataSet->addPoint(new Point("Shipped (" .$count1. ")", $count1));
    $dataSet->addPoint(new Point("Non-Shipped (" .$count2. ")", $count2));

    $chart->setDataSet($dataSet);

    $chart->setTitle("Shipped/Non-Shipped  ".$fromdate." to ".$todate);
    $chart->render("generatedimages/demo2.png");
}


function createChart3($fromdate,$todate)
{
    global $inventory,$conn,$utility;
   // $utility =  new QueryUtility();
    //$conn = $utility->establishConnection();
    $chart = new PieChart(530,230);
    $dataSet = new XYDataSet();
    $product_type = array('PRINTER', 'LAPTOP', 'DESKTOP');
    for ($x = 0; $x <= 2; $x++) {
        $countQuery = "select count(*) from products where product_status='Refurbished'
                      and entry_date>TO_DATE('" . $fromdate . "', 'dd/mm/yyyy') and product_type ='" . $product_type[$x] . "'
                       and inventory=" . $inventory . "and entry_date < TO_DATE('" . $todate . "', 'dd/mm/yyyy')";




        $result = $utility->runQuery($conn, $countQuery);
        $count = 0;
        if (($row = oci_fetch_array($result, OCI_BOTH)) != null) {
            $count = $row[0];
        }
        $dataSet->addPoint(new Point("".$product_type[$x]." (" . $count . ")", $count));
    }

    // create chart here
    $chart->setDataSet($dataSet);

    $chart->setTitle("Refurbished Laptops/Desktops/Printers ".$fromdate." to ".$todate);
    $chart->render("generatedimages/demo3.png");
}


function createChart4($fromdate,$todate)
{
    global $inventory,$conn,$utility ;
    //$utility =  new QueryUtility();
    //$conn = $utility->establishConnection();
    $chart = new PieChart(530,230);
    $dataSet = new XYDataSet();
    $product_type = array('PRINTER', 'LAPTOP', 'DESKTOP');
    for ($x = 0; $x <= 2; $x++) {
        $countQuery = "select count(*) from products where shipped_date is not null
                      and entry_date>TO_DATE('" . $fromdate . "', 'dd/mm/yyyy') and product_type ='" . $product_type[$x] . "'
                       and inventory=" . $inventory . "and entry_date < TO_DATE('" . $todate . "', 'dd/mm/yyyy')";
        $result = $utility->runQuery($conn, $countQuery);
        $count = 0;
        if (($row = oci_fetch_array($result, OCI_BOTH)) != null) {
            $count = $row[0];
        }
        $dataSet->addPoint(new Point("".$product_type[$x]." (" . $count . ")", $count));
    }

    // create chart here
    $chart->setDataSet($dataSet);

    $chart->setTitle("Shipped Laptops/Desktops/Printers ".$fromdate." to ".$todate);
    $chart->render("generatedimages/demo4.png");
}
?>



<body>

<section>
    <div id="largebox" style="float: left;width: 1200px;height: 500px">
        <div id="searchbox" style="float: left;width: 1195px;height:50px;">
            <form action= "Dashboard.php" " method="post">
                <b> From:</b>&nbsp;
                <input type="text" name="fromdate" value="<?php echo $fromdate ?>">&nbsp;
                 <b>To:</b>&nbsp;
                <input type="text" name="todate" value="<?php echo $todate ?>">&nbsp;


                <input type="submit" name="submit">
            </form>

        </div>
        <div id="stats" style="float: left;width: 1200px;height: 450px">
            <div id="charts" style="float: left;width: 1000px;height: 450px">
                <div id="chartrow1" style="float: left;width:1000px;height: 225px">
                    <div id="chartcolumn1" style="border: 2px solid black;float: left;width: 500px;height: 225px">
                      <?php
                      $pos=1;
                      renderchart($pos);
                      ?>
                      <img alt="Pie chart"  src="generatedimages/demo1.png" style="border: 0px solid gray;"/>

                    </div>
                    <div id="chartcolumn2" style="border: 2px solid black;float: left;width: 490px;height: 225px">
                        <?php
                        $pos=2;
                        renderchart($pos);
                        ?>
                        <img alt="Pie chart"  src="generatedimages/demo2.png" style="border: 0px solid gray;"/>
                    </div>
                </div>
                <div id="chartrow2" style="float: left;width:1000px;height:225px">
                    <div id="chartcolumn1" style="border: 2px solid black;float: left;width: 500px;height: 225px">
                        <?php
                        $pos=3;
                        renderchart($pos);
                        ?>
                        <img alt="Pie chart"  src="generatedimages/demo3.png" style="border: 0px solid gray;"/>

                    </div>
                    <div id="chartcolumn2" style="border: 2px solid black;float: left;width: 490px;height: 225px">
                        <?php
                        $pos=4;
                        renderchart($pos);
                        ?>
                        <img alt="Pie chart"  src="generatedimages/demo4.png" style="border: 0px solid gray;"/>
                    </div>
                </div>
            </div>
            <div id="perfmeasures" style="padding-top=2%;padding-left=5%;border: 2px solid black;float: left;width: 190px;height: 450px">
                <?php
                global $inventory,$conn,$utility;?>
               <h3 style="color: #0069d3;padding-left: 2px"><u> Recent Half-yearly Stats: </u></h3><br>

              <?php
                $countQuery1 = "select (count1/count2)*(2/3) from (select COUNT(*)as count1 from products
                where refurbished_date >ADD_MONTHS(sysdate,-6) and inventory=".$inventory."),
                (select count(*) as count2 from employee where emp_type='Technician' and works_for=".$inventory.")";

                $countQuery2="select (count1/count2)*100 from (select COUNT(*)as count1 from products where
                            shipped_date >ADD_MONTHS(sysdate,-6) and inventory=".$inventory."),(select COUNT(*)as count2
                            from products where  refurbished_date >ADD_MONTHS(sysdate,-6) and inventory=".$inventory.")";


                $result1 = $utility->runQuery($conn,$countQuery1);
                $result2 = $utility->runQuery($conn,$countQuery2);
                $count1=0;
                $count2=0;

                if(($row = oci_fetch_array($result1, OCI_BOTH)) !=null ){
                    $count1 =  intVal($row[0]);
                }
                if(($row = oci_fetch_array($result2, OCI_BOTH)) !=null ){
                    $count2 =  intVal($row[0]);
                }


                ?>
                <h3 style="color:#0069d3">Performance: </h3><b><?php echo " ".$count1."%"?></b>


                <h3  style="color:#0069d3">Load Factor: </h3><b><?php echo " ".$count2."%" ?></b>


            </div>
        </div>

        </div>
</section>

</body>
<?php
include('footer.php');
oci_close($conn);
?>
