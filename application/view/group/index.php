<div class="container">
    <h1>Find a Group</h1>
    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>
        <?php
            if (isset($this->sorry)){ ?>
                <h3>Sorry, We could not find a match yet.</h3>
                <p>You've done your part, now just sit back and relax. You will be notified as soon as I find
                another user to join you in a mastermind group.</p>

                <?php
                if($this->jv{0}->jv == 2) {?>


                <?php }
                else { ?>
                    <p><b>Do You Believe in Giving Back?</b></p>
                    <p>I do. I made this site as my way of giving back to the one who helped me find a mastermind.
                    I encourage you to keep the giving chain going. You can make it easy for others to find a mastermind
                    with a simple tweet, "I found my mastermind at www.iLOVEmasterminds.com"</p>
                    <p><b>Join the Community</b></p>
                    <p>Come on over to my <a href="https://www.facebook.com/groups/1634104163469609/">private facebook group</a>. Help someones business, by brainstorming ideas, and you may be picked
                        to be on the hotseat next!</p>
                <?php } ?>


            <?php }?>
        <!-- check if user has set availability -->
        <?php if ($this->availability) { ?>
            
            <!-- If the user is in a group, display the page -->
            <?php if ($this->in_group) {
                Redirect::to('group/displayGroups');
            }

            //<!-- lets find a group -->
             elseif (!isset ($this->sorry )) { ?>
                <div>
                    <p>
                        To find a group, click the button below.
                    </p>
                    <p>
                        <form method="post" action="<?php echo Config::get('URL');?>group/find">
                            <input type="submit" value='Find a group' autocomplete="off" />
                        </form>
                    </p>
                    </div>
                <?php } ?>

        <!-- Since the user has not set availability, let user click over to availability tab -->
        <?php } else { ?>
            <h3>Please Set Your Availability</h3>
            <div>Availability must be set before finding a mastermind group.</div>
                <form method="post" action="<?php echo Config::get('URL'); ?>newguy/index">
                <input type="submit" value='Click Here to Set Availability' />
        <?php } ?>
    </div>
</div>
