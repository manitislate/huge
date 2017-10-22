<?php

class BlogController extends Controller
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
        $this->View->render('blog/index');
    }
    public function What_is_a_mastermind(){
        $this->View->render('blog/What-is-a-Mastermind', array(
            'title' => "What is a Mastermind?",
            'description' => "In the article you will learn what is a mastermind group.  This is a definition of a mastermind, who is in a mastermind, how it can help you, where a mastermind meets, how it is structured, and how many people are in a mastermind group.",
            'keywords' => "Mastermind, Mastermind Group Definition, Who is in a Mastermind, How Masterminds Help, Mastermind Group Structure, Where Mastermind Meets, Mastermind Structure, Mastermind Group Size"
        ));
}
    public function Mastermind_Structure_Part1(){
        $this->View->render('blog/Mastermind-Structure-Part1-Goals-of-a-Mastermind', array(
            'title' => "Mastermind Structure Part1: Goals of a Mastermind",
            'description' => "We all know that goals are an important part of success. The same is true for mastermind meetings. This blog post will teach you how to create a common goal for the entire group that everyone can commit to.",
            'keywords' => "Mastermind, goals, accountability, idea generation, course correction, connection"
        ));
    }

}

