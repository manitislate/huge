<?php

class AboutmeController extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Handles what happens when user moves to URL/blog/index - or - as this is the default controller
     */
    public function index()
    {
        $this->View->render('aboutme/index', array(
            'title' => "About Me",
            'description' => " ",
            'keywords' => "Paul Szerlip, Entrepreneur, Musician, Artist,  "
        ));
    }

}

