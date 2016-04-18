<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 14-04-2016
 * Time: 16:31
 */
class QueryUtility{
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
         return   $conn  = oci_connect('mnvob','Pcprmogi%26','ufl');
     }
 }
?>