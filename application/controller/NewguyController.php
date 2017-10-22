<?php

/**
 * The note controller: Just an example of simple create, read, update and delete (CRUD) actions.
 */
class NewguyController extends Controller
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
        $this->View->render('newguy/index', array(
            'availability' => NewguyModel::getAllAvailability(),
            'time_offset' => NewguyModel::getTimeZone()
        ));
    }

    public function confirm() {
        $this->View->render('newguy/confirm');
    }

    public function twogroups(){
        $this->View->render('newguy/twogroups');
    }
    public function settimezonepage($hour,$day){
        $this->View->render('newguy/settimezonepage', array (
            'hour' => $hour,
            'day' => $day
        ));
    }
    public function setTimeZone()
    {
        //$values = Request::post('time_zone');
        //echo Request::post('time_zone');
        //$values = explode(', ', $values);
        //$value1 = $values[0];
        //$value2 = $values[1];
        //echo $value1;
        //echo $value2;
        //NewguyModel::setTimeZone(Request::post('time_zone'), Request::post('useDaylightTime') );
        NewguyModel::setTimeZone(Request::post('time_zone'));
        //echo Request::post('time_zone');

        $hour = Request::post('hour');
        $day = Request::post('day');
        if (isset ($hour)) {
            NewguyController::createFromIndex($day,$hour);

        }
        else {
            Redirect::to('newguy');
        }
    }
    /**
     * This method controls what happens when you move to /dashboard/create in your app.
     * Creates a new note. This is usually the target of form submit actions.
     * POST request.
     */
    public function createIndex($hour, $day)
    {

        /** Check to see if that hour is already reserved */
        if ( !(NewguyModel::checkAvailability($day,$hour)) ) {
            NewguyModel::createAvailability($day, $hour);
        }
        //now lets add user to group
        Redirect::to('group/find');
    }

    /**
     * This method controls what happens when you move to /dashboard/create in your app.
     * Creates a new note. This is usually the target of form submit actions.
     * POST request.
     */
    public function create()
    {
        $time_zone = NewguyModel::getTimeZone();
        //var_dump ($time_zone);
        echo $time_zone{0}->time_zone;
        //echo '<br> hour: ' . Request::post('hour');
        //echo '<br> day: ' . Request::post('day');
        $hour = Request::post('hour');

        /** Convert to server timezone (LA) */
        //date_default_timezone_set('America/Los_Angeles');
        date_default_timezone_set($time_zone{0}->time_zone);

        //$MNTTZ = new DateTimeZone($time_zone{0}->time_zone);
        $utc = 'last ' . Request::post('day') . ' ' .Request::post('hour');
        $timestamp = strtotime($utc);
        //echo '<br>' . $timestamp;
        //$local_datetime = date("Y-m-d H:i:s", $timestamp); // Local datetime

        //echo '<br><br>' . $local_datetime;

        //echo '<br><br>' . $time_zone{0}->time_zone . ' : ' . date("l h:iA", $timestamp);
        //echo '<br>' . $time_zone{0}->time_zone . ' : ' . date("Y-m-d h:iA", $timestamp);


        date_default_timezone_set($time_zone{0}->time_zone);

        $datetime = new DateTime();
        $datetime->setTimestamp($timestamp);
        //echo '<br>' . $datetime->getTimezone()->getName() . '<br>';
        //echo $datetime->format(DATE_ATOM). '<br>';

        $la_time = new DateTimeZone('America/Los_Angeles');
        $datetime->setTimezone($la_time);
        //echo $datetime->getTimezone()->getName(). '<br>';
        //echo $datetime->format('l'). '<br>';
        //echo $datetime->format('Hi'). '<br>';


        //$date = new DateTime($utc, new DateTimeZone('America/Los_Angeles'));
        //echo '<br><br>America/Los_Angeles :' . date("l h:iA", $date->format('U'));
        //echo '<br><br>' . date("Y-m-d h:iA", $date->format('U'));

        $value_day = $datetime->format('l');
        //echo '<br>Day: ' . $value_day;
        $value_hour = $datetime->format('Hi');
        //echo '<br>Hour: ' . $value_hour;



            /** Convert time zone
            $converted_hour = $hour + $time_zone{0};
            echo '<br> converted hour: ' . $converted_hour;

            if ($converted_hour < 0){
                $value_hour = 2400 + $converted_hour;
                $value_day = Request::post('day') -1;
                if ($value_day == 0){
                    $value_day = 7;
                }
            }
            if ($converted_hour > 2400){
                $value_hour = $converted_hour - 2400;
                $value_day = Request::post('day') + 1;
                if ($value_day == 8){
                    $value_day = 1;
                }
            }
            if ($converted_hour > 0 && $converted_hour < 2400){
                $value_hour = $converted_hour;
            }*/

        /** Check to see if that hour is already reserved */
        if ( !(NewguyModel::checkAvailability($value_day,$value_hour)) ) {
            NewguyModel::createAvailability($value_day, $value_hour);
        }
        Redirect::to('newguy');
    }
    /**
     * This method controls what happens when you move to /dashboard/create in your app.
     * Creates a new note. This is usually the target of form submit actions.
     * POST request.
     */
    public function createFromIndex($day,$hour)
    {

        /** Check to see if that hour is already reserved */
        if ( !(NewguyModel::checkAvailability($day,$hour)) ) {
            NewguyModel::createAvailability($day, $hour);
        }
        Redirect::to('newguy/createindex');
    }
    /**
     * This method controls what happens when you move to /note/edit(/XX) in your app.
     * Shows the current content of the note and an editing form.
     * @param $note_id int id of the note
     */
    public function edit($availability_id)
    {
        $this->View->render('newguy/edit', array(
            'availability' => NewguyModel::getAvailability($availability_id)
        ));
    }

    /**
     * This method controls what happens when you move to /note/editSave in your app.
     * Edits a note (performs the editing after form submit).
     * POST request.
     */
    public function editSave()
    {
        /** Check for duplicates */
        if (!NewguyModel::updateNewguy(Request::post('availability_id'), Request::post('day'), Request::post('hour')) ){
            NewguyModel::updateNewguy(Request::post('availability_id'), Request::post('day'), Request::post('hour'));
            Redirect::to('newguy');
        }

    }

    /**
     * This method controls what happens when you move to /note/delete(/XX) in your app.
     * Deletes a note. In a real application a deletion via GET/URL is not recommended, but for demo purposes it's
     * totally okay.
     * @param int $note_id id of the note
     */
    public function delete($availability)
    {
        NewguyModel::deleteAvailability($availability);
        Redirect::to('newguy');
    }




    /**
     * This needs to change to start the
     */
    public function addIndexTime()
    {
        //first lets check to see if the user is in a group already

        //if they are, then send them to a sorry page
        if (GroupModel::getAllGroups()) {
            Redirect::to('newguy/twogroups');
         }
        //if they are, then lets move on to the next step
        else {
            //now check to see if the user's timezone is set
            $isTimezoneSet = NewguyModel::getTimeZone();

            //if they have not set their time zone yet...
            if (!isset($isTimezoneSet{0}->time_zone)){
                //lets see if they are being sent here from settimezonepage
                if (isset($_POST['time_zone'])){
                    //since they are being sent from settimezonepage
                    //add timezone to user's database
                    //setTimeZoneIndex will send the hour and day
                    //to createIndex
                    //function to continue the process
                    NewguyModel::setTimeZoneIndex($_POST['time_zone'],$_POST['hour'], $_POST['day']);
                }

                //else send them to a page to set it
                //the form will redirect back to this function
                //to continue on in the process
                else {
                    NewguyController::setTimeZonePage($_POST['hour'], $_POST['day']);
                }

            }
            //now we can add the hour to the users availability
            //and then add to the group or user that matches the time slot
            else {
                //add hour to availability
                //
                //add user to group or person
                //by sending them to group/find in this controller
                NewguyController::createIndex($_POST['hour'], $_POST['day']);
            }

        }




        //$this->View->render('newguy/createIndex', array(
        //    'in_group' => GroupModel::getAllGroups(),
        //    'time_offset' => NewguyModel::getTimeZone()
        //));
    }

    function timezoneList()
    {
        $timezoneIdentifiers = DateTimeZone::listIdentifiers();
        $utcTime = new DateTime('now', new DateTimeZone('UTC'));

        $tempTimezones = array();
        foreach ($timezoneIdentifiers as $timezoneIdentifier) {
            $currentTimezone = new DateTimeZone($timezoneIdentifier);

            $tempTimezones[] = array(
                'offset' => (int)$currentTimezone->getOffset($utcTime),
                'identifier' => $timezoneIdentifier
            );
        }

        // Sort the array by offset,identifier ascending
        usort($tempTimezones, function($a, $b) {
            return ($a['offset'] == $b['offset'])
                ? strcmp($a['identifier'], $b['identifier'])
                : $a['offset'] - $b['offset'];
        });

        $timezoneList = array();
        foreach ($tempTimezones as $tz) {
            $sign = ($tz['offset'] > 0) ? '+' : '-';
            $offset = gmdate('H:i', abs($tz['offset']));
            $timezoneList[$tz['identifier']] = '(UTC ' . $sign . $offset . ') ' .
                $tz['identifier'];
        }

        return $timezoneList;
    }

}
