<div class="container">
    <h1>Group</h1>
    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h3>These are the people in your group</h3>
        <div>
            <p>Congratulations! You have a mastermind. Below is the list of all the people in your mastermind. I sent them
            all an email letting them know that you have now joined them.</p>
            <p>Make sure you send them an email, say hello and introduce yourself to them.</p>

        </div>
        <div>
            <table class="overview-table">
                <thead>
                <tr>
                    <td>Avatar</td>
                    <td>Username</td>
                    <td>User's email</td>
                </tr>
                </thead>
                <?php foreach ($this->users as $user) { ?>
                    <tr class="<?= ($user->user_active == 0 ? 'inactive' : 'active'); ?>">
                        <td class="avatar">
                            <?php if (isset($user->user_avatar_link)) { ?>
                                <img src="<?= $user->user_avatar_link; ?>" />
                            <?php } ?>
                        </td>
                        <td><?= $user->user_name; ?></td>
                        <td><?= $user->user_email; ?></td>
                    </tr>
                <?php } ?>
            </table>

            <h3>Your Group Meets on <?php

                /** Convert to users time
                 *  @var  $utc */
                date_default_timezone_set('America/Los_Angeles');
                $utc = 'last ' . $this->meeting_time->meeting_day . ' ' . $this->meeting_time->meeting_hour;
                //echo $utc . '<br>';
                //echo $this->meeting_time->meeting_hour;
                $timestamp = strtotime($utc);
                $datetime = new DateTime();
                $datetime->setTimestamp($timestamp);
                //cho '<br>' . $datetime->getTimezone()->getName() . '<br>';
                //echo $datetime->format(DATE_ATOM). '<br>';

                $new_date = new DateTimeZone($this->time_offset{0}->time_zone);
                $datetime->setTimezone($new_date);
                //echo $datetime->getTimezone()->getName(). '<br>';
                echo $datetime->format('l'). ' at ' . $datetime->format('g:i A');

                ?></h3>
            <?php
            if($this->jv{0}->jv == 2) {?>


            <?php }
            else { ?>
                <p><b>Do You Believe in Giving Back?</b></p>
                <p>I do. I made this site as my way of giving back to the one who helped me find a mastermind.
                    I encourage you to keep the giving chain going. You can make it easy for others to find a mastermind
                    with a simple tweet, "I found my mastermind at www.iLOVEmasterminds.com."</p>
                <p><b>Join the Community</b></p>
                <p>Come on over to my <a href="https://www.facebook.com/groups/1634104163469609/">private facebook group</a>. Help someones business, by brainstorming ideas, and you may be picked
                    to be on the hotseat next!</p>
            <?php } ?>
        </div>
    </div>
</div>
