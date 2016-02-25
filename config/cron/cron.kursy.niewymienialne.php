<?php

/**
 * skrypt uruchamiany w cronie dodaje dane do tabli z kursami walut niewymienialnych (Tabela B)
 * @author Michal Kalkowksi <michal@silversite.pl> 
 * @version 1.0
 * @todo sprawdzic czy dziala w srode
 * @copyright 2009 SilverSite (silversite.pl)
 * @package waluty
 * @subpackage cron
 */

require('../../config/loader.php');

try{
    
//tablea B
    ini_set('max_execution_time',60);
    ini_set('auto_detect_line_endings', false);
    $oXML = new CMS_Core_Xml2Assoc();
    
    $oNbpFile = new CMS_Core_XmlNBP();
    
    $sNbpXmlFileB = $oNbpFile->getXmlName('b');
    if(!empty($sNbpXmlFileB)){
        
    
        $aXML = $oXML->parseFile('http://nbp.pl/Kursy/xml/'.$sNbpXmlFileB.'.xml',true);
        $oMaxDate = DS_Admin_Currency_History_IrredeemableMaxDate::getInstance();
        $aMaxDate = $oMaxDate->getData();
        
        if($aMaxDate[0]['max_date'] != $aXML['tabela_kursow'][0]['data_publikacji']){
            
            $oCurrencyHistoryLastDay = DS_Currency_History_IrredeemableByDate::getInstance($aMaxDate[0]['max_date']); 
            $aCurrencyHistoryLastDay = $oCurrencyHistoryLastDay->getData();
            
            $oTableNo = new DC_Admin_Currency_TableNo_Irredeemable();
            $aTableNo = array('table_date'=>$aXML['tabela_kursow'][0]['data_publikacji'],'table_no'=>$aXML['tabela_kursow'][0]['numer_tabeli']);
            $oTableNo->saveData($aTableNo);
            
            $oSaveCurrencyIrredeemable = new DC_Admin_Currency_Irredeemable();
            $oSaveCurrencyIrredeemable->truncateTabel();
            
            $oHistoryIrredeemable = new DC_Admin_Currency_History_Irredeemable();
            
            foreach($aXML['tabela_kursow'][0]['pozycja'] as $value){
                
                $oCurrency = DS_Currency_IdBySymbol::getInstance($value['kod_waluty'],true);
                $aCurrency = $oCurrency->getData();
                
                if(isset($aCurrency[0]['currency_id'])){
                    
                    $aData[$aCurrency[0]['currency_id']]['currency_id'] = $aCurrency[0]['currency_id'];
                    $value['kurs_sredni'] = str_replace(',','.',$value['kurs_sredni']);
                    $aData[$aCurrency[0]['currency_id']]['currency_rate'] = number_format($value['kurs_sredni'],4,'.','');
                    $aData[$aCurrency[0]['currency_id']]['currency_counter'] = $value['przelicznik'];
                    $aData[$aCurrency[0]['currency_id']]['currency_symbol'] = $value['kod_waluty'];    
                    $aData[$aCurrency[0]['currency_id']]['currency_date'] = $aXML['tabela_kursow'][0]['data_publikacji'];
                }
            }
            $aDataHistory = array();
            foreach($aCurrencyHistoryLastDay as $value){
                $aDataHistory[$value['currency_id']] = $value;
            }
            //przeliczenie zmiany kursu oraz zapis do bazy
            $aSaveData = array();
            foreach($aData as $value){
                $aSaveData[$value['currency_id']] = $value;
                if(isset($aDataHistory[$value['currency_id']])){
                    $aSaveData[$value['currency_id']]['currency_change_rate'] = number_format((($aSaveData[$value['currency_id']]['currency_counter'] * $aSaveData[$value['currency_id']]['currency_rate'] - $aDataHistory[$value['currency_id']]['currency_rate'] * $aDataHistory[$value['currency_id']]['currency_counter']) / ($aDataHistory[$value['currency_id']]['currency_rate'] * $aDataHistory[$value['currency_id']]['currency_counter'])) * 100,4,'.','');
                }else{
                    $aSaveData[$value['currency_id']]['currency_change_rate'] = 0;
                }
                $oSaveCurrencyIrredeemable->saveData($aSaveData[$value['currency_id']]);
                $oHistoryIrredeemable->saveData($aSaveData[$value['currency_id']]);
                
            }
        }
    }
    if(DEBUG_PROCESS) {
        $oDBC = CMS_Core_DBAccess::getInstance();
        echo '<div class="debug-box">' .$oDBC->getDebugQuery() .'</div>'; 
    }
}catch(Error $e){
    $e->getError();
}

?>