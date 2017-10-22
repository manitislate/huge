<div class="container">
    <h1>Set Timezone</h1>

    <div class="box">
        <h2>Your Timezone Has Not Been Set Yet</h2>

        <p>
            Please select your timezone.
        </p>

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <?php
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

        ?>

        <form method="post" action="<?php echo Config::get('URL');?>newguy/addIndexTime">
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


            <input type="hidden" name="day" value="<?php echo $this->day; ?>">
            <input type="hidden" name="hour" value="<?php echo $this->hour; ?>">


            <input type="submit" value='Set Time Zone' autocomplete="off" />
        </form>
    </div>
</div>
