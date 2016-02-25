<?php

/**
 * skryt ktory bedzie uruchamiany z crona aktualizacja (Tablea A)
 * @author Michal Kalkowksi <michal@silversite.pl> 
 * @company SilverSite (silversite.pl)
 * @version 1.3
 * @copyright 2009
 * @package waluty
 * @subpackage cron
 */
require('../../config/loader.php');
try{
    ini_set('max_execution_time',500000);
    ini_set('memory_limit',500000000);
    $oXML = new CMS_Core_Xml2Assoc();
    
    $aFile = file('http://www.nbp.pl/Kursy/xml/dir.txt');
    
    $i=0;
    
    $oHistory = new DC_Admin_Currency_History_CurrentDayRate();
    $oHistoryIrredeemable = new DC_Admin_Currency_History_Irredeemable();
    $oHistorySellBuy = new DC_Admin_Currency_History_SellBuy();
                        
    $oIrredeemableTableNo = new DC_Admin_Currency_TableNo_Irredeemable();
    $oCurrentDayTableNo = new DC_Admin_Currency_TableNo_CurrentDay();
    $oSellBuyTableNo = new DC_Admin_Currency_TableNo_SellBuy();
                                                                                            
    foreach($aFile as $key => $value){
            $aXML = $oXML->parseFile('http://nbp.pl/Kursy/xml/'.trim($value).'.xml',true);
            $aData = array();
            
            foreach($aXML['tabela_kursow'][0]['pozycja'] as $value2){
                
                $oCurrency = DS_Currency_IdBySymbol::getInstance($value2['kod_waluty'],true);
                $aCurrency = $oCurrency->getData();
                
                if(isset($aCurrency[0]['currency_id'])){
                    
                    $aData[$aCurrency[0]['currency_id']]['currency_id'] = $aCurrency[0]['currency_id'];
                    if(isset($value2['kurs_sredni'])){
                        
                        $value2['kurs_sredni'] = str_replace(',','.',$value2['kurs_sredni']);
                        $aData[$aCurrency[0]['currency_id']]['currency_rate'] = number_format($value2['kurs_sredni'],4,'.','');
                        
                    }else{
                        
                        $value2['kurs_kupna'] = str_replace(',','.',$value2['kurs_kupna']);
                        $value2['kurs_sprzedazy'] = str_replace(',','.',$value2['kurs_sprzedazy']);
                        $aData[$aCurrency[0]['currency_id']]['currency_buy_rate'] = number_format($value2['kurs_kupna'],4,'.','');
                        $aData[$aCurrency[0]['currency_id']]['currency_sell_rate'] = number_format($value2['kurs_sprzedazy'],4,'.','');
                        
                    }
                    $aData[$aCurrency[0]['currency_id']]['currency_counter'] = $value2['przelicznik'];
                    if(isset($value2['kod_waluty'])){
                        $aData[$aCurrency[0]['currency_id']]['currency_symbol'] = $value2['kod_waluty'];    
                    }
                    
                    
                    $aData[$aCurrency[0]['currency_id']]['currency_date'] = $aXML['tabela_kursow'][0]['data_publikacji']; 
                }
            }
            switch(substr($value, 0,-strlen($value) + 1)){
                case 'a':
                    //zapis nr tabeli do bazy
                    $aCurrentDayTableNo = array('table_date'=>$aXML['tabela_kursow'][0]['data_publikacji'],'table_no'=>$aXML['tabela_kursow'][0]['numer_tabeli']);
                    $oCurrentDayTableNo->saveData($aCurrentDayTableNo);
                    //wyciagniecie maksymalnej daty
                    $oMaxDate = DS_Admin_Currency_History_MaxDate::getInstance(true);
                    $aMaxDate = $oMaxDate->getData();
                    //wyciagniecie kursow poprzedniech
                    $oCurrencyHistoryLastDay = DS_Currency_History_CurrentDayRateByDate::getInstance($aMaxDate[0]['max_date'],true); 
                    $aCurrencyHistoryLastDay = $oCurrencyHistoryLastDay->getData();
                    
                    $aDataHistory = array();
                    foreach($aCurrencyHistoryLastDay as $value){
                        $aDataHistory[$value['currency_id']] = $value;
                    }
                    
                    $aSaveData = array();
                    foreach($aData as $value){
                        
                        $aSaveData[$value['currency_id']] = $value;
                        if(isset($aDataHistory[$value['currency_id']])){
                            $aSaveData[$value['currency_id']]['currency_change_rate'] =
                                number_format(
                                    (($aSaveData[$value['currency_id']]['currency_counter']
                                      * $aSaveData[$value['currency_id']]['currency_rate']
                                      - $aDataHistory[$value['currency_id']]['currency_rate']
                                        * $aDataHistory[$value['currency_id']]['currency_counter'])
                                     / ($aDataHistory[$value['currency_id']]['currency_rate']
                                        * $aDataHistory[$value['currency_id']]['currency_counter']))
                                    * 100,
                                    4,
                                    '.',
                                    ''
                                );
                        }else{
                            $aSaveData[$value['currency_id']]['currency_change_rate'] = 0;
                        }
                        $oHistory->saveData($aSaveData[$value['currency_id']]);
                        
                    }
                break;
                case 'b':
                    //zapis nr tabeli do bazy
                    $aIrredeemableTableNo = array('table_date'=>$aXML['tabela_kursow'][0]['data_publikacji'],'table_no'=>$aXML['tabela_kursow'][0]['numer_tabeli']);
                    $oIrredeemableTableNo->saveData($aIrredeemableTableNo);
                    
                    //wyciagniecie maksymalnej daty
                    $oMaxDate = DS_Admin_Currency_History_IrredeemableMaxDate::getInstance(true);
                    $aMaxDate = $oMaxDate->getData();
                    
                    //wyciagniecie danych z poprzedniego dnia za pomoca daty
                    $oCurrencyHistoryLastDay = DS_Currency_History_IrredeemableByDate::getInstance($aMaxDate[0]['max_date'],true); 
                    $aCurrencyHistoryLastDay = $oCurrencyHistoryLastDay->getData();
                    
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
                        $oHistoryIrredeemable->saveData($aSaveData[$value['currency_id']]);
                        
                    }
                break;
                case 'c':
                    //wyciagniecie maksymalnej daty
                    $oMaxDate = DS_Admin_Currency_History_SellBuyMaxDate::getInstance(true);
                    $aMaxDate = $oMaxDate->getData();
                    
                    $oCurrencyHistoryLastDay = DS_Currency_History_SellBuyByDate::getInstance($aMaxDate[0]['max_date'],true); 
                    $aCurrencyHistoryLastDay = $oCurrencyHistoryLastDay->getData();
                    
                    $aSellBuyTableNo = array('table_date'=>$aXML['tabela_kursow'][0]['data_publikacji'],'table_no'=>$aXML['tabela_kursow'][0]['numer_tabeli']);
                    $oSellBuyTableNo->saveData($aSellBuyTableNo);
                    
                    foreach($aCurrencyHistoryLastDay as $value){
                        $aDataHistory[$value['currency_id']] = $value;
                    }
                    
                    //przeliczenie zmiany kursu oraz zapis do bazy
                    $aSaveData = array();
                    foreach($aData as $value){
                        $aSaveData[$value['currency_id']] = $value;
                        $aSaveData[$value['currency_id']]['currency_insert_date'] = $value['currency_date'];
                        if(isset($aDataHistory[$value['currency_id']])){
                            $aSaveData[$value['currency_id']]['currency_sell_change_rate'] = number_format((($aSaveData[$value['currency_id']]['currency_counter'] * $aSaveData[$value['currency_id']]['currency_sell_rate'] - $aDataHistory[$value['currency_id']]['currency_sell_rate'] * $aDataHistory[$value['currency_id']]['currency_counter']) / ($aDataHistory[$value['currency_id']]['currency_sell_rate'] * $aDataHistory[$value['currency_id']]['currency_counter'])) * 100,4,'.','');
                            $aSaveData[$value['currency_id']]['currency_buy_change_rate'] = number_format((($aSaveData[$value['currency_id']]['currency_counter'] * $aSaveData[$value['currency_id']]['currency_buy_rate'] - $aDataHistory[$value['currency_id']]['currency_buy_rate'] * $aDataHistory[$value['currency_id']]['currency_counter']) / ($aDataHistory[$value['currency_id']]['currency_buy_rate'] * $aDataHistory[$value['currency_id']]['currency_counter'])) * 100,4,'.','');
                        }else{
                            $aSaveData[$value['currency_id']]['currency_sell_change_rate'] = 0;
                            $aSaveData[$value['currency_id']]['currency_buy_change_rate'] = 0;
                        }
                        $oHistorySellBuy->saveData($aSaveData[$value['currency_id']]);
                    }
                    
                break;
            }    
        $i++;
    }
    if(DEBUG_PROCESS) {
        $oDBC = CMS_Core_DBAccess::getInstance();
        echo '<div class="debug-box">' .$oDBC->getDebugQuery() .'</div>'; 
    }
}catch(Error $e){
    $e->getError();
}

?>