<?php 

require_once("index.php");


$order = new Order();

$request = $_SERVER["REQUEST_METHOD"];

switch ($request) {
   case 'GET':
        //get bill payment
        $tableId = $_GET["id"];
        $order->getBillPaymentOrder($tableId);
        break;
   case 'POST':
        //update order
        $arrParam = array();
        $arrParam['tablekey'] = $_POST["id"];        
        $arrParam['product'] = $_POST["product"];        
        $arrParam['qty'] = $_POST["qty"];        
        $arrParam['promo'] = $_POST["promo"];        
        $arrParam['qtypromo'] = $_POST["qty_promo"];        
        $order->addOrder($arrParam);
        break;
   default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}


?>