<?php 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
    function sort_helper($a, $b)
    {
        return strcmp($b->id, $a->id);
    }

    function zip_position($zip, $city, $pos = "left")
    {
        $settings = Setting::first();
        $pos = $settings->zip_position;
        $comp = ($pos == "left") ? $zip." ".$city : $city." ".$zip;
        return $comp;
    }

    function display_money($value, $currency = false, $decimal = 2)
    {
        $instance =& get_instance();
        $settings = Setting::first();
        switch ($settings->money_format) {
            case 1:
                $value = number_format($value, $decimal, '.', ',');
                break;
            case 2:
                $value = number_format($value, $decimal, ',', '.');
                break;
            case 3:
                $value = number_format($value, $decimal, '.', '');
                break;
            case 4:
                $value = number_format($value, $decimal, ',', '');
                break;
            case 5:
                $value = number_format($value, $decimal, '.', '\'');
                break;
            default:
                $value = number_format($value, $decimal, '.', ',');
                break;
        }
        switch ($settings->money_currency_position) {
            case 1:
                $return = $currency.' '.$value;
                break;
            case 2:
                $return = $value.' '.$currency;
                break;
            case false:
                $return = $value;
                break;
            default:
                $return = $currency.' '.$value;
                break;
        }

        return $return;
    }

     function get_money_format()
     {
         $instance =& get_instance();
         $settings = Setting::first();
         $currency = $settings->currency;
         switch ($settings->money_format) {
            case 1:
                $separator = ',';
                $decimal = '.';
                break;
            case 2:
                $separator = '.';
                $decimal = ',';
                break;
            case 3:
                $separator = '';
                $decimal = '.';
                break;
            case 4:
                $separator = '';
                $decimal = ',';
                break;
            case 5:
                $separator = '\'';
                $decimal = '.';
                break;
            default:
                $separator = ',';
                $decimal = '.';
                break;
        }
         $prefix = "";
         $suffix = "";
         switch ($settings->money_currency_position) {
            case 1:
                $prefix = $currency." ";
                break;
            case 2:
                $suffix = " ".$currency;
                break;
            default:
                $prefix = $currency." ";
                break;
        }


         $return = "separator : '".$separator."', 
    decimal : '".$decimal."', prefix : '".$prefix."', 
    suffix : '".$suffix."' ";
         return $return;
     }

    function getDatesOfWeek()
    {
        $days = array();
        $days[] = date("Y-m-d", strtotime('this week monday'));
        $days[] = date("Y-m-d", strtotime('this week tuesday'));
        $days[] = date("Y-m-d", strtotime('this week wednesday'));
        $days[] = date("Y-m-d", strtotime('this week thursday'));
        $days[] = date("Y-m-d", strtotime('this week friday'));
        $days[] = date("Y-m-d", strtotime('this week saturday'));
        $days[] = date("Y-m-d", strtotime('this week sunday'));
        return $days;
    }

    function getCurrencyCodes()
    {
        # PHP ISO currency => name list
        $currency_codes = array("AFA"=>"Afghani","AFN"=>"Afghani","ALK"=>"Albanian old lek","ALL"=>"Lek","DZD"=>"Algerian Dinar","USD"=>"US Dollar","ADF"=>"Andorran Franc","ADP"=>"Andorran Peseta","EUR"=>"Euro","AOR"=>"Angolan Kwanza Readjustado","AON"=>"Angolan New Kwanza","AOA"=>"Kwanza","XCD"=>"East Caribbean Dollar","ARA"=>"Argentine austral","ARS"=>"Argentine Peso","ARL"=>"Argentine peso ley","ARM"=>"Argentine peso moneda nacional","ARP"=>"Peso argentino","AMD"=>"Armenian Dram","AWG"=>"Aruban Guilder","AUD"=>"Australian Dollar","ATS"=>"Austrian Schilling","AZM"=>"Azerbaijani manat","AZN"=>"Azerbaijanian Manat","BSD"=>"Bahamian Dollar","BHD"=>"Bahraini Dinar","BDT"=>"Taka","BBD"=>"Barbados Dollar","BYR"=>"Belarussian Ruble","BEC"=>"Belgian Franc (convertible)","BEF"=>"Belgian Franc (currency union with LUF)","BEL"=>"Belgian Franc (financial)","BZD"=>"Belize Dollar","XOF"=>"CFA Franc BCEAO","BMD"=>"Bermudian Dollar","INR"=>"Indian Rupee","BTN"=>"Ngultrum","BOP"=>"Bolivian peso","BOB"=>"Boliviano","BOV"=>"Mvdol","BAM"=>"Convertible Marks","BWP"=>"Pula","NOK"=>"Norwegian Krone","BRC"=>"Brazilian cruzado","BRB"=>"Brazilian cruzeiro","BRL"=>"Brazilian Real","BND"=>"Brunei Dollar","BGN"=>"Bulgarian Lev","BGJ"=>"Bulgarian lev A/52","BGK"=>"Bulgarian lev A/62","BGL"=>"Bulgarian lev A/99","BIF"=>"Burundi Franc","KHR"=>"Riel","XAF"=>"CFA Franc BEAC","CAD"=>"Canadian Dollar","CVE"=>"Cape Verde Escudo","KYD"=>"Cayman Islands Dollar","CLP"=>"Chilean Peso","CLF"=>"Unidades de fomento","CNX"=>"Chinese People's Bank dollar","CNY"=>"Yuan Renminbi","COP"=>"Colombian Peso","COU"=>"Unidad de Valor real","KMF"=>"Comoro Franc","CDF"=>"Franc Congolais","NZD"=>"New Zealand Dollar","CRC"=>"Costa Rican Colon","HRK"=>"Croatian Kuna","CUP"=>"Cuban Peso","CYP"=>"Cyprus Pound","CZK"=>"Czech Koruna","CSK"=>"Czechoslovak koruna","CSJ"=>"Czechoslovak koruna A/53","DKK"=>"Danish Krone","DJF"=>"Djibouti Franc","DOP"=>"Dominican Peso","ECS"=>"Ecuador sucre","EGP"=>"Egyptian Pound","SVC"=>"Salvadoran colón","EQE"=>"Equatorial Guinean ekwele","ERN"=>"Nakfa","EEK"=>"Kroon","ETB"=>"Ethiopian Birr","FKP"=>"Falkland Island Pound","FJD"=>"Fiji Dollar","FIM"=>"Finnish Markka","FRF"=>"French Franc","XFO"=>"Gold-Franc","XPF"=>"CFP Franc","GMD"=>"Dalasi","GEL"=>"Lari","DDM"=>"East German Mark of the GDR (East Germany)","DEM"=>"Deutsche Mark","GHS"=>"Ghana Cedi","GHC"=>"Ghanaian cedi","GIP"=>"Gibraltar Pound","GRD"=>"Greek Drachma","GTQ"=>"Quetzal","GNF"=>"Guinea Franc","GNE"=>"Guinean syli","GWP"=>"Guinea-Bissau Peso","GYD"=>"Guyana Dollar","HTG"=>"Gourde","HNL"=>"Lempira","HKD"=>"Hong Kong Dollar","HUF"=>"Forint","ISK"=>"Iceland Krona","ISJ"=>"Icelandic old krona","IDR"=>"Rupiah","IRR"=>"Iranian Rial","IQD"=>"Iraqi Dinar","IEP"=>"Irish Pound (Punt in Irish language)","ILP"=>"Israeli lira","ILR"=>"Israeli old sheqel","ILS"=>"New Israeli Sheqel","ITL"=>"Italian Lira","JMD"=>"Jamaican Dollar","JPY"=>"Yen","JOD"=>"Jordanian Dinar","KZT"=>"Tenge","KES"=>"Kenyan Shilling","KPW"=>"North Korean Won","KRW"=>"Won","KWD"=>"Kuwaiti Dinar","KGS"=>"Som","LAK"=>"Kip","LAJ"=>"Lao kip","LVL"=>"Latvian Lats","LBP"=>"Lebanese Pound","LSL"=>"Loti","ZAR"=>"Rand","LRD"=>"Liberian Dollar","LYD"=>"Libyan Dinar","CHF"=>"Swiss Franc","LTL"=>"Lithuanian Litas","LUF"=>"Luxembourg Franc (currency union with BEF)","MOP"=>"Pataca","MKD"=>"Denar","MKN"=>"Former Yugoslav Republic of Macedonia denar A/93","MGA"=>"Malagasy Ariary","MGF"=>"Malagasy franc","MWK"=>"Kwacha","MYR"=>"Malaysian Ringgit","MVQ"=>"Maldive rupee","MVR"=>"Rufiyaa","MAF"=>"Mali franc","MTL"=>"Maltese Lira","MRO"=>"Ouguiya","MUR"=>"Mauritius Rupee","MXN"=>"Mexican Peso","MXP"=>"Mexican peso","MXV"=>"Mexican Unidad de Inversion (UDI)","MDL"=>"Moldovan Leu","MCF"=>"Monegasque franc (currency union with FRF)","MNT"=>"Tugrik","MAD"=>"Moroccan Dirham","MZN"=>"Metical","MZM"=>"Mozambican metical","MMK"=>"Kyat","NAD"=>"Namibia Dollar","NPR"=>"Nepalese Rupee","NLG"=>"Netherlands Guilder","ANG"=>"Netherlands Antillian Guilder","NIO"=>"Cordoba Oro","NGN"=>"Naira","OMR"=>"Rial Omani","PKR"=>"Pakistan Rupee","PAB"=>"Balboa","PGK"=>"Kina","PYG"=>"Guarani","YDD"=>"South Yemeni dinar","PEN"=>"Nuevo Sol","PEI"=>"Peruvian inti","PEH"=>"Peruvian sol","PHP"=>"Philippine Peso","PLZ"=>"Polish zloty A/94","PLN"=>"Zloty","PTE"=>"Portuguese Escudo","TPE"=>"Portuguese Timorese escudo","QAR"=>"Qatari Rial","RON"=>"New Leu","ROL"=>"Romanian leu A/05","ROK"=>"Romanian leu A/52","RUB"=>"Russian Ruble","RWF"=>"Rwanda Franc","SHP"=>"Saint Helena Pound","WST"=>"Tala","STD"=>"Dobra","SAR"=>"Saudi Riyal","RSD"=>"Serbian Dinar","CSD"=>"Serbian Dinar","SCR"=>"Seychelles Rupee","SLL"=>"Leone","SGD"=>"Singapore Dollar","SKK"=>"Slovak Koruna","SIT"=>"Slovenian Tolar","SBD"=>"Solomon Islands Dollar","SOS"=>"Somali Shilling","ZAL"=>"South African financial rand (Funds code) (discont","ESP"=>"Spanish Peseta","ESA"=>"Spanish peseta (account A)","ESB"=>"Spanish peseta (account B)","LKR"=>"Sri Lanka Rupee","SDD"=>"Sudanese Dinar","SDP"=>"Sudanese Pound","SDG"=>"Sudanese Pound","SRD"=>"Surinam Dollar","SRG"=>"Suriname guilder","SZL"=>"Lilangeni","SEK"=>"Swedish Krona","CHE"=>"WIR Euro","CHW"=>"WIR Franc","SYP"=>"Syrian Pound","TWD"=>"New Taiwan Dollar","TJS"=>"Somoni","TJR"=>"Tajikistan ruble","TZS"=>"Tanzanian Shilling","THB"=>"Baht","TOP"=>"Pa'anga","TTD"=>"Trinidata and Tobago Dollar","TND"=>"Tunisian Dinar","TRY"=>"New Turkish Lira","TRL"=>"Turkish lira A/05","TMM"=>"Manat","RUR"=>"Russian rubleA/97","SUR"=>"Soviet Union ruble","UGX"=>"Uganda Shilling","UGS"=>"Ugandan shilling A/87","UAH"=>"Hryvnia","UAK"=>"Ukrainian karbovanets","AED"=>"UAE Dirham","GBP"=>"Pound Sterling","USN"=>"US Dollar (Next Day)","USS"=>"US Dollar (Same Day)","UYU"=>"Peso Uruguayo","UYN"=>"Uruguay old peso","UYI"=>"Uruguay Peso en Unidades Indexadas","UZS"=>"Uzbekistan Sum","VUV"=>"Vatu","VEF"=>"Bolivar Fuerte","VEB"=>"Venezuelan Bolivar","VND"=>"Dong","VNC"=>"Vietnamese old dong","YER"=>"Yemeni Rial","YUD"=>"Yugoslav Dinar","YUM"=>"Yugoslav dinar (new)","ZRN"=>"Zairean New Zaire","ZRZ"=>"Zairean Zaire","ZMK"=>"Kwacha","ZWD"=>"Zimbabwe Dollar","ZWC"=>"Zimbabwe Rhodesian dollar");

        return $currency_codes;
    }
    function getCurrencyCodesForTwocheckout()
    {
        $currency_codes = array("ARS"=>"Argentina Peso",
                            "AUD"=>"Australian Dollars",
                            "BRL"=>"Brazilian Real",
                            "GBP"=>"British Pounds Sterling",
                            "BGN"=>"Bulgarian Lev",
                            "CAD"=>"Canadian Dollars",
                            "CLP"=>"Chilean Peso",
                            "DKK"=>"Danish Kroner",
                            "EUR"=>"Euros",
                            "HKD"=>"Hong Kong Dollars",
                            "INR"=>"Indian Rupee",
                            "IDR"=>"Indonesian Rupiah",
                            "ILS"=>"Israeli New Shekel",
                            "JPY"=>"Japanese Yen",
                            "MYR"=>"Malaysian Ringgit",
                            "MXN"=>"Mexican Peso",
                            "NZD"=>"New Zealand Dollars",
                            "NOK"=>"Norwegian Kroner",
                            "PHP"=>"Philippine Peso",
                            "RON"=>"Romanian New Leu",
                            "RUB"=>"Russian Ruble",
                            "SGD"=>"Singapore Dollar",
                            "ZAR"=>"South African Rand",
                            "SEK"=>"Swedish Kronor",
                            "SAR"=>"Saudi Riyal",
                            "CHF"=>"Swiss Francs",
                            "TRY"=>"Turkish Lira",
                            "UAH"=>"Ukrainian Hryvnia",
                            "AED"=>"United Arab Emirates Dirham",
                            "USD"=>"US Dollars");
        return $currency_codes;
    }

    function strip_quotes_from_message($message)
{
    $els_to_remove = [
        'blockquote',                           // Standard quote block tag
        'div.moz-cite-prefix',                  // Thunderbird
        'div.gmail_extra', 'div.gmail_quote',   // Gmail
        'div.yahoo_quoted'                      // Yahoo
    ];
    $dom = new PHPHtmlParser\Dom;
    $dom->load($message);
    foreach ($els_to_remove as $el) {
        $founds = $dom->find($el)->toArray();
        foreach ($founds as $f) {
            $f->delete();
            unset($f);
        }
    }
    // Outlook doesn't respect
    // http://www.w3.org/TR/1998/NOTE-HTMLThreading-0105#Appendix%20B
    // We need to detect quoted replies "by hand"
    //
    // Example of Outlook quote:
    //
    // <div>
    //      <hr id="stopSpelling">
    //      Date: Fri. 20 May 2016 17:40:24 +0200<br>
    //      Subject: Votre facture Selon devis DEV201605201<br>
    //      From: xxxxxx@microfactures.com<br>
    //      To: xxxxxx@hotmail.fr<br>
    //      Lorem ipsum dolor sit amet consectetur adipiscing...
    // </div>
    //
    // The idea is to delete #stopSpelling's parent...
    $hr  = $dom->find('#stopSpelling', /*nth result*/0);
    if (null !== $hr) {
        $hr->getParent()->delete();
    }
    // Roundcube adds a <p> with a sentence like this one, just
    // before the quote:
    // "Le 21-05-2016 02:25, AB Prog - Belkacem Alidra a écrit :"
    // Let's remove it
    $pattern = '/Le [0-9]{2}-[0-9]{2}-[0-9]{4} [0-9]{2}:[0-9]{2}, [^:]+ a &eacute;crit&nbsp;:/';
    $ps = $dom->find('p')->toArray();
    foreach ($ps as $p) {
        if (preg_match($pattern, $p->text())) {
            $p->delete();
            unset($p);
        }
    }
    // Let's remove empty tags like <p> </p>...
    $els = $dom->find('p,span,b,strong,div')->toArray();
    foreach ($els as $e) {
        $html = trim($e->innerHtml());
        if (empty($html) || $html == "&nbsp;") {
            $e->delete();
            unset($e);
        }
    }
    $message = $dom->root->innerHtml();
    return $message;
}

function get_email_name($from){
    $explode = explode(' - ', $from);
    if (isset($explode[1])) {
        $emailsender = $explode[1];
        $emailname = str_replace('"', '', $explode[0]);
        $emailname = str_replace('<', '', $emailname);
        $emailname = str_replace('>', '', $emailname);
        $emailname = explode(' ', $emailname);
        $emailname = $emailname[0];
    } else {
        $explodeemail = '-';
    }
    return $emailname;
}
