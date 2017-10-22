<?php

/**
 * GroupModel
 * This is basically a simple CRUD (Create/Read/Update/Delete) demonstration.
 */
class GroupModel
{
    public static function getUsersLookingStatus (){
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT looking_for_a_group FROM users WHERE user_id = :user_id";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => Session::get('user_id')));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }
    public static function getPublicProfilesOfUsersInGroup()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id, user_name, user_email, user_active, user_has_avatar FROM users";
        $query = $database->prepare($sql);
        $query->execute();

        $all_users_profiles = array();

        foreach ($query->fetchAll() as $user) {
            $all_users_profiles[$user->user_id] = new stdClass();
            $all_users_profiles[$user->user_id]->user_id = $user->user_id;
            $all_users_profiles[$user->user_id]->user_name = $user->user_name;
            $all_users_profiles[$user->user_id]->user_email = $user->user_email;
            $all_users_profiles[$user->user_id]->user_active = $user->user_active;
            $all_users_profiles[$user->user_id]->user_avatar_link = (Config::get('USE_GRAVATAR') ? AvatarModel::getGravatarLinkByEmail($user->user_email) : AvatarModel::getPublicAvatarFilePathOfUser($user->user_has_avatar, $user->user_id));
        }

        return $all_users_profiles;
    }



    /**
     * Taken away from group model index, may need to be deleted
     */
    public static function getAllBusinesses()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id, business_id, income FROM businesses WHERE user_id = :user_id";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => Session::get('user_id')));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }
    /** get Income range */
    public static function getIncomeRange($income)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT income_range_low, income_range_high, income_level FROM income_range WHERE income_range_low <= :income AND income_range_high >= :income";
        $query = $database->prepare($sql);
        $query->execute(array(':income' => $income));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }


    /**
     * Get all groups
     * @return array an array with several objects (the results)
     */
    public static function getAllGroups()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id, group_id FROM in_group WHERE user_id = :user_id";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => Session::get('user_id')));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }

    public static function getAllInUserGroup(){
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id, group_id FROM in_group WHERE user_id = :user_id";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => Session::get('user_id')));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }

    /**
     * Get all users in a group
     * @return array an array with several objects (the results)
     */
    public static function getAllUsersInGroup($group_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id FROM in_group WHERE group_id = :group_id";
        $query = $database->prepare($sql);
        $query->execute(array(':group_id' => $group_id));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }
    /** Get business income of user by user ID*/
    public static function getOtherUsersIncome($other_user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT income FROM businesses WHERE user_id = :user_id";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $other_user_id));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }

    /**
     * Find Open Groups
     * @return array an array with several objects (the results)
     */
    public static function findOpenGroups()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT open, meeting_day FROM groups WHERE open = 1";
        $query = $database->prepare($sql);
        $query->execute(array(':group_id' => Session::get('group_id')));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }

    /**
     * Find Open Groups for index page
     * @return array an array with several objects (the results)
     */
    public static function findOpenGroupsIndex()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT meeting_day, meeting_hour FROM groups WHERE open = 1";
        $query = $database->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }
    /**
     * Find a users availability who is not logged in, for index page
     * @return array an array with several objects (the results)
     */
    public static function findUserAvailabilityIndex($user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT day, hour FROM availability WHERE user_id = :user_id";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }

    /** Get the email address of user */
    public static function getUsersEmail($user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_email FROM users WHERE user_id = :user_id";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }
    /**
     * Find Open Users
     * @return array an array with several objects (the results)
     */
    public static function findOpenUsers()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT looking_for_a_group, user_id FROM users WHERE user_id != :user_id AND looking_for_a_group = 1";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => Session::get('user_id')));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }
    /**
     * Find Open Users for index page
     * @return array an array with several objects (the results)
     */
    public static function findOpenUsersIndex()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id FROM users WHERE looking_for_a_group = 1 AND user_active = 1";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => Session::get('user_id')));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }

    /**
     * Find a group
     * @return array an array with several objects (the results)
     */
    public static function findAGroup()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id FROM in_group WHERE user_id = :user_id";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => Session::get('user_id')));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }


    /**
     * Get the group_id that matches hour, day and income.
     * @param int $note_id id of the specific note
     * @return object a single object (the result)
     */
    public static function getMatchingGroupID($meeting_hour, $meeting_day)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT group_id FROM groups WHERE open = 1 AND meeting_hour = :meeting_hour AND meeting_day = :meeting_day";
        $query = $database->prepare($sql);
        $query->execute(array(':meeting_hour' => $meeting_hour, ':meeting_day' => $meeting_day));

        // fetch() is the PDO method that gets a single result
        return $query->fetch();
    }

    /**
     * Get the group_id that matches hour, day and income.
     * @param int $note_id id of the specific note
     * @return object a single object (the result)
     */
    public static function checkIfUsersTimeMatches($hour, $day, $user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT availability_id FROM availability WHERE hour = :hour AND day = :day AND user_id = :user_id";
        $query = $database->prepare($sql);
        $query->execute(array(':hour' => $hour, ':day' => $day, ':user_id' => $user_id));

        // fetch() is the PDO method that gets a single result
        return $query->fetch();
    }

    /**
     * Set a note (create a new one)
     * @param string $note_text note text that will be created
     * @return bool feedback (was the note created properly ?)
     */
    public static function createInGroup($group_id)
    {
        if (!$group_id || strlen($group_id) == 0) {
            Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_CREATION_FAILED'));
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO in_group (group_id, user_id) VALUES (:group_id, :user_id)";
        $query = $database->prepare($sql);
        $query->execute(array(':group_id' => $group_id, ':user_id' => Session::get('user_id')));

        if ($query->rowCount() == 1) {
            return true;
        }

        // default return
        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_CREATION_FAILED'));
        return false;
    }

    public static function createOtherUserInGroup($group_id, $user2_id)
    {
        if (!$group_id || strlen($group_id) == 0) {
            Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_CREATION_FAILED'));
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO in_group (group_id, user_id) VALUES (:group_id, :user_id)";
        $query = $database->prepare($sql);
        $query->execute(array(':group_id' => $group_id, ':user_id' => $user2_id));

        if ($query->rowCount() == 1) {
            return true;
        }

        // default return
        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_CREATION_FAILED'));
        return false;
    }

    public static function createAGroup($meeting_day,$meeting_hour)
    {
        if (!$meeting_day || strlen($meeting_day) == 0) {
            Session::add('feedback_negative', Text::get('FEEDBACK_GROUP_CREATION_FAILED'));
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO groups (meeting_day, meeting_hour) VALUES (:meeting_day, :meeting_hour)";
        $query = $database->prepare($sql);
        $query->execute(array(':meeting_day' => $meeting_day, ':meeting_hour' => $meeting_hour ));

        if ($query->rowCount() == 1) {
            $id = $database->lastInsertId();
            return true * $id;
        }

        // default return
        Session::add('feedback_negative', Text::get('FEEDBACK_GROUP_CREATION_FAILED'));
        return false;
    }

    /** Get last row inserted in groups table */
    public static function groupLastInsert(){
        $database = DatabaseFactory::getFactory()->getConnection();

        $query = $database->prepare("...");
        $query->execute();
        $id = $database->lastInsertId();
        return $id;

    }

    /**
 * Get a single note
 * @param int $note_id id of the specific note
 * @return object a single object (the result)
 */
    public static function getNote($note_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id, note_id, note_text FROM notes WHERE user_id = :user_id AND note_id = :note_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => Session::get('user_id'), ':note_id' => $note_id));

        // fetch() is the PDO method that gets a single result
        return $query->fetch();
    }
    /**
     * Get a single note
     * @param int $note_id id of the specific note
     * @return object a single object (the result)
     */
    public static function getBusiness($business_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id, business_id, income FROM businesses WHERE user_id = :user_id AND business_id = :business_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => Session::get('user_id'), ':business_id' => $business_id));

        // fetch() is the PDO method that gets a single result
        return $query->fetch();
    }
    /**
     * Set a note (create a new one)
     * @param string $note_text note text that will be created
     * @return bool feedback (was the note created properly ?)
     */
    public static function createBusiness($income)
    {
        if (strlen($income) == 0) {
            Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_CREATION_FAILED'));
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO businesses (income, user_id) VALUES (:income, :user_id)";
        $query = $database->prepare($sql);
        $query->execute(array(':income' => $income, ':user_id' => Session::get('user_id')));

        if ($query->rowCount() == 1) {
            return true;
        }

        // default return
        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_CREATION_FAILED'));
        return false;
    }

    /**
     * Update an existing note
     * @param int $note_id id of the specific note
     * @param string $note_text new text of the specific note
     * @return bool feedback (was the update successful ?)
     */
    public static function updateBusiness($business_id, $income)
    {
        if (!$business_id) {
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE businesses SET income = :income WHERE business_id = :business_id AND user_id = :user_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':business_id' => $business_id, ':income' => $income, ':user_id' => Session::get('user_id')));

        if ($query->rowCount() == 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_EDITING_FAILED'));
        return false;
    }

    /**
     * Update an existing note
     * @param int $note_id id of the specific note
     * @param string $note_text new text of the specific note
     * @return bool feedback (was the update successful ?)
     */
    public static function turnOffGroupAvailability($group_id)
    {
        if (!$group_id) {
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE groups SET open = 0 WHERE group_id = :group_id";
        $query = $database->prepare($sql);
        $query->execute(array(':group_id' => $group_id));

        if ($query->rowCount() == 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_EDITING_FAILED'));
        return false;
    }

    /**
     * Change looking for group status
     * @param int $note_id id of the specific note
     * @param string $note_text new text of the specific note
     * @return bool feedback (was the update successful ?)
     */
    public static function turnOffLookingForGroupStatus($user_id)
    {

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE users SET looking_for_a_group = 0 WHERE user_id = :user_id";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id));

        if ($query->rowCount() == 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_REMOVE_USER_FROM_LOOKING_FOR_A_GROUP_FAILED'));
        return false;
    }

    public static function getMeetingTime($group_id)
    {

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT meeting_day, meeting_hour FROM groups WHERE group_id = :group_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':group_id' => $group_id));

        // fetch() is the PDO method that gets a single result
        return $query->fetch();
    }



    /**
     * Gets an array that contains all the users in the group except the current user. The array's keys are the user ids.
     * Each array element is an object, containing a specific user's data.
     * The avatar line is built using Ternary Operators, have a look here for more:
     * @see http://davidwalsh.name/php-shorthand-if-else-ternary-operators
     *
     * @return array The profiles of all users
     */
    public static function displayGroupMembers($members){

        $database = DatabaseFactory::getFactory()->getConnection();

        $current_user_id = Session::get('user_id');
        $end_of_where = '';
        $count_or = 0;
        $or = '';
        foreach ($members as $and_where ){
            if ($current_user_id != $and_where->user_id) {
                if ($count_or > 0){
                    $or = ' OR ';
                }
                $end_of_where .= $or . 'user_id = ' . $and_where->user_id;
                ++$count_or;
            }
        }

        $first = 'SELECT user_id, user_name, user_email, user_active, user_has_avatar FROM users WHERE ';

        $and = $first . $end_of_where;
        $current_user_id = Session::get('user_id');

        $sql = $and;
        $query = $database->prepare($sql);
        $query->execute(array(':this_user_id' => Session::get('user_id') ));

        $all_users_profiles = array();

        foreach ($query->fetchAll() as $user) {
            $all_users_profiles[$user->user_id] = new stdClass();
            $all_users_profiles[$user->user_id]->user_id = $user->user_id;
            $all_users_profiles[$user->user_id]->user_name = $user->user_name;
            $all_users_profiles[$user->user_id]->user_email = $user->user_email;
            $all_users_profiles[$user->user_id]->user_active = $user->user_active;
            $all_users_profiles[$user->user_id]->user_avatar_link = (Config::get('USE_GRAVATAR') ? AvatarModel::getGravatarLinkByEmail($user->user_email) : AvatarModel::getPublicAvatarFilePathOfUser($user->user_has_avatar, $user->user_id));
        }
        //echo '<br>';

        return $all_users_profiles;
    }
    public static function sendNewGroupMail($users_emails)
    {
        // create email body
        $body = Config::get('EMAIL_NEW_GROUP_CONTENT') . ' ' . Config::get('URL');
        //echo $users_emails;
        //echo $body;


        // create instance of Mail class, try sending and check
        $mail = new Mail;
        $mail_sent = $mail->sendMail($users_emails, Config::get('EMAIL_NEW_GROUP_FROM_EMAIL'),
            Config::get('EMAIL_NEW_GROUP_FROM_NAME'), Config::get('EMAIL_NEW_GROUP_SUBJECT'), $body
        );
        //echo Config::get('EMAIL_NEW_GROUP_FROM_EMAIL');
        //echo  Config::get('EMAIL_NEW_GROUP_FROM_NAME');
        //echo Config::get('EMAIL_NEW_GROUP_SUBJECT');

        if ($mail_sent) {
            Session::add('feedback_positive', Text::get('FEEDBACK_NEW_GROUP_MAIL_SENDING_SUCCESSFUL'));
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_NEW_GROUP_MAIL_SENDING_ERROR') . $mail->getError() );
        return false;
    }


}




