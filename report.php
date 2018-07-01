<?php
    $startDate = "2018-05-08";//$_POST['startDate'];
    $endDate = "2018-05-27";//$_POST['endDate'];
    
    function returnDates($fromdate, $todate) {
        $fromdate = \DateTime::createFromFormat('Y-m-d', $fromdate);
        $todate = \DateTime::createFromFormat('Y-m-d', $todate);
        return new \DatePeriod(
            $fromdate,
            new \DateInterval('P1D'),
            $todate->modify('+1 day')
        );
    }
    
     
    //Our YYYY-MM-DD date string.
    $date = $startDate;

    //Convert the date string into a unix timestamp.
    $unixTimestamp = strtotime($date);

    //Get the day of the week using PHP's date function.
    $dayOfWeek = date("l", $unixTimestamp);

    //Print out the day that our date fell on.
    echo $date . ' fell on a ' . $dayOfWeek;
    
?>
<table>
<?php
    $i = 1;
    $datePeriod = returnDates($startDate, $endDate);
    foreach($datePeriod as $date) {
?>
<tr>
    <td> 
        <?php 
            $date->format('d-m-Y');
                        $daily = $date->format('Y-m-d');
                        echo $daily; 
        ?>
    </td>
</tr>
<?php
    $i++;
    }
?>
</table>