<?php

/**
 * skrypt uruchamiany w cronie dodaje dane do tabli z kursami walut kupna/sprzedazy (Tabela C)
 * @author Michal Kalkowksi <michal@silversite.pl> 
 * @version 1.0
 * @todo sprawdzic czy dziala w srode
 * @copyright 2009 SilverSite (silversite.pl)
 * @package waluty
 * @subpackage cron
 */

require('../../config/loader.php');

try{
    
//tablea kursow celnych
    //sprawdzam czy jest sroda
    if(date('w') == 3){
        
        $aTableA = $aTableB = array();
        $i=0;
        while( count($aTableA) == 0) { // dopuki nie znajdzie wartosci z danego dnia
            $oTableA = DS_Currency_History_IrredeemableByDate::getInstance(date('Y-m-d',mktime(0, 0, 0, date("n"), date("d")-($i), date("Y"))),true);
            $aTableA = $oTableA->getData();
            $i++; // dzien wstecz
            if($i > 30){ // powyzej 30 porb - error
                throw new Error('Nie mozna odczytac wartosci z tabeli A waluty celne');
            }
        }
        $i=0;
        while( count($aTableB) == 0) { // dopuki nie znajdzie wartosci z danego dnia
            $oTableB = DS_Currency_History_CurrentDayRateByDate::getInstance(date('Y-m-d',mktime(0, 0, 0, date("n"), date("d")-($i), date("Y"))),true);
            $aTableB = $oTableB->getData();
            $i+=7; // tydzien wstecz (co srode)
            if($i > 70){ // powyzej 10 porb - error 
                throw new Error('Nie mozna odczytac wartosci z tabeli B waluty celne');
            }
        }
        $aDuty = array_merge($aTableA,$aTableB);
        
        $iDzienMies = date('j'); // Dzien miesiaca bez zer wiodacych
        $iDniWMiesiacu = date('t'); // 	Ilosc dni w danym miesiacu
        

        $oDutyMonth = DS_Currency_DutyRate::getInstance(date('Y-m-d'));//wyciagniecie kursow celnych aktualnie obowiazujacych 
        $aDutyMonthTmp = $oDutyMonth->getData();
        foreach($aDutyMonthTmp as $value) {
            $aDutyMonth[ $value['currency_id'] ] = $value;
        }

        
        $oDutyDc = new DC_Admin_Currency_Duty();
        
        if($iDniWMiesiacu - $iDzienMies >= 7 && $iDniWMiesiacu - $iDzienMies < 14){//szukanie przedostatniej srody
                
            $i=0;
            foreach($aDuty as $value){
                $aData[$i]['currency_id'] = $value['currency_id'];
                $aData[$i]['currency_rate'] = $value['currency_rate'];
                $aData[$i]['currency_counter'] = $value['currency_counter'];
                if(isset($aDutyMonth[$value['currency_id']])){
                    $aData[$i]['currency_change_rate'] = number_format((($aData[$i]['currency_counter'] * $aData[$i]['currency_rate'] - $aDutyMonth[$value['currency_id']]['currency_rate'] * $aDutyMonth[$value['currency_id']]['currency_counter']) / ($aDutyMonth[$value['currency_id']]['currency_rate'] * $aDutyMonth[$value['currency_id']]['currency_counter'])) * 100,4,'.','');
                }else{
                    $aData[$i]['currency_change_rate'] = 0;
                }
                $aData[$i]['currency_date'] = date('Y-m-d');
                $aData[$i]['currency_publication_date'] = date('Y-m-d', mktime(0, 0, 0, date("m")+1, 1,   date("Y")));
                $i++;
            }
            $oDutyDc->saveData($aData);
        }

        $aDutyMonth = array();        
        $oDutyMonth = DS_Currency_DutyRate2::getInstance(date('Y-m-d'));//wyciagniecie kursow celnych ostatnio wprowadzonych 
        $aDutyMonthTmp = $oDutyMonth->getData();
        foreach($aDutyMonthTmp as $value) {
            $aDutyMonth[ $value['currency_id'] ] = $value;
        }
        
        $aData = array();
        $i=0;
        foreach($aDuty as $value) {
            if(isset($aDutyMonth[$value['currency_id']])){
                $fCurrencyChangeRate = number_format(
                    (($value['currency_counter'] * $value['currency_rate']
                      - $aDutyMonth[$value['currency_id']]['currency_rate']
                        * $aDutyMonth[$value['currency_id']]['currency_counter'])
                     / ($aDutyMonth[$value['currency_id']]['currency_rate']
                        * $aDutyMonth[$value['currency_id']]['currency_counter']))
                    * 100,
                    4,
                    '.',
                    ''
                );
                if($fCurrencyChangeRate >= 5 || $fCurrencyChangeRate <= -5) {
                    $aData[$i]['currency_id'] = $value['currency_id'];
                    $aData[$i]['currency_rate'] = $value['currency_rate'];
                    $aData[$i]['currency_counter'] = $value['currency_counter'];
                    $aData[$i]['currency_change_rate'] = $fCurrencyChangeRate;
                    $aData[$i]['currency_date'] = date('Y-m-d');
                    $aData[$i]['currency_publication_date'] = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")+7,   date("Y")));
                }                
            }/*
            else {
                $fCurrencyChangeRate = 0;
                $aData[$i]['currency_id'] = $value['currency_id'];
                $aData[$i]['currency_rate'] = $value['currency_rate'];
                $aData[$i]['currency_counter'] = $value['currency_counter'];
                $aData[$i]['currency_change_rate'] = $fCurrencyChangeRate;
                $aData[$i]['currency_date'] = date('Y-m-d');
                $aData[$i]['currency_publication_date'] = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")+7,   date("Y")));
            }*/
            $i++;
        }
        if(count($aData)){
            $oDutyDc->saveData($aData);    
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