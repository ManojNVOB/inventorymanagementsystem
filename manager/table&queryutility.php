<?php
/**
 * Created by PhpStorm.
 * User: akarpm
 * Date: 4/9/2016
 * Time: 9:19 PM
 */


    class MyTableUtility
    {
        /**
         * creates table with passed header and data cells values
         * @param $headers - header of the table
         * @param $data_cells - cells having values
         */
        function createTable($headers, $data_cells){

            ?>

            <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
            <html>
            <head>
                <link rel="stylesheet" href="css/table.css" type="text/css"/>
            </head>

            <body >
            <table class="CSS_Table_Example" style="background-color:#4affed; margin-left: 15%;width: 600px" border="1">
                <tr>
                    <?php foreach ($headers as $header): ?>
                        <th><?php echo $header; ?></th>
                    <?php endforeach; ?>
                </tr>
                <?php foreach ($data_cells as $data_cell): ?>
                    <tr>
                        <?php $productid=$data_cell[0];?>
                        <?php for ($k = 0; $k < count($headers); $k++):
                            ?>
                            <?php if($k==1){?>
                                <td>
                                    <form action="product_details.php" method="post">
                                        <input name=product_id type=hidden value='<?php echo $productid; ?>'>
                                        <input style="background-color:#4affed; " type=submit name=submit value=<?php echo $data_cell[$k]; ?>>
                                    </form>

                                </td>
                            <?php } else {?>
                                <td>
                                    <?php echo $data_cell[$k]; ?>
                                </td>
                            <?php }?>
                        <?php

                        endfor; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
            </body>
            </html>

        <?php
        }
        function createTable1($headers, $data_cells){

            ?>

            <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
            <html>
            <head>
                <link rel="stylesheet" href="css/table.css" type="text/css"/>
            </head>

            <body >
            <table class="CSS_Table_Example" style="background-color:#4affed; margin-left: 10%;width: 500px" border="1">
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

                    <?php

                    endfor; ?>
                </tr>
            <?php endforeach; ?>
            </table>
            </body>
            </html>

        <?php
        }



    }



    class MyQueryUtility{
        /**
         * runs a $query on passed connection object
         * @param $conn - connection object
         * @param $query - query string
         * @return resource - executed resource
         */
        function runQuery($conn,$query){
            $stid = oci_parse($conn, $query);
            oci_execute($stid);

            return $stid;
        }

        function establishConnection(){
            return   $conn  = oci_connect('rpmishra','Psid$8575','ufl');
        }
    }


?>