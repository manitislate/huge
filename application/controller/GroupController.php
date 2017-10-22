<?php

/**
 * The note controller: Just an example of simple create, read, update and delete (CRUD) actions.
 */
class GroupController extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct()
    {
        parent::__construct();

        // VERY IMPORTANT: All controllers/areas that should only be usable by logged-in users
        // need this line! Otherwise not-logged in users could do actions. If all of your pages should only
        // be usable by logged-in users: Put this line into libs/Controller->__construct
        Auth::checkAuthentication();
    }

    /**
     * This method controls what happens when you move to /note/index in your app.
     * Gets all notes (of the user).
     */
    public function index()
    {
        $this->View->render('group/index', array(
            'availability' => NewguyModel::getAllAvailability(),
            'in_group' => GroupModel::getAllGroups(),
            'jv' => JvRegistrationModel::getJvValue()
        ));
    }

    public function displayGroups(){
        $user_group_id = GroupModel::getAllInUserGroup();
        //var_dump($user_group_id);
        $all_users_in_group = GroupModel::getAllUsersInGroup($user_group_id{0}->group_id);
        //var_dump($user_group_id{0}->group_id);
        //var_dump($all_users_in_group);
        //var_dump(GroupModel::displayGroupMembers($all_users_in_group));
        GroupModel::displayGroupMembers($all_users_in_group);
        //GroupModel::getMeetingTime($user_group_id{0}->group_id);

        $this->View->render ('group/display', array(
               'users' => GroupModel::displayGroupMembers($all_users_in_group),
            'meeting_time' => GroupModel::getMeetingTime($user_group_id{0}->group_id),
            'time_offset' => NewguyModel::getTimeZone(),
            'jv' => JvRegistrationModel::getJvValue()
        ));



    }

    /**
     * This method controls what happens when you move to /dashboard/create in your app.
     * Creates a new note. This is usually the target of form submit actions.
     * POST request.
     */
    //public function create()
    //{
    //    GroupModel::createBusiness(Request::post('income'));
    //    Redirect::to('group');
    //}

    /**
     * This method controls what happens when you move to /group/find in your app.
     * Checks if a group exist with the same range of income level, and if they meet at the same day and hour as user availability,
     * and if they have available slots (based on group size).
     * If available, the user is added to the group.
     * If no groups are found it finds another person that matches availability and income.
     * It will then create a new group and assign each person to that group id.
     */
    public function find()
    {
        /** get users income
         * @var  $income */
        //$income = GroupModel::getAllBusinesses();

        /** get users income range
         * @var  $inc_range */
        //$inc_range = GroupModel::getIncomeRange($income[0]->income);

        /** Check each of users available hours for a matching group or person
         * return that group's ID. */
        foreach(NewguyModel::getAllAvailability() as $key => $value) {
            /**Check each of users available hours for an open and matching group */
            if (!is_bool(GroupModel::getMatchingGroupID($value->hour, $value->day))  ){
                $than = GroupModel::getMatchingGroupID($value->hour, $value->day);
            }
            else {
                /** If no groups were found, find users who are not in a group
                 * @var  $key
                 * @var  $value2
                 */
                foreach (GroupModel::findOpenUsers() as $key => $value2 ){
                    /** Check for a user with matching availability */
                    if (!is_bool(GroupModel::checkIfUsersTimeMatches($value->hour,$value->day,$value2->user_id) )){
                        /** Now check income range match*/
                        //$inc_user2 = GroupModel::getOtherUsersIncome($value2->user_id);
                        //if ($inc_user2[0]->income <= $inc_range[0]->income_range_high && $inc_user2[0]->income >= $inc_range[0]->income_range_low ) {
                            //we have a match lets jot down the matching user's id, and income range
                            $user2_id = $value2->user_id;
                            //$inc_low = $inc_range[0]->income_range_low;
                            //$inc_high = $inc_range[0]->income_range_high;
                            $group_day = $value->day;
                            $group_hour = $value->hour;
                        //}
                    }
                }
            }

        }

        /**If a matching group was found, add user and group together,
         * check if group is full,
         * remove user from looking for a group status
         * email users in group */
        if (isset($than)){
            /** Count the number of users in a group */
            $total = 0;
            foreach(GroupModel::getAllUsersInGroup($than->group_id) as $key => $value) {
                /** Email users in group of the new addition
                 *  grab each users email address and send. */
                //echo 'user value user id: '. $value->user_id . '<br>';
                $user_email = GroupModel::getUsersEmail($value->user_id);
                //echo 'user email: '. $user_email[0]->user_email . '<br>';
                //var_dump($user_email[0]->user_email);
                GroupModel::sendNewGroupMail($user_email[0]->user_email);

                //echo $value->user_id . '<br>';
                //var_dump($value);
                /** Count number of users in group to see if we need to close the group from new members being added */
                ++$total;
            }
            /** If there are 4 or more users, remove group's availability then add user to group */
            if ($total >= 4){
                GroupModel::turnOffGroupAvailability($than->group_id);
            }
            GroupModel::turnOffLookingForGroupStatus(Session::get('user_id'));

            GroupModel::createInGroup($than->group_id);



            Redirect::to('group');
        }



        /** If a matching user was found...*/
        if (isset($user2_id)){
            /** add a group to the groups page with income range
             * then grab that groups ID
             * and sent it to $new_group_id*/
            $new_group_id = GroupModel::createAGroup($group_day,$group_hour);
            /** Assign current user to that group */
            GroupModel::createInGroup($new_group_id);
            /** Assign other user to that group */
            GroupModel::createOtherUserInGroup($new_group_id, $user2_id);
            /** Get other users email */
            $user2_email = GroupModel::getUsersEmail($user2_id);
            /** Send other user an email */
            GroupModel::sendNewGroupMail($user2_email[0]->user_email);
            /** Turn off current user's looking_for_a_group status */
            GroupModel::turnOffLookingForGroupStatus(Session::get('user_id'));
            /** Turn off other user's looking_for_a_group status */
            GroupModel::turnOffLookingForGroupStatus($user2_id);
        }



        if (!isset($user2_id) && !isset($than) ){
            /** This is a trick to get sorry equal to one so we can notify the user that no match was found
             *  by using the user's looking for a group value */
            $this->View->render ('group/index', array(
                'sorry' => GroupModel::getUsersLookingStatus(),
                'availability' => NewguyModel::getAllAvailability(),
                'in_group' => GroupModel::getAllGroups(),
                'jv' => JvRegistrationModel::getJvValue()
            ));
        }
        else Redirect::to('group');


    }




    /**
     * This method controls what happens when you move to /note/edit(/XX) in your app.
     * Shows the current content of the note and an editing form.
     * @param $note_id int id of the note
     */

    public function checkAvailabilityAndGroup($hour){
        GroupModel::getMatchingGroup($hour);
    }

    /** Probably should delete this
     *  */
    public function edit($business_id)
    {
        $this->View->render('group/edit', array(
            'business' => GroupModel::getBusiness($business_id)
        ));
    }

    /**
     * Probably should delete this
     */
    public function editSave()
    {
        GroupModel::updateBusiness(Request::post('business_id'), Request::post('income'));
        Redirect::to('group');
    }


}
