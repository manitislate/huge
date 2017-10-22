<?php

/**
 * NewguyModel
 * This is basically a simple CRUD (Create/Read/Update/Delete) demonstration.
 */
class NewguyModel
{
    /**
     * Get all availability
     * @return array an array with several objects (the results)
     */
    public static function getAllAvailability()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id, availability_id, day, hour FROM availability WHERE user_id = :user_id ORDER BY FIELD(day, 'Sunday', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'), hour ASC ; ";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => Session::get('user_id')));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }

    /**
     * check to see if selected hour and day are already in the list
     * @return array an array with several objects (the results)
     */
    public static function checkAvailability($day, $hour)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT  day, hour FROM availability WHERE user_id = :user_id AND hour = :hour AND day = :day ";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => Session::get('user_id'), ':hour' => $hour, ':day' => $day ));

        if ($query->rowCount() == 1) {
            return true;
        }


        return false;
    }

    public static function getTimeZone (){
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT time_zone FROM users WHERE user_id = :user_id ";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => Session::get('user_id')));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }

    /**
     * Set users time zone
     * @param int $note_id id of the specific note
     * @param string $note_text new text of the specific note
     * @return bool feedback (was the update successful ?)
     */
    //public static function setTimeZone($timezone, $useDaylightTime)
    //{
        //if (!$timezone || !$timezone) {
          //  return false;
        //}

        //$database = DatabaseFactory::getFactory()->getConnection();

        //$sql = "UPDATE users SET time_zone = :time_zone WHERE time_zone = :time_zone, use_daylight_time = :use_daylight_time AND user_id = :user_id LIMIT 1";
        //$query = $database->prepare($sql);
        //$query->execute(array(':time_zone' => $time_zone, ':use_daylight_time' => $useDaylightTime, ':user_id' => Session::get('user_id')));

      //  if ($query->rowCount() == 1) {
      //      return true;
      //  }

    //    Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_EDITING_FAILED'));
    //    return false;
    //}


    /**
     * Set users time zone
     * @param int $note_id id of the specific note
     * @param string $note_text new text of the specific note
     * @return bool feedback (was the update successful ?)
     */
    public static function setTimeZone($timezone)
    {
        if (!$timezone || !$timezone) {
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE users SET time_zone = :time_zone WHERE user_id = :user_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':time_zone' => $timezone,':user_id' => Session::get('user_id')));

        if ($query->rowCount() == 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_EDITING_FAILED'));
        return false;
    }
    public static function setTimeZoneIndex($timezone,$hour,$day)
    {
        if (!$timezone || !$timezone) {
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE users SET time_zone = :time_zone WHERE user_id = :user_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':time_zone' => $timezone,':user_id' => Session::get('user_id')));


        //now continue onto creating from index
        NewguyController::createIndex($hour,$day);

        if ($query->rowCount() == 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_EDITING_FAILED'));
        return false;
    }

    /**
     * Get a single day and hour
     * @param int $availability_id id of the specific day and hour
     * @return object a single object (the result)
     */
    public static function getAvailability($availability_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id, availability_id, day, hour FROM availability WHERE user_id = :user_id AND availability_id = :availability_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => Session::get('user_id'), ':availability_id' => $availability_id));

        // fetch() is the PDO method that gets a single result
        return $query->fetch();
    }

    /**
     * Set availability (create a new one)
     * @param string $day day and hour that will be created
     * @return bool feedback (was the note created properly ?)
     */
    public static function createAvailability($day, $hour)
    {
        if (!$day || strlen($day) == 0 || !$hour || strlen($hour) == 0) {
            Session::add('feedback_negative', Text::get('FEEDBACK_AVAILABILITY_CREATION_FAILED'));
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO availability (day, hour, user_id) VALUES (:day, :hour , :user_id)";
        $query = $database->prepare($sql);
        $query->execute(array(':day' => $day, ':hour' => $hour, ':user_id' => Session::get('user_id')));

        if ($query->rowCount() == 1) {
            return true;
        }

        // default return
        Session::add('feedback_negative', Text::get('FEEDBACK_AVAILABILITY_CREATION_FAILED'));
        return false;
    }

    /**
     * Update an existing note
     * @param int $note_id id of the specific note
     * @param string $note_text new text of the specific note
     * @return bool feedback (was the update successful ?)
     */
    public static function updateNewguy($availability_id, $day, $hour)
    {
        if (!$availability_id || !$day || !$hour) {
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE availability SET day = :day, hour = :hour WHERE availability_id = :availability_id AND user_id = :user_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':availability_id' => $availability_id, ':day' => $day, ':hour' => $hour, ':user_id' => Session::get('user_id')));

        if ($query->rowCount() == 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_AVAILABILITY_EDITING_FAILED'));
        return false;
    }

    /**
     * Delete a specific note
     * @param int $note_id id of the note
     * @return bool feedback (was the note deleted properly ?)
     */
    public static function deleteAvailability($availability_id)
    {
        if (!$availability_id) {
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "DELETE FROM availability WHERE availability_id = :availability_id AND user_id = :user_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':availability_id' => $availability_id, ':user_id' => Session::get('user_id')));

        if ($query->rowCount() == 1) {
            return true;
        }

        // default return
        Session::add('feedback_negative', Text::get('FEEDBACK_AVAILABILITY_DELETION_FAILED'));
        return false;
    }
}
