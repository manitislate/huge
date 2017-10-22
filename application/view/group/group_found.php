<div class="container">
    <h1>NoteController/edit/:note_id</h1>

    <div class="box">
        <h2>Now we write the match to a group!</h2>

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <?php
        echo '<br>';
        echo $value->group_id[$key];
?>

       <p>Sorry, no one has matched your availability and income range. You will be notified via email as soon as a match is found.</p>
    </div>
</div>
