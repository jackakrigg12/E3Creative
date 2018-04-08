<?php

    include('../config.php');

    $Success = 0;
    $ErrorString = '';

    // Do we have all the date params we need
    if( $_REQUEST['month']>0 || $_REQUEST['day']>0 || $_REQUEST['year']>0 ){

        // Make timestamp for DB
        $Birthday = mktime(0,0,0,$_REQUEST['month'],$_REQUEST['day'],$_REQUEST['year']);

        $Insert = mysql_query("INSERT INTO birthday_exchange_rate SET birthday = ".$Birthday);
        $BirthdayExchangeRateID = mysql_insert_id();

        // Timestamp into format API expects & Currency
        $Date = date('Y-m-d',$Birthday);
        $Curr = 'GBP';
        $Key = '331025c625b3d0e4d01c3d0e3d15cd82';

        // API CALL
        $ch = curl_init('http://data.fixer.io/api/'.$Date.'?access_key='.$Key.'&symbols='.$Curr.'');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $FixerAPI = json_decode($json, true);

        if($FixerAPI['success']==true){ // If success
            $Update = mysql_query("UPDATE birthday_exchange_rate SET exchange_rate = '".$FixerAPI['rates']['GBP']."' WHERE birthday_exchange_rate_id = '".$BirthdayExchangeRateID."'");
            $Success = 1;
        }
        else {
            $Update = mysql_query("UPDATE birthday_exchange_rate SET failure_message = '".$FixerAPI['error']['info']."' WHERE birthday_exchange_rate_id = '".$BirthdayExchangeRateID."'");
            $ErrorString = 1;
        }

    }
    else {
        $ErrorString = 2;
    }


?>
<html>
    <head><title>Retrieving and Saving Exchange Rate Data</title></head>
    <body onLoad="document.getElementById('done_form').submit();">
        <form action="../../birthday_exchange_rate.php" method="post" name="done_form" id="done_form">
            <input type="hidden" name="ins" id="ins" value="<?=$Success;?>" />
            <input type="hidden" name="error" id="error" value="<?=$ErrorString;?>" />
        </form>
    </body>
</html>
