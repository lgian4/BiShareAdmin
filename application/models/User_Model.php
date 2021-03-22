<?php
class User_Model extends CI_Model
{

    public $database;
    public $fire;
    protected $dbname = 'users';
    public function __construct()
    {
        $this->load->library('firebase');
        $this->fire = $this->firebase->init();
        $this->database = $this->fire->createDatabase();
    }

    public function get(int $userID = null)
    {
        if (empty($userID) || !isset($userID)) {return false;}
        if ($this->database->getReference($this->dbname)->getSnapshot()->hasChild($userID)) {
            return $this->database->getReference($this->dbname)->getChild($userID)->getValue();
        } else {
            return false;
        }
    }

    public function insert(array $data)
    {
        if (empty($data) || !isset($data)) {return false;}
        foreach ($data as $key => $value) {
            $this->database->getReference()->getChild($this->dbname)->getChild($key)->set($value);
        }
        return true;
    }

    public function delete(int $userID)
    {
        if (empty($userID) || !isset($userID)) {return false;}
        if ($this->database->getReference($this->dbname)->getSnapshot()->hasChild($userID)) {
            $this->database->getReference($this->dbname)->getChild($userID)->remove();
            return true;
        } else {
            return false;
        }
    }
    public function login(string $username, string $password)
    {

        if (empty($username) || !isset($username)) {return null;}
        $user = $this->database->getReference($this->dbname)
            ->orderByChild("username")
            ->equalTo($username)
        
        ->getValue();

        if (empty($user) || !isset($user)) {return false;}
        

        if ($user['1']['password'] == $password) {
            return $user['1'];
        } else {
            return null;
        }

    }
}
