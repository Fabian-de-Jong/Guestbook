<?php
/*
* The guestbook object
*/
require_once('abstractModel.php');

class Guestbook extends abstractModel {

    public $tableName = 'guestbook';
    public $properties = array('name', 'email', 'text', 'date');

    public $name;    
    public $email;
    public $text;
    public $date;

    function __construct () {
        
    }
    
    /*
    * get the guestbook entries ordered by most recent date
    */
    public function getEntries(){
        return self::getRows('date DESC');
    }

}