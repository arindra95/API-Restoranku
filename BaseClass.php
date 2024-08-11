<?php

class BaseClass  {

    //for select
    function doQuery($query= ''){
        global $dbCon;
        
        $result = $dbCon->query($query);

        echo $dbCon->error;
        $row =  mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $row;

    }

/*     function addData($arrParam = array()){
        global $dbCon;

        $arrFieldName = array();
        $arrValue = array();
        foreach($arrParam as $fieldKey => $value){
            array_push($arrFieldName,$fiedlKey);
            array_push($arrValue,$this->paramString($value));
        }

        $fieldName = implode(' ,',$arrFieldName);
        $value = implode(' ,',$arrValue);

        $sql = 'insert into '.$this->tableOrder.' ('.$fieldName.') values ('.$value.')';

        $rs = $this->execute($sql);

        return $rs;

    } */

    //for insert, update, delete
    function execute($query = ''){
        global $dbCon;

        $result =  $dbCon->query($query);

        $arrData = array();
        if($result){
            $arrData['valid'] = $result;
            $arrData['message'] = "Data Succesfuly Update";
            $arrData['insertId'] = $dbCon->insert_id;
        }else {
            $arrData['valid'] = $result;
            $arrData['message'] = "Data Failed Update";
            $arrData['insertId'] = 0;
        }

        return $arrData;

    }
    
    function paramString($str){

        global $dbCon;

        //prevent sql injection
        return $dbCon->real_escape_string($str);

    }

    
    function reindexCollection($arr, $key){

        $arrReturn = array();

            foreach($arr as $value )
            {
                $arrReturn[$value[$key]][] = $value;
            }
        return $arrReturn;

    } 
    

}

?>