<div class="container" xmlns="http://www.w3.org/1999/html">
    <h1>Why I Made ILoveMasterminds.com</h1>
    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

         <p> When I first started, I had a lot of trouble finding a mastermind group. It wasn't until someone took the time
             to help me that I was able to get in a good group. Now I just want to give back and that's the purpose of this site.
         </p>
        <p>
            You will need to log in to use the mastermind finding tool.
        </p>

        <h2>Two Ways To Find A Mastermind</h2>

        <h3>1. Choose a group that meets on:</h3>
    </div>
    <?php

    if (isset($_POST['timezone']))
    {
        $_SESSION['tz'] = $_POST['timezone'];
        exit;
    }
    //detect timezone
    if (!isset($_SESSION['tz'])) {
        echo "<br>Sorry, I could not detect a timezone. Timezone will be set to Universal Time Zone.<br>";
    }

    ?>

    <div>

        <?php
        //determine if user is logged in to set redirect link
        if (!(Session::userIsLoggedIn())) {
            $link = 'login';
            $add_availability =  Config::get('URL'). 'login';
            //Session::add('feedback_negative', Text::get('FEEDBACK_LOGIN_FIRST'));
        }
        else {
            $link = 'newguy/confirm';
            $add_availability = '../newguy';
        }

        ?>


        <div>
            <table class="overview-table">
                <thead>
                <tr>
                    <td>Monday</td>
                    <td>Tuesday</td>
                    <td>Wednesday</td>
                    <td>Thursday</td>

                    <td>Friday</td>
                    <td>Saturday</td>
                    <td>Sunday</td>
                </tr>
                </thead>
                    <tr >
                        <td valign="top">
                            <?php  foreach ($this->open_groups["Monday"] as $key => $value) { ?>


                            <form method="post" action="<?php echo Config::get('URL') . $link;?>">


                                <input type="hidden" name="day" value="Monday">
                                <?php
                                $army_time_str = $value;
                                $regular_time_str = date( 'g:i A', strtotime( $army_time_str ) );
                                ?>
                                <input type="hidden" name="userTime" value="Monday <?php echo $regular_time_str; ?>">
                                <input type="hidden" name="hour" value="<?php echo $value; ?>">
                                <input type="submit" value='<?php echo $regular_time_str; ?>' autocomplete="off" />
                            </form> <?php } ?>
                        </td>
                        <td valign="top">
                            <?php  foreach ($this->open_groups["Tuesday"] as $key => $value) { ?>


                                <form method="post" action="<?php echo Config::get('URL') . $link;?>">


                                    <input type="hidden" name="day" value="Tuesday">
                                    <?php
                                    $army_time_str = $value;
                                    $regular_time_str = date( 'g:i A', strtotime( $army_time_str ) );
                                    ?>
                                    <input type="hidden" name="userTime" value="Tuesday <?php echo $regular_time_str; ?>">
                                    <input type="hidden" name="hour" value="<?php echo $value; ?>">
                                    <input type="submit" value='<?php echo $regular_time_str; ?>' autocomplete="off" />
                                </form> <?php } ?>
                        </td>
                        <td valign="top">
                            <?php  foreach ($this->open_groups["Wednesday"] as $key => $value) { ?>


                                <form method="post" action="<?php echo Config::get('URL') . $link;?>">


                                    <input type="hidden" name="day" value="Wednesday">
                                    <?php
                                    $army_time_str = $value;
                                    $regular_time_str = date( 'g:i A', strtotime( $army_time_str ) );
                                    ?>
                                    <input type="hidden" name="userTime" value="Wednesday <?php echo $regular_time_str; ?>">
                                    <input type="hidden" name="hour" value="<?php echo $value; ?>">
                                    <input type="submit" value='<?php echo $regular_time_str; ?>' autocomplete="off" />
                                </form> <?php } ?>
                        </td>
                        <td valign="top">
                            <?php  foreach ($this->open_groups["Thursday"] as $key => $value) { ?>


                                <form method="post" action="<?php echo Config::get('URL') . $link;?>">


                                    <input type="hidden" name="day" value="Thursday">
                                    <?php
                                    $army_time_str = $value;
                                    $regular_time_str = date( 'g:i A', strtotime( $army_time_str ) );
                                    ?>
                                    <input type="hidden" name="userTime" value="Thursday <?php echo $regular_time_str; ?>">
                                    <input type="hidden" name="hour" value="<?php echo $value; ?>">
                                    <input type="submit" value='<?php echo $regular_time_str; ?>' autocomplete="off" />
                                </form> <?php } ?>
                        </td>
                        <td valign="top">
                            <?php  foreach ($this->open_groups["Friday"] as $key => $value) { ?>


                                <form method="post" action="<?php echo Config::get('URL') . $link;?>">


                                    <input type="hidden" name="day" value="Friday">
                                    <?php
                                    $army_time_str = $value;
                                    $regular_time_str = date( 'g:i A', strtotime( $army_time_str ) );
                                    ?>
                                    <input type="hidden" name="userTime" value="Friday <?php echo $regular_time_str; ?>">
                                    <input type="hidden" name="hour" value="<?php echo $value; ?>">
                                    <input type="submit" value='<?php echo $regular_time_str; ?>' autocomplete="off" />
                                </form> <?php } ?>
                        </td>
                        <td valign="top">
                            <?php  foreach ($this->open_groups["Saturday"] as $key => $value) { ?>


                                <form method="post" action="<?php echo Config::get('URL') . $link;?>">


                                    <input type="hidden" name="day" value="Saturday">
                                    <?php
                                    $army_time_str = $value;
                                    $regular_time_str = date( 'g:i A', strtotime( $army_time_str ) );
                                    ?>
                                    <input type="hidden" name="userTime" value="Saturday <?php echo $regular_time_str; ?>">
                                    <input type="hidden" name="hour" value="<?php echo $value; ?>">
                                    <input type="submit" value='<?php echo $regular_time_str; ?>' autocomplete="off" />
                                </form> <?php } ?>
                        </td>
                        <td valign="top">
                            <?php  foreach ($this->open_groups["Sunday"] as $key => $value) { ?>


                                <form method="post" action="<?php echo Config::get('URL') . $link;?>">


                                    <input type="hidden" name="day" value="Sunday">
                                    <?php
                                    $army_time_str = $value;
                                    $regular_time_str = date( 'g:i A', strtotime( $army_time_str ) );
                                    ?>
                                    <input type="hidden" name="userTime" value="Sunday <?php echo $regular_time_str; ?>">
                                    <input type="hidden" name="hour" value="<?php echo $value; ?>">
                                    <input type="submit" value='<?php echo $regular_time_str; ?>' autocomplete="off" />
                                </form> <?php } ?>
                        </td>
                    </tr>
            </table>
        </div>

    </div>

    <div>
        <h3>2. Or..add your time to the list</h3>

        <p>
            <a href="<?php echo $add_availability?>" >click here to add your time</a>
        </p>
    </div>




</div>