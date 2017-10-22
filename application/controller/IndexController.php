<?php

class IndexController extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Handles what happens when user moves to URL/index/index - or - as this is the default controller, also
     * when user moves to /index or enter your application at base level
     */
    public function index()
    {
        $this->View->render('index/index',array(
        'open_groups' => IndexController::viewOpenings(),
        'title' => IndexController::title()
        ));
    }

    public function title()
    {
        $title = "iLOVEmasterminds.com : Makes finding a mastermind easy";
        //ob_start();
        //include("header.php");
        //$buffer=ob_get_contents();
        //ob_end_clean();
        //$buffer=str_replace("iLOVEmasterminds.com : Makes finding a mastermind easy","Hey-yo! iLOVEmasterminds.com : Makes finding a mastermind easy",$buffer);
        //return $buffer;
        return $title;
    }

    /** if a timezone is detected then
     * convert a day and hour to user timezone     *
     */
    public function getConvertedDates ($meeting_array)
    {
        //echo "<br>meeting_array is:<br>";
        //var_dump($meeting_array);
        //echo "<br>";
        date_default_timezone_set('America/Los_Angeles');
        $return_array = array();

        //if no timezone is detected set timezone to UTC of 0
        if (!isset ($_SESSION['tz'])){
            $new_date = new DateTimeZone('UTC');
        }
        //else convert to users time
        else {
            $new_date = new DateTimeZone($_SESSION['tz']);
        }
        $datetime = new DateTime();
        $datetime->setTimezone($new_date);
        foreach ($meeting_array as $key => $value) {
            //we have to make an option for groups and individuals

            //individuals availability
            if (!isset ($value->meeting_day)){
                //echo "<br>individual availability value is:<br>";
                //var_dump($value);
                //echo "<br>";

                //each member may have more than one entry to their availability
                foreach ($value as $key => $value2) {

                    //echo "<br>each individual availability value is:<br>";
                    //var_dump($value2);
                    //echo "<br>";
                    $day = $value2->day;
                    $hour = $value2->hour;

                    $utc = 'last ' .$day . $hour;
                    $timestamp = strtotime($utc);
                    $datetime->setTimestamp($timestamp);

                    $value_hour = $datetime->format('Hi');
                    //need format for day name
                    $value_day = $datetime->format('l');

                    //this array needs to be made correctly
                    $return_array [] = (object) array('meeting_day'=>$value_day, 'meeting_hour'=>$value_hour);
                    //echo "<br>return array is:<br>";
                    //var_dump($return_array);
                    //echo "<br>";
                }
            }
            //groups
            else {
                //echo "<br>group availability value is:<br>";
               // var_dump($value);
                //echo "<br>";
                $day = $value->meeting_day;
                $hour = $value->meeting_hour;



                $utc = 'last ' .$day . $hour;
                $timestamp = strtotime($utc);
                $datetime->setTimestamp($timestamp);

                $value_hour = $datetime->format('Hi');
                //need format for day name
                $value_day = $datetime->format('l');

                //this array needs to be made correctly
                $return_array [] = (object) array('meeting_day'=>$value_day, 'meeting_hour'=>$value_hour);
                //echo "<br>return array is:<br>";
                //var_dump($return_array);
                //echo "<br>";
            }



    }
        return array($return_array);

    }



    /**
     * Fetches all available time slots, including users who might be logged in
     * @return array
     */
    public function viewOpenings()
    {
        $meets_on_sunday = array();
        $meets_on_monday = array();
        $meets_on_tuesday = array();
        $meets_on_wednesday = array();
        $meets_on_thursday = array();
        $meets_on_friday = array();
        $meets_on_saturday = array();

        //Get index number of users looking for a group
        foreach(GroupModel::findOpenUsersIndex() as $key => $value) {
            //echo "<br>open users is:<br>";
            //var_dump($value);
            //echo "<br>";

            //get user availability
            $user_availability = GroupModel::findUserAvailabilityIndex($value->user_id);
            //echo "<br><br><br>user availability is:<br>";
            //var_dump($user_availability);
            //echo "<br><br><br>";

            ////only add users who have added availability
            if (!empty ($user_availability)){
                //echo "<br><br><br>no availability for user!<br>";

                $availability_array [] = $user_availability;
                //echo "<br>availability is:<br>";
                //var_dump($availability_array);
                //echo "<br>";
            }



        }



            //lets convert groups times
            $groups = indexController::getConvertedDates(GroupModel::findOpenGroupsIndex());
            //for some reason it returns as an array of 1...
            //remove array of 1
            foreach( $groups as $key => $value) {
                $groups = $value;
            }

            //lets convert individual times:
            $availability_times = indexController::getConvertedDates($availability_array);
            //echo "<br>availability times is:<br>";
            //var_dump($availability_times);
            //echo "<br>";

            //for some reason it returns as an array of 1...
            //remove array of 1
            //foreach( $availability_times as $key => $value) {
            //    $availability_times = $value;

            //}
            //echo "<br>availability times is:<br>";
            //var_dump($availability_times);
            //echo "<br>";


        //Get open groups time
        foreach( $groups as $key => $value) {
            //lets try to convert each group entry to users timezone

            //find what day the groups meet on
            //create an array of hours for each day
            //add day and hour to $meets_on array
            if ($value->meeting_day == 'Sunday'){
                $meets_on_sunday[]= $value->meeting_hour;
            }
            if ($value->meeting_day == 'Monday'){
                $meets_on_monday[]= $value->meeting_hour;
            }
            if ($value->meeting_day == 'Tuesday'){
                $meets_on_tuesday[]= $value->meeting_hour;
            }
            if ($value->meeting_day == 'Wednesday'){
                $meets_on_wednesday[]= $value->meeting_hour;
            }
            if ($value->meeting_day == 'Thursday'){
                $meets_on_thursday[]= $value->meeting_hour;
            }
            if ($value->meeting_day == 'Friday'){
                $meets_on_friday[]= $value->meeting_hour;
            }
            if ($value->meeting_day == 'Saturday'){
                $meets_on_saturday[]= $value->meeting_hour;
            }

        }

            //for each user looking for a group, grab their available hours
            foreach($availability_times as $key => $value) {
                foreach ($value as $key => $value2) {
                    //echo "<br>availability time is:<br>";
                    //var_dump($value2);
                    //echo "<br>";

                    //only add it to an day if the user's array
                    //is not empty

                    //find what day is available
                    //create an array of hours for each day
                    //add day and hour to $meets_on array
                    if ($value2->meeting_day == 'Sunday'){
                        $meets_on_sunday[]= $value2->meeting_hour;
                    }
                    if ($value2->meeting_day == 'Monday'){
                        $meets_on_monday[]= $value2->meeting_hour;
                    }
                    if ($value2->meeting_day == 'Tuesday'){
                        $meets_on_tuesday[]= $value2->meeting_hour;
                    }
                    if ($value2->meeting_day == 'Wednesday'){
                        $meets_on_wednesday[]= $value2->meeting_hour;
                    }
                    if ($value2->meeting_day == 'Thursday'){
                        $meets_on_thursday[]= $value2->meeting_hour;
                    }
                    if ($value2->meeting_day == 'Friday'){
                        $meets_on_friday[]= $value2->meeting_hour;
                    }
                    if ($value2->meeting_day == 'Saturday'){
                        $meets_on_saturday[]= $value2->meeting_hour;
                    }

                }



            }
            asort($meets_on_monday);
            asort($meets_on_tuesday);
            asort($meets_on_wednesday);
            asort($meets_on_thursday);
            asort($meets_on_friday);
            asort($meets_on_saturday);
            asort($meets_on_sunday);

        //$output = array ("Monday"=>$meets_on_monday,"Tuesday"=>$meets_on_tuesday,"Wednesday"=>$meets_on_wednesday,"Thursday"=>$meets_on_thursday,"Friday"=>$meets_on_friday,"Saturday"=>$meets_on_saturday,"Sunday"=>$meets_on_sunday);
        //var_dump($output);

        return array ("Monday"=>$meets_on_monday,"Tuesday"=>$meets_on_tuesday,"Wednesday"=>$meets_on_wednesday,"Thursday"=>$meets_on_thursday,"Friday"=>$meets_on_friday,"Saturday"=>$meets_on_saturday,"Sunday"=>$meets_on_sunday);

    }


}

