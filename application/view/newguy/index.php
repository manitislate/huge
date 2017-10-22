<div class="container">
    <h1>Availability</h1>
    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <?php

        $sortme = array(
            'Monday 10:00',
            'Friday 12:00',
            'Tuesday 14:00',
            'Monday 08:00',
            'Wednesday 11:00',
        );

        usort($sortme, function($a, $b) { return strcmp(date('N H:i', strtotime($a)), date('N H:i', strtotime($b))); });
        //print_r($sortme);
        echo '<br>';

        date_default_timezone_set('America/Los_Angeles');
        /** Return an array of timezones
         *
         * @return array
         */
        function timezoneList()
        {
            $timezoneIdentifiers = DateTimeZone::listIdentifiers();
            $utcTime = new DateTime('now', new DateTimeZone('UTC'));

            $tempTimezones = array();
            foreach ($timezoneIdentifiers as $timezoneIdentifier) {
                $currentTimezone = new DateTimeZone($timezoneIdentifier);

                $tempTimezones[] = array(
                    'offset' => (int)$currentTimezone->getOffset($utcTime),
                    'identifier' => $timezoneIdentifier
                );
            }

            // Sort the array by offset,identifier ascending
            usort($tempTimezones, function($a, $b) {
                return ($a['offset'] == $b['offset'])
                    ? strcmp($a['identifier'], $b['identifier'])
                    : $a['offset'] - $b['offset'];
            });

            $timezoneList = array();
            foreach ($tempTimezones as $tz) {
                $sign = ($tz['offset'] > 0) ? '+' : '-';
                $offset = gmdate('H:i', abs($tz['offset']));
                $timezoneList[$tz['identifier']] = '(UTC ' . $sign . $offset . ') ' .
                    $tz['identifier'];
            }

            return $timezoneList;
        }







        if (!isset($this->time_offset{0}->time_zone) ){
            echo 'Time zone not set!'; ?>
            <form method="post" action="<?php echo Config::get('URL');?>newguy/setTimeZone">
                <?php
                $timezoneList = timezoneList();
                echo '<select name="time_zone">';
                foreach ($timezoneList as $value => $label) {
                    if ($value == ($_SESSION['tz'])){
                        echo '<option value="' . $value . '" selected>' . $label . '</option>';
                    }
                    else {
                        echo '<option value="' . $value . '">' . $label . '</option>';
                    }
                }
                echo '</select>';
                ?>


                <input type="submit" value='Set Time Zone' autocomplete="off" />
            </form>
        <?php } else {
        ?>
            <h3>Select a time that works for you</h3>
        <p>
            This is where you can input the hours your are available to mastermind. The system will use these hours to
            connect with others who are available at the same time.
        </p>
            <form method="post" action="<?php echo Config::get('URL');?>newguy/create">
                <select name="day">
                    <option value="Sunday">Sunday</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option vale="Saturday">Saturday</option>
                </select>

                <!-- <label>Day: </label><input type="text" name="day" /> -->


            <select name="hour">
            <?php for($hours=0, $i = 0; $hours<24, $i <= 24; $hours++, $i++) // the interval for hours is '1'
                //for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
                    echo '<option value='. str_pad($hours,2,'0',STR_PAD_LEFT). '00'. /** str_pad($mins,2,'0',STR_PAD_LEFT). */ '>'.date("h.iA", strtotime("$i:00")).'</option> ';
             ?>
            </select>


                <!-- <label>Hour: </label><input type="text" name="hour"  /> -->
                <input type="submit" value='Add this hour to my availability' autocomplete="off" />
            </form>


        <?php if ($this->availability) { ?>
            <table class="note-table">
                <thead>
                <tr>
                    <td>Day</td>
                    <td>Hour</td>
                    <td>DELETE</td>
                </tr>
                </thead>
                <tbody>
                    <?php
                    /** Set $move_sundays to 0 so we can stop when we hit monday.
                     *  @var  $move_sundays */
                    $move_sundays = 0;
                    $sunday_offset = array();


                    date_default_timezone_set('America/Los_Angeles');
                    foreach($this->availability as $key => $value) {




                $utc = 'last ' . $value->day . ' ' . $value->hour;
                        //echo $utc . '<br>';
                $timestamp = strtotime($utc);
                        $datetime = new DateTime();
                        $datetime->setTimestamp($timestamp);
                        //cho '<br>' . $datetime->getTimezone()->getName() . '<br>';
                        //echo $datetime->format(DATE_ATOM). '<br>';

                        $new_date = new DateTimeZone($this->time_offset{0}->time_zone);
                        $datetime->setTimezone($new_date);
                        //echo $datetime->getTimezone()->getName(). '<br>';
                        //echo $datetime->format('l'). '<br>';
                        //echo $datetime->format('Hi'). '<br>';

                //$date = new DateTime($utc, new DateTimeZone($this->time_offset{0}->time_zone));
                //echo '<br><br>'. $this->time_offset{0}->time_zone . ': ' . date("l h:iA", $date->format('U'));
                //echo '<br><br>' . date("Y-m-d h:iA", $date->format('U'));

                $value_day = $datetime->format('l');
                $value_hour = $datetime->format('Hi');
                        //echo 'value day'. $value_day;
                        //echo 'value hour' . $value_hour;

                        ?>
                        <tr>
                            <?php if (($value_day === 'Sunday' && $move_sundays === 0)||($value_day === 'Saturday' && $move_sundays === 0)){
                            $value_day2 = $datetime->format('l');
                            $value_hour =  $datetime->format('Hi');
                            $sunday_offset[] = ['move_sunday' => $value_day2,'move_sunhour' => $value_hour, 'sun_id' => $value->availability_id];
                            //echo '<br>';
                            //print_r($this->availability);
                            }
                            else { ?>
                                <td><?= htmlentities($value_day); ?></td>
                                <?php

                                // 24-hour time to 12-hour time
                                $time_in_12_hour_format  = $datetime->format('g:i a');
                                ?>
                                <td><?= htmlentities($time_in_12_hour_format); ?></td>

                                <td><a href="<?= Config::get('URL') . 'newguy/delete/' . $value->availability_id; ?>">Delete</a></td>
                            <?php }
                            if ($value_day === 'Monday'){
                            $move_sundays = 1;
                            } ?>



                        </tr>
                    <?php }
                    /** print rest of schedule */
                    foreach ($sunday_offset as $key => $value) {
                        //echo $value['move_sunhour'];
                        $utc = 'last ' . $value['move_sunday'] . ' ' . $value['move_sunhour'];
                        $timestamp = strtotime($utc);
                        //echo $utc;


                        $date = new DateTime($utc, new DateTimeZone('America/Los_Angeles'));

                        ?>
                        <tr>
                            <td> <?= htmlentities($value['move_sunday']); ?> </td>
                            <?php

                            // 24-hour time to 12-hour time
                            $time_in_12_hour_format  = DATE("g:i a", $date->format('U'));
                            ?>
                            <td> <?= htmlentities($time_in_12_hour_format); ?> </td>
                            <td><a href="<?= Config::get('URL') . 'newguy/delete/' . $value['sun_id']; ?>">Delete</a></td>
                        </tr>
                        <?php

                    }
                    ?>
                </tbody>
            </table>

            <h3>Next is Group: </h3>
            <p>
                If availability is set you can go to your group page.
            </p>
            <div>
                <p>
                <form method="post" action="<?php echo Config::get('URL');?>group/index">
                    <input type="submit" value='Group' autocomplete="off" />
                </form>
                </p>
            </div>
            <?php } else { ?>
                <div>Please select what time you are available to meet.</div>
            <?php } }












        //echo strtotime("now"), "\n<br>";
        //echo strtotime("10 September 2000"), "\n<br>";
        //echo strtotime("+1 day"), "\n<br>";
        //echo strtotime("+1 week"), "\n<br>";
       // echo strtotime("+1 week 2 days 4 hours 2 seconds"), "\n<br>";
       // echo strtotime("next Thursday"), "\n<br>";
        //echo strtotime("last Monday"), "\n<br>";


        //$str = 'last Monday 11:00 AM';

        // previous to PHP 5.1.0 you would compare with -1, instead of false
        //if (($timestamp = strtotime($str)) === false) {
         //   echo "The string ($str) is bogus";
        //} else {
        //    echo "$str == " . date('l dS \o\f F Y h:i:s A', $timestamp);
        //}


/**
        $date = new DateTime('2000-01-01', new DateTimeZone('Pacific/Nauru'));
        echo $date->format('Y-m-d H:i:sP') . "\n <br>";

        $date->setTimezone(new DateTimeZone('Pacific/Chatham'));
        echo $date->format('Y-m-d H:i:sP') . "\n <br>";
*/


        //$utc = 'November 25 2014 0100';

        //date_default_timezone_set("Europe/Copenhagen"); // Timezone from database
        //date_default_timezone_set('America/Los_Angeles');
        //$timestamp = strtotime($utc);
        //echo '<br>' . $timestamp;
        //$local_datetime = date("Y-m-d H:i:s", $timestamp); // Local datetime

        //echo '<br><br>' . $local_datetime;

        //echo '<br><br> Los Angeles:' . date("l h:iA", $timestamp);


        //$date = new DateTime("November 25 2014 0100", new DateTimeZone('America/Phoenix'));



        //echo '<br><br> Arizona:' . date("l h:iA", $date->format('U'));
        //echo '<br><br>' . date("Y-m-d h:iA", $date->format('U'));

        // 2012-07-05 10:43AM





        ?>






    </div>
</div>
