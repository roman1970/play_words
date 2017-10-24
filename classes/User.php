<?php
class User {

    private $name;

    /*
     * Пользователи храняться в классе в разных свойсвах по ролям - заглушка
     */
    private $users = [
        'Petia',
        'Vasia',
        'Roma',
        'Comp'
    ];

    private $admins = [
        'Director' => ['psw' => 'qwerty']
    ];

    
    public function __construct($name)
    {
        $this->name = $name;
    }


    /**
     * Метод проверяет на валидность входящего пользователя
     * @return bool
     */
    public function isValidUser() {

        if(isset($_POST['name']) && in_array($_POST['name'], $this->users)){
            return true;
        }
       
        return false;
    }


    /**
     * Метод идетифицирует админа
     * @return bool
     */
    public function isAdmin(){

        if(isset($_POST['admin']) && array_key_exists($_POST['admin'], $this->admins)){
            print_r($this->admins);
            if(isset($_POST['psw']) && !strcmp($_POST['psw'], $this->admins[$_POST['admin']]['psw'])){
                return true;
            }
        }
       
        return false;
    }

    public function getId(){
        return array_search($this->name,$this->users);
    }
}