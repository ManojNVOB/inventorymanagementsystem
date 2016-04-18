<?php

include('headernav.php');
include("managernav.php");
include("table&queryutility.php");

$qUtility = new MyQueryUtility();
$conn = $qUtility->establishConnection();
$product_id = $_POST['product_id'];

    $query1="select location,org_name,price,entry_date,manufac_date,RAMINGB,HDDINGB,PROCESSOR,SCREEN_SIZE,BATTERY,
                    KEYBOARD,PRINT_MEMORY,CATRIDGE,PRINT_HARD_DRIVE,PRINT_HEAD,SCANNER,RESOLUTION,OPTICAL_DRIVE,product_type,product_name,
                    modelno from products,organization,specification
                    where product_id=".$product_id." and org_id=sold_by and specification=spec_id" ;
    $query2="select (sum1+sum2) as totalprice from (select sum(price) as sum1 from parts where part_id in
                    (select part_id from refurbishes where product_id=".$product_id.")),
                    (select price as sum2 from products where product_id=".$product_id.")";

        $result1 = $qUtility->runQuery($conn,$query1);
        $result2 = $qUtility->runQuery($conn,$query2);
////check for possible parts assigned while refurbishment of this product////
            if(($row = oci_fetch_array($result1,OCI_BOTH)) !=null)
            {
                $prod_type=$row[18];
                $product_name=$row[19];
                $modelno =$row[20];
                    if($prod_type == 'LAPTOP' or $prod_type == 'DESKTOP' ){
                        if($prod_type == 'LAPTOP'){
                            $battery1=$battery=$row[9];
                        }
                        else if($prod_type='DESKTOP')
                        {
                            $optical_drive1=$optical_drive=$row[17];
                        }
                        $ram1= $ram =$row[5];
                        $hdd1=$hdd=$row[6];
                        $processor1= $processor=$row[7];
                        $screensize1=$screensize=$row[8];
                        $keyboard1= $keyboard=$row[10];
                        $resolution1= $resolution=$row[16];
                    }
                    else if($prod_type == 'PRINTER'){
                        $printmemory1= $printmemory=$row[11];
                        $catridge1=  $catridge=$row[12];
                        $printhdd1=$printhdd=$row[13];
                        $printhead1= $printhead=$row[14];
                        $scanner1= $scanner=$row[15];
                    }
                        //ECHO $row[4];
                        $location=$row[0];
                        $org_name =$row[1];
                        $price=$row[2];
                        $entry_date=$row[3];
                        $manufac_date=$row[4];



                //$printmemory1= $printmemory=$row['PRINT_MEMORY'];

            }
            if(($row1 = oci_fetch_array($result2,OCI_BOTH)) !=null)
            {
                $refurbished_price=$row1[0];
            }

            $refurbish_prod_count_query = "select count(*) from refurbishes where product_id =  ".$product_id;
            $result = $qUtility->runQuery($conn,$refurbish_prod_count_query);

            $consumed_parts_map = array();
            if(($row2 = oci_fetch_array($result,OCI_BOTH)) !=null){
            $count = $row2[0];

                if($count != 0){
        $refurbish_prod_query = "select product_id,PART_ID from refurbishes where product_id =  ".$product_id;
        $result1 = $qUtility->runQuery($conn,$refurbish_prod_query);


        while(($row3 = oci_fetch_array($result1,OCI_BOTH)) !=null){
            $consumed_part_id = $row3[1];

            $consumed_part_query = "select part_name,main_property from parts where part_id =  ".$consumed_part_id;
            $consumed_part_result = $qUtility->runQuery($conn,$consumed_part_query);

            if(($row4 = oci_fetch_array($consumed_part_result,OCI_BOTH)) !=null){
                $mainProperty1 = $row4['MAIN_PROPERTY'];
                if(strpos($mainProperty1,"GB")) {
                    $mainProperty1 = substr($mainProperty1, 0, strpos($mainProperty1, "GB"));
                }
                if(strpos($mainProperty1,"MB")) {
                    $mainProperty1 = substr($mainProperty1, 0, strpos($mainProperty1, "MB"));
                }
                $consumed_parts_map[strtolower($row4['PART_NAME'])] = $mainProperty1;

            }

        }

    }

}
$ramstat=$hddstat=$procstat=$batstat= $keystat =$printhddstat=$printheadstat=$scannerstat=$printmemstat=$catridgestat='';

if (array_key_exists('ram', $consumed_parts_map)) {
    $ram = $consumed_parts_map['ram'];
    $ramstat='New';
}
if (array_key_exists('hdd', $consumed_parts_map)) {
    $hdd = $consumed_parts_map['hdd'];
    $hddstat='New';
}
if (array_key_exists('processor', $consumed_parts_map)) {
    $processor = $consumed_parts_map['processor'];
    $procstat='New';
}
if (array_key_exists('battery', $consumed_parts_map)) {
    $battery = $consumed_parts_map['battery'];
    $batstat='New';
}

if (array_key_exists('keyboard', $consumed_parts_map)) {
    $keyboard = $consumed_parts_map['keyboard'];
    $keystat='New';
}
if (array_key_exists('printhdd', $consumed_parts_map)) {
    $printhdd = $consumed_parts_map['printhdd'];
    $printhddstat='New';
}
if (array_key_exists('printhead', $consumed_parts_map)) {
    $printhead = $consumed_parts_map['printhead'];
    $printheadstat='New';
}
if (array_key_exists('scanner', $consumed_parts_map)) {
    $scanner = $consumed_parts_map['scanner'];
    $scannerstat='New';
}
if (array_key_exists('printmemory', $consumed_parts_map)) {
    $printmemory = $consumed_parts_map['printmemory'];
    $printmemstat='New';
}
if (array_key_exists('catridge', $consumed_parts_map)) {
    $catridge = $consumed_parts_map['catridge'];
    $catridgestat='New';
}



?>

<body>

<section>

    <div id="mainbox" style="padding-left:10%;float: left;width: 1200px;height: 550px">
        <div id="heading" style="vertical-align: middle;float: left;width: 1195px;height:50px;">

        <h2 style="color: #0069d3;padding-left: 25%"><b><u><?php echo $product_name." ".$modelno?></u></b></h2>


        </div>
           <div id="productdetails" style="float: left;width: 1195px;height: 500px">
            <div id="generalattributes" style="float: left;width: 590px;height: 450px">
                <div id="image" style="float: right;width: 590px;height: 225px">
                    <?php
                    if($prod_type=='LAPTOP') { ?>
                    <img style="vertical-align: middle;margin: 2px" src="images/delllaptop.jpg" alt="Inventory management" height="225" width="225" />
                    <?php
                    }elseif($prod_type=='DESKTOP')
                    {?>
                    <img style="vertical-align: middle;margin: 2px" src="images/desktop-computer1.jpg" alt="Inventory management" height="225" width="225" />
                    <?php
                    }else {?>
                    <img style="vertical-align: middle;margin: 2px" src="images/printer.jpg" alt="Inventory management" height="225" width="225" />
                    <?php } ?>
                </div>
                <div id="newspec" style="padding-top:10px ;float: right;width: 590px;height: 300px">
                   <?php
                   if($prod_type=='LAPTOP') { ?>
                      <h3 style="color: #0069d3">&nbsp;<u>New Specification:</u></h3>
                       <p>
                       &nbsp; <b><?php echo $ramstat;?> RAM:</b><?php echo $ram."GB" ;?>  <br> <br>
                       &nbsp; <b><?php echo $hddstat;?> HDD:</b><?php echo $hdd."GB" ;?> <br><br>
                       &nbsp; <b><?php echo $procstat;?> Processor:</b><?php echo $processor ;?> <br><br>
                       &nbsp; <b> Screen Size:</b> <?php echo $screensize; ?>  <br> <br>
                       &nbsp; <b><?php echo $batstat;?> Battery:</b><?php echo $battery; ?><br><br>
                       &nbsp; <b><?php echo $keystat;?> Keyboard:</b><?php echo $keyboard ;?><br><br>
                       &nbsp; <b>Resolution:</b><?php echo $resolution ;?><br>
                       </p>
                   <?php
                   }elseif($prod_type=='DESKTOP')
                   {?>
                       <h3 style="color: #0069d3">&nbsp;<u>New Specification:</u></h3>
                    <p>
                        &nbsp; <b><?php echo $ramstat;?> RAM:</b><?php echo $ram."GB"; ?>  <br> <br>
                        &nbsp; <b><?php echo $hddstat;?> HDD:</b><?php echo $hdd."GB" ;?> <br> <br>
                        &nbsp; <b><?php echo $procstat;?> Processor:</b><?php echo $processor; ?> <br> <br>
                        &nbsp; <b> Screen Size:</b> <?php echo $screensize; ?>  <br> <br>
                        &nbsp; <b>Optical Drive:</b><?php echo $optical_drive; ?><br> <br>
                        &nbsp; <b><?php echo $keystat;?> Keyboard:</b><?php echo $keyboard ;?><br> <br>
                        &nbsp; <b>Resolution:</b><?php echo $resolution; ?>
                    </p><?php
                   }else {?>
                       <h3 style="color: #0069d3">&nbsp;<u>New Specification:</u></h3>
                    <p>
                        &nbsp; <b><?php echo $catridgestat;?> Catridge:</b><?php echo $catridge ;?>  <br> <br>
                        &nbsp; <b><?php echo $printheadstat;?> Print head:</b><?php echo $printhead; ?> <br> <br>
                        &nbsp; <b><?php echo $scannerstat;?> Scanner:</b><?php echo $scanner ;?> <br> <br>
                        &nbsp; <b><?php echo $printhddstat;?> Hard Drive:</b><?php echo $printhdd."MB"; ?><br><br>
                        &nbsp; <b> <?php echo $printmemstat;?> Print Memory Size:</b> <?php echo $printmemory."MB"; ?> <br>


                    </p>
                    <?php } ?>

                </div>
                </div>
            <div id="specification" style="float: width: 595px;height: 450px">
                <div id="general details" style="float: left;width: 603px;height: 225px">
                    <h3 style="color: #0069d3">&nbsp;<u>General Attributes:</u></h3>
                    <p >
                        &nbsp; <b>Entry date:</b><?php echo $entry_date?>  <br> <br>
                        &nbsp; <b>Original Price:</b><?php echo $price?> <br> <br>
                        &nbsp; <b>Refurbished Price:</b><?php echo $refurbished_price?> <br> <br>
                        &nbsp; <b>Manufactured date:</b> <?php echo $manufac_date?>  <br> <br>
                        &nbsp; <b>Selling Organization:</b><?php echo $org_name?><br> <br>
                    </p>

                </div>
                <div id="old spec" style=" padding-top:10px;float: left;width: 603px;height: 225px">
                    <?php if($prod_type=='LAPTOP') { ?>
                        <h3 style="color: #0069d3">&nbsp;<u>Old Specification:</u></h3>
                        <p>
                        &nbsp; <b>RAM:</b><?php echo $ram1."GB" ?>  <br> <br>
                        &nbsp; <b>HDD:</b><?php echo $hdd1."GB" ?> <br><br>
                        &nbsp; <b>Processor:</b><?php echo $processor1 ?> <br><br>
                        &nbsp; <b> Screen Size:</b> <?php echo $screensize1 ?>  <br> <br>
                        &nbsp; <b>Battery:</b><?php echo $battery1 ?><br><br>
                        &nbsp; <b>Keyboard:</b><?php echo $keyboard1?><br><br>
                        &nbsp; <b>Resolution:</b><?php echo $resolution1 ?>
                        </p><?php
                    }elseif($prod_type=='DESKTOP')
                    {?>
                        <h3 style="color: #0069d3">&nbsp;<u>Old Specification:</u></h3>
                        <p>
                        &nbsp; <b>RAM:</b><?php echo $ram1."GB" ?>  <br><br>
                        &nbsp; <b>HDD:</b><?php echo $hdd1."GB" ?> <br><br>
                        &nbsp; <b>Processor:</b><?php echo $processor1 ?> <br><br>
                        &nbsp; <b> Screen Size:</b> <?php echo $screensize1 ?>  <br><br>
                        &nbsp; <b>Optical Drive:</b><?php echo $optical_drive1 ?><br><br>
                        &nbsp; <b>Keyboard:</b><?php echo $keyboard1 ?><br><br>
                        &nbsp; <b>Resolution:</b><?php echo $resolution1 ?>
                        </p><?php
                    }else {?>
                        <h3 style="color: #0069d3">&nbsp;<u>Old Specification:</u></h3>
                        <p>
                            &nbsp; <b>Catridge:</b><?php echo $catridge1 ?>  <br> <br>
                            &nbsp; <b>Print head:</b><?php echo $printhead1 ?> <br> <br>
                            &nbsp; <b>Scanner:</b><?php echo $scanner1 ?> <br> <br>
                            &nbsp; <b>Hard Drive:</b><?php echo $printhdd1."MB" ?> <br> <br>
                            &nbsp; <b> Print Memory Size:</b> <?php echo $printmemory1."MB" ?> <br>


                        </p>
                    <?php } ?>

                </div>
                </div>
        </div>

        </div>


</section>
