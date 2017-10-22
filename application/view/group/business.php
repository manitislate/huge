<div class="container">
    <h1>NoteController/edit/:note_id</h1>

    <div class="box">
        <h2>Edit a note</h2>

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <?php if ($this->businesses) { ?>
            <table class="note-table">
                <thead>
                <tr>
                    <td>Business Income</td>
                    <td>EDIT</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach($this->businesses as $key => $value) {



                    ?>
                    <tr>
                        <td><?= htmlentities($value->income); ?></td>
                        <td><a href="<?= Config::get('URL') . 'group/edit/' . $value->business_id; ?>">Edit</a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div>
                <p>
                    Your business income is not set yet. Please let us know how much you business makes so we can match
                    you with others in your range of income. Masterminds work best with others who are closest to your
                    business's income.
                </p>
                <p>
                <form method="post" action="<?php echo Config::get('URL');?>group/create">
                    <label>Business Income: </label><input type="text" name="income"  />
                    <input type="submit" value='Add my business income' autocomplete="off" />
                </form>
                </p>
            </div>
        <?php } ?>
    </div>
</div>
