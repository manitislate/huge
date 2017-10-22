<div class="container">
    <h1>Edit</h1>

    <div class="box">
        <h2>Change this available time slot</h2>

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <?php if ($this->availability) { ?>
            <form method="post" action="<?php echo Config::get('URL'); ?>newguy/editSave">
                <label>Change the day or hour of this entry: </label>
                <!-- we use htmlentities() here to prevent user input with " etc. break the HTML -->
                <input type="hidden" name="availability_id" value="<?php echo htmlentities($this->availability->availability_id); ?>" />
                <input type="text" name="day" value="<?php echo htmlentities($this->availability->day); ?>" />
                <input type="text" name="hour" value="<?php echo htmlentities($this->availability->hour); ?>" />
                <input type="submit" value='Change' />
            </form>
        <?php } else { ?>
            <p>This entry does not exist.</p>
        <?php } ?>
    </div>
</div>
