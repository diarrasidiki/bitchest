<?php

namespace App\Tools;

class Currency
{
    function generateHistory($cryptomonney, $numberOfDays)
    {
    	$currency = new Currency();
        $history = [];
        $start = $currency->getFirstCotation($cryptomonney);
        
        $variance = $currency->getCotationFor($cryptomonney);
        $history[] = ['label' => (new \Datetime(date('d-m-Y')))->modify('-1 day')->format('d-m-Y'), 'y' => $start ];

        for($i=2;$i<=($numberOfDays);$i++)
        {
            $variance = $currency->getCotationFor($cryptomonney);
            $cotation = ((($history[$i-2]['y']) * $variance)/100) + ($history[$i-2]['y']);
            $date = new \Datetime(date('d-m-Y'));
            $dateBefore = $date->modify('-'.$i.' day');
            // $today = date_now();
            $history[] = ['label' => $dateBefore->format('d-m-Y'), 'y' => $cotation];
        }
        return serialize($history);
    }

    /**
     * Renvoie la valeur de mise sur le marché de la crypto monnaie (valeur initiale pour 1 euro)
     * @param $cryptoname {string} Le nom de la crypto monnaie
     */
    public function getFirstCotation($cryptoname)
    {
        return ord(substr($cryptoname,0,1)) + rand(0, 10);
    }

    /**
     * Renvoie la variation de cotation de la crypto monnaie sur un jour (% de variation de la cryptomonnaie)
     * @param $cryptoname {string} Le nom de la crypto monnaie
     */
    public function getCotationFor($cryptoname)
    {	
        return ((rand(0, 99)>40) ? 1 : -1) * ((rand(0, 99)>49) ? ord(substr($cryptoname,0,1)) : ord(substr($cryptoname,-1))) * (rand(1,10) * .01);
    }
}