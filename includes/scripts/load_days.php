<?php

if($_REQUEST['month']>0){

    $TotalNumberOfDaysInMonth = date('t', mktime(0, 0, 0, $_REQUEST['month'], 1, date('Y'))); ?>

    <select name="day" id="day">
        <option value="">.. select a day ..</option>
        <?php
        for($i=1;$i<=$TotalNumberOfDaysInMonth;$i++){
            ?>
            <option value="<?=$i?>"><?=$i;?></option>
            <?php
        }
        ?>
    </select>
    <?php

}
else { ?>

    <p>Before you select a day, please select a month</p>
    <input type="hidden" name="day" id="day" value="" />
    <?php

}
?>
