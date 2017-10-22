<div class="container">
    <h1>Business Revenue</h1>

    <div class="box">
        <h2>Edit Business Revenue</h2>

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>
        <h3>Please set your business average revenue over the last two months</h3>
        <p>
            If there have been any changes to your business's revenue, you may update how much your business is making now.
        </p>
        <h3>There are no grantees that your group will not kick you out!</h3>
        <p>
            Again, I don't want to be a downer here, but it's important to be honest about how much revenue your business
            makes. Please remember that masterminds work best with others who are closest to your business's income.
            If others in your group find out that you are not telling the truth, they may just decide to ban you
            from further communication.
        </p>

        <?php if ($this->business) { ?>
            <form method="post" action="<?php echo Config::get('URL'); ?>group/editSave">
                <label>Change my business average monthly revenue: </label>
                <!-- we use htmlentities() here to prevent user input with " etc. break the HTML -->
                <input type="hidden" name="business_id" value="<?php echo htmlentities($this->business->business_id); ?>" />
                <input type="text" name="income" value="<?php echo htmlentities($this->business->income); ?>" />
                <input type="submit" value='Change' />
            </form>
        <?php } else { ?>
            <p>Business Income does not exist.</p>
        <?php } ?>
    </div>
</div>
