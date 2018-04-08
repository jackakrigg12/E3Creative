<!doctype html>
<?php include('includes/config.php'); ?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <?php

        $OnLoadClause = array();
        $OnLoad = NULL;

        if($_POST['ins']==1){
            $OnLoadClause[] = "successfulInsert();";
        }
        if($_POST['error']==1){
            $OnLoadClause[] = "apiFailure();";
        }
        if($_POST['error']==2){
            $OnLoadClause[] = "incorrectInfo();";
        }

        // Do we have an onload event?
        if (count($OnLoadClause) > 0) {
            $OnLoad = implode(" ", $OnLoadClause);
            $OnLoad = " onload=\"" . $OnLoad . "\"";
        }
    ?>

    <title>E3Creative - Jack Akrigg</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="includes/javascript/ajax_load_days.js"></script>

    <script type="text/javascript">
        <!--

        function validate() {

            var errorString = '';

            // Get month
            if (document.getElementById('month').value == "") {
                errorString = '- Please select a month\n';
            }

            // Get day
            if (document.getElementById('day').value == "") {
                errorString = '- Please enter a day\n';
            }


            // Do we have everything we need?
            if (errorString) {
                alert('There were problems selecting an event to manage:\n\n' + errorString + '\nPlease check and try again.');
            }
            else {

                // Lets work out the year
                var current_month = <?=date('n');?>;
                var current_day = <?=date('j');?>;

                // If the posted month is smaller than current month their latest birthday was this year
                if (document.getElementById('month').value < current_month) {
                    var year = '<?=date('Y');?>';
                }
                // If it was this month (before today) it was this year
                else if (document.getElementById('month').value == current_month && document.getElementById('day').value < current_day) {
                    var year = '<?=date('Y');?>';
                }
                // Otherwise it must have been last year
                else {
                    var year = '<?=date("Y", strtotime("-1 year"));?>'
                }

                // Set fields and post data
                document.getElementById('year').value = year;
                document.getElementById('birthday_exchange').action = 'includes/scripts/birthday_exchange_data.php';
                document.getElementById('birthday_exchange').submit();

            }

        }

        function loadDays(month){
            loadDay(month);
        }

        function successfulInsert(){
            alert('Success! Your birthday exchange rate has been found and added to the table of results.');
        }

        function apiFailure(){
            alert('Sorry! There was a problem retrieving the exchange rate information.');

        }

        function incorrectInfo(){
            alert('Sorry! We did not have all the information we need to retrieve the exchange rate information.');

        }
        -->
    </script>

</head>

<body <?= $OnLoad; ?>>

    <h1>What was the EUR to GBP exchange rate on your previous Birthday?</h1>

    <form name="birthday_exchange" id="birthday_exchange" action="">

        <input type="hidden" name="year" id="year" value="" />

        <label>When is your Birthday?</label>

        <select name="month" id="month" onchange="loadDays(this.value)">
            <option value="">.. select a month ..</option>
            <?php
                for($i=1;$i<=12;$i++){
                    $MonthName = date('F', mktime(0, 0, 0, $i, 1));
                    ?>
                    <option value="<?=$i?>"><?=$MonthName;?></option>
                    <?php
                }
            ?>
        </select>


        <div id="day_wrapper"><!-- AJAX --></div>


        <input type="button" name="submit_btn" id="submit_btn" value="Submit" onclick="validate();">

    </form>



    <h2>Birthday Results</h2>

    <div id="birthday_results">

        <?php
            // Select
            $BirthdayExchangeRate = "SELECT birthday, count(birthday) AS submission_count, exchange_rate FROM birthday_exchange_rate WHERE failure_message IS NULL GROUP BY birthday ORDER BY birthday DESC ";
            $BirthdayExchangeRateResults = mysql_query($BirthdayExchangeRate);
            $BirthdayExchangeRateNumRows = mysql_num_rows($BirthdayExchangeRateResults);

            // Output
            if($BirthdayExchangeRateNumRows > 0) { ?>

                <table>

                    <tr style="text-align: left;">
                        <th width="150px;">Last Birthday</th>
                        <th width="150px;">Exchange Rate</th>
                        <th width="150px;">Submission Count</th>
                    </tr>

                    <?php while ($BirthdayExchangeRateData = mysql_fetch_assoc($BirthdayExchangeRateResults)){ ?>
                        <tr>
                            <td><?=date('jS F Y',$BirthdayExchangeRateData['birthday']);?></td>
                            <td><?=$BirthdayExchangeRateData['exchange_rate'];?></td>
                            <td><?=$BirthdayExchangeRateData['submission_count']?></td>
                        </tr>
                    <?php } ?>

                </table>
                <?php

            } else { ?>

                <p>No results found.</p>
                <?php
            }
        ?>

    </div>


</body>
</html>


