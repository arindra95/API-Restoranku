<?php

class Order extends BaseClass {
    public function __construct() {
        
        $this->tableName = 'product';
        $this->tableCategory = 'category';
        $this->tableVariant = 'variant';    
        $this->tableOrder = 'sales_order';    
        $this->tableOrderDetail = 'order_detail';    
        $this->tableOrderPromoDetail = 'order_promo_detail';    
        $this->tableDiningTable = 'dining_table';    
        $this->tablePromotion = 'promo';    
        $this->tablePromotionDetail = 'promo_detail';    
        $this->tableStationPrinter = 'station_printer';    

    }

    function getQuery(){

        $sql = ' select 
                    '.$this->tableName.'.*,
                    '.$this->tableCategory.'.name as categoryname,
                    '.$this->tableVariant.'.name as variantname
                from
                    '.$this->tableName.'
                        left join '.$this->tableCategory.' on '.$this->tableName.'.categorykey = '.$this->tableCategory.'.pkey
                        left join '.$this->tableVariant.' on '.$this->tableName.'.variantkey = '.$this->tableVariant.'.pkey
                where 
                    '.$this->tableName.'.statuskey = 1
        ';


        $rs = $this->doQuery($sql);

        return $rs;

    }

    function addOrder($arrParam){
        $tableKey = $arrParam['tablekey'];

        $sql = 'insert into '.$this->tableOrder.' (pkey,tablekey) values ("", '.$tableKey.')';

        $rs = $this->execute($sql);

        $arrResponse = array();
        $arrResponse['valid'] = $rs['valid'];
        $arrResponse['message'] = $rs['message'];

        if($rs['valid']){

            $arr = array();
            $arr['refkey'] = $rs['insertId'];
            $arr['productkey'] = $arrParam['product'];
            $arr['qty'] = $arrParam['qty'];
            $arr['promokey'] = $arrParam['promo'];
            $arr['qtypromo'] = $arrParam['qtypromo'];

            $this->addOrderDetail($arr);
            $this->addOrderPromoDetail($arr);

            $response = $this->getResponseProductByPrinter($arr);
            $arrResponse['data'] = $response;

        }else{
            $arrResponse['data'] = "";
        }
        
        echo json_encode($arrResponse);
    }

    function addOrderDetail($arr){
        $refKey = $arr['refkey'];
        $promoKey = $arr['promokey'];
        $qtyPromo = $arr['qtypromo'];


        //get product price
        $rsProductCol = $this->getQuery();
        $rsProductCol = array_column($rsProductCol,null,'pkey');


        $arrOrder = array();
        for($i=0;$i<count($arr['productkey']);$i++){

                $productKey = $arr['productkey'][$i];
                $qtyProduct = $arr['qty'][$i];

                $rsProduct = $rsProductCol[$productKey];
                $priceProduct = $rsProduct['price'];
                $amountProduct = $qtyProduct * $priceProduct;

                $sql = 'insert 
                into 
                    '.$this->tableOrderDetail.' 
                    (   refkey,
                        qty,
                        productkey,
                        price,
                        amount
                    ) 
                values 
                    (
                        '.$this->paramString($refKey).',
                        '.$this->paramString($qtyProduct).',
                        '.$this->paramString($productKey).',
                        '.$this->paramString($priceProduct).',
                        '.$this->paramString($amountProduct).'
                    )';

                $this->execute($sql);

        }
        
    }

    function addOrderPromoDetail($arrParam){
        $refKey = $arrParam['refkey'];
        $promoKey = $arrParam['promokey'];
    
        //get product from promo detail
        $rsPromo = $this->getPromo($promoKey);

        $qtyPromo = $arrParam['qtypromo'];


            $pricePromo = $rsPromo[0]['price'];
            $amountPromo = $qtyPromo * $pricePromo;

            $sql = 'insert 
                        into 
                            '.$this->tableOrderPromoDetail.' 
                            (   refkey,
                                qty,
                                promokey,
                                price,
                                amount
                            ) 
                        values 
                            (
                                '.$this->paramString($refKey).',
                                '.$this->paramString($qtyPromo).',
                                '.$this->paramString($promoKey).',
                                '.$this->paramString($pricePromo).',
                                '.$this->paramString($amountPromo).'
                            )';

            $this->execute($sql);

    }

    function getOrderPromoDetailProduct($pkey){


        $sql = ' select 
                    '.$this->tablePromotionDetail.'.productkey ,
                    '.$this->tableName.'.name as productname,
                    '.$this->tableName.'.printerkey,
                    '.$this->tableStationPrinter.'.name as printername,
                    '.$this->tableOrderPromoDetail.'.qty

                from
                    '.$this->tableOrderPromoDetail.',
                    '.$this->tableName.'
                        left join '.$this->tableStationPrinter.' on '.$this->tableName.'.printerkey = '.$this->tableStationPrinter.'.pkey,
                    '.$this->tablePromotionDetail.',
                    '.$this->tablePromotion.'

                where 
                    '.$this->tableOrderPromoDetail.'.refkey = '.$this->paramString($pkey).' and
                    '.$this->tablePromotionDetail.'.productkey = '.$this->tableName.'.pkey and
                    '.$this->tablePromotionDetail.'.refkey = '.$this->tablePromotion.'.pkey and
                    '.$this->tableOrderPromoDetail.'.promokey = '.$this->tablePromotion.'.pkey
            ';

        $rs = $this->doQuery($sql);
    

        return $rs;
    }

    function getOrderDetailProduct($pkey){


        $sql = ' select 
                    '.$this->tableOrderDetail.'.productkey,
                    '.$this->tableName.'.name as productname,
                    '.$this->tableName.'.printerkey,
                    '.$this->tableStationPrinter.'.name as printername,
                    '.$this->tableOrderDetail.'.qty
                from
                    '.$this->tableOrderDetail.',
                    '.$this->tableName.'
                        left join '.$this->tableStationPrinter.' on '.$this->tableName.'.printerkey = '.$this->tableStationPrinter.'.pkey


                where 
                    '.$this->tableOrderDetail.'.refkey = '.$this->paramString($pkey).' and
                    '.$this->tableOrderDetail.'.productkey = '.$this->tableName.'.pkey
            ';

        $sql .= 'group by productkey';
        $rs = $this->doQuery($sql);
    
        // var_dump($rs);

        return $rs;
    }

    function getResponseProductByPrinter($arr){
        $pkey = $arr['refkey'];

        $rsOrderDetail = $this->getOrderDetailProduct($pkey);
        $rsOrderPromoDetail = $this->getOrderPromoDetailProduct($pkey);
        $arrOrderDetail = array_merge($rsOrderDetail,$rsOrderPromoDetail);

        $arrPrinterByProduct = $this->reindexCollection($arrOrderDetail,'printerkey');

        return $arrPrinterByProduct;
    }

    function getStationPrinter($pkey = ''){
        $sql = ' select 
                    '.$this->tableStationPrinter.'.*
                from
                    '.$this->tableStationPrinter.'
                where
                    1 = 1;
                ';

            if(!empty($pkey)){
                $sql .= ' and '.$this->tableStationPrinter.'.pkey = '.$this->paramString($pkey);

            }

            $rs = $this->doQuery($sql);

            return $rs;
    }

    function getDetailProductPromo($refkey){
        $sql = ' select 
                    '.$this->tablePromotionDetail.'.productkey,
                    '.$this->tablePromotion.'.price
                from
                    '.$this->tablePromotion.',
                    '.$this->tablePromotionDetail.'
                where 
                    '.$this->tablePromotion.'.pkey = '.$this->paramString($refkey).' and
                    '.$this->tablePromotion.'.pkey = '.$this->tablePromotionDetail.'.refkey
            ';


            $rs = $this->doQuery($sql);

            return $rs;
    }

    function getPromo($pkey = ''){

        $sql = ' select 
                '.$this->tablePromotion.'.*
            from
                '.$this->tablePromotion.'
            where
                1 = 1
            ';

        if(!empty($pkey)){
            $sql .= ' and '.$this->tablePromotion.'.pkey = '.$this->paramString($pkey);
        }
        $rs = $this->doQuery($sql);

        return $rs;

}

    function getOrder($pkey = '',$tablekey = ''){

            $sql = ' select 
                    '.$this->tableOrder.'.*
                from
                    '.$this->tableOrder.'
                where
                    1 = 1
                ';

            if(!empty($pkey)){
                $sql .= ' and '.$this->tableOrder.'.pkey = '.$this->paramString($pkey);

            }

            if(!empty($tablekey)){
                $sql .= ' and '.$this->tableOrder.'.tablekey = '.$this->paramString($tablekey);

            }

            $rs = $this->doQuery($sql);

            return $rs;

    }
    
    function getBillPaymentOrder($tablekey){
        //diambil berdasarkan pkey dining table dimana ini merupakan NO MEJA 1
        $rsOrder = $this->getOrder('',$tablekey);
        //diambil dari index pertama karena hanya satu order
        $orderKey = $rsOrder[0]['pkey'];

        $rsOrderPromo = $this->getOrderPromoDetail($orderKey);
        $rsOrderNonPromo = $this->getOrderNonPromoDetail($orderKey);
        
        $arrOrderDetail = array_merge($rsOrderPromo,$rsOrderNonPromo);

        echo  json_encode($arrOrderDetail);
    }

    function getOrderNonPromoDetail($orderKey){

            $sql = ' select 
                        '.$this->tableOrderDetail.'.productkey,
                        '.$this->tableName.'.name as productname,
                        '.$this->tableOrderDetail.'.qty,
                        '.$this->tableOrderDetail.'.price,
                        '.$this->tableOrderDetail.'.amount
                    from
                        '.$this->tableOrderDetail.',
                        '.$this->tableName.'
                    where 
                        '.$this->tableOrderDetail.'.refkey = '.$this->paramString($orderKey).' and
                        '.$this->tableOrderDetail.'.productkey = '.$this->tableName.'.pkey
                ';
    
                    

            $rs = $this->doQuery($sql);
    
            return $rs;
    }

    function getOrderPromoDetail($orderKey){

        $sql = ' select 
                    '.$this->tableOrderPromoDetail.'.promokey,
                    '.$this->tablePromotion.'.name as promoname,
                    '.$this->tableOrderPromoDetail.'.qty,
                    '.$this->tableOrderPromoDetail.'.price,
                    '.$this->tableOrderPromoDetail.'.amount
                from
                    '.$this->tableOrderPromoDetail.',
                    '.$this->tablePromotion.'
                where 
                    '.$this->tableOrderPromoDetail.'.refkey = '.$this->paramString($orderKey).' and
                    '.$this->tableOrderPromoDetail.'.promokey = '.$this->tablePromotion.'.pkey
            ';
            

        $rs = $this->doQuery($sql);



        return $rs;

    }



}



?>