<?php

class User{
    public $name;
    public $lastName;
    public $password;
    public $email;
    public $cellphone;
    public $type;

    public function __construct($name, $lastName, $password, $email, $cellphone, $type)
    {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->password = $password;
        $this->email = $email;
        $this->cellphone = $cellphone;
        $this->type = $type;
    }
}
?>