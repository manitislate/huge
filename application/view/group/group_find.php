<div class="container">
    <h1>NoteController/index</h1>
    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h3>What happens here ?</h3>
        <p>
            This is just a simple CRUD implementation. Creating, reading, updating and deleting things.
        </p>

        <?php  // if ($this->availability) {
            //foreach($this->availability as $key => $value) {
            //    echo  $value->hour;
            //    $hour = $value->hour;
            //    GroupController::checkAvailabilityAndGroup($hour);
                
                /** Search each group with an 'open' of 1, and where available_day and hour = $vallue->day and user hour
                 * and where user income >= group's low income and user income is <= group's high income.
                 * maybe if it is a match, then it will send to the write page. (where it can add user to groups table
                 * and check if the group is full, to remove open group value.*/



            //    if ($value->hour == 1600){
            //        echo 'tis true you match!';
                    /**Redirect::to('group_add user to group and check for max group size'); */
            //    }
            //    else {
            //        echo 'no match';
            //    }
            //} ?>
                </tbody>
            </table>
            <?php // } else { ?>
                <div>We have a match!</div>
            <?php } ?>
    </div>
</div>
