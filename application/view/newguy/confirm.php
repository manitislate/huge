<div class="container">
    <h1>Confirmation</h1>
    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h3>Please Confirm</h3>

        <p>
            Before I add you to a group, I would like to confirm a few things.
        </p>

        <?php
        //tell the user their time, and weather this time is in their time
        $dt = new DateTime();
        //$dt->setTimestamp($currentTime);

        //just for the fun: what would it be in UTC?
        $would_be = $dt->format('l g:i A');

        $dt->setTimezone(new DateTimeZone($_SESSION['tz']));
        $is = $dt->format('l g:i A');

        //if their time can be detected, show the time and ask for the confirmation click below
        if (isset ($_SESSION['tz'])) { ?>
            <p>
                I can see that <b>your current time is: <?php echo $is; ?></b> .
            </p>
            <p>
                If this is <i>incorrect</i>, then the confirmation time below will also be wrong by the same amount of time.
            </p>
        <?php
        }
        else {?>
            <p>
                I could not detect your timezone, so I'm using UTC time. Currently it is: <?php echo $would_be; ?> </b><i>in UTC time</i>.
            </p>
            <?php  } ?>

    <h4>Click below to confirm</h4>

        <form method="post" action="<?php echo Config::get('URL') . 'newguy/addIndexTime';?>">
            <input type="hidden" name="day" value="<?php echo ($_POST['day']); ?>">
            <input type="hidden" name="hour" value="<?php echo ($_POST['hour']); ?>">
            <input type="submit" value='<?php echo ($_POST['userTime']); ?>' autocomplete="off" />
        </form>






