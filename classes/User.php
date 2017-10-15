<?php
class User {

    public $name;
    
    public $users = [
        'Petia',
        'Vasia',
        'Roma'
    ];
    
    public function __construct($name)
    {
        $this->name = $name;
    }


    public function isValidUser() {

        if(isset($_POST['name']) && in_array($_POST['name'], $this->users)){
            return true;
        }
        else 
            return false;
    }
}