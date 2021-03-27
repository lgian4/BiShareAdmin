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

    public function get(string $userID = null)
    {
        if (empty($userID) || !isset($userID)) {return false;}
        if ($this->database->getReference($this->dbname)->getSnapshot()->hasChild($userID)) {
            return $this->database->getReference($this->dbname)->getChild($userID)->getValue();
        } else {
            return false;
        }
    }
    public function GetList()
    {
        $list = $this->database->getReference($this->dbname)->orderByChild("usercode")->getValue();
        unset($list['count']);
        return $list;
    }

    public function insert(array $data, string $userID)
    {

        if (empty($data) || !isset($data)) {return false;}

        $updates = [
            $this->dbname . '/' . $userID => $data,
        ];
        $this->database->getReference() // this is the root reference
            ->update($updates);

        return $data;

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
    public function AddCount()
    {
        $count = $this->database->getReference($this->dbname)->getChild('count')->getValue() + 1;
        $this->database->getReference()->getChild($this->dbname)->getChild('count')->set($count);
        return $count;
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

    public function Duplicate(string $username, string $email, string $userid = null)
    {

        if (empty($username) || !isset($username)) {return null;}
        if (empty($email) || !isset($email)) {return null;}
        $user = $this->database->getReference($this->dbname)
            ->orderByChild("username")
            ->equalTo($username)
            ->getValue();

        if (empty($user) || !isset($user) || ($userid != null && $user['userid' == $userid])) {} else {
            return true;
        }

        $user = $this->database->getReference($this->dbname)
            ->orderByChild("email")
            ->equalTo($email)
            ->getValue();

        if (empty($user) || !isset($user) || ($userid != null && $user['userid' == $userid])) {return false;} else {
            return true;
        }

    }

    public function Register(string $username, string $password, string $email, string $jeniskelamin, string $nama, string $nohp, string $tanggallahir)
    {

        $usercode = $this->AddCount();
        $postData = [
            'userid' => $usercode,
            'usercode' => 'U' . $usercode,
            'userdate' => date(),
            'nama' => $nama,
            'jeniskelamin' => $jeniskelamin,
            'tanggallahir' => $tanggallahir,
            'email' => $email,
            'nohp' => $nohp,
            'alamat' => '',
            'status' => 'customer',
            'dlt' => false,
            'username' => $username,
            'password' => $password,
        ];

        $updates = [
            'users/' . $usercode => $postData,
        ];

        $this->database->getReference() // this is the root reference
            ->update($updates);
        return $postData;
    }
    public function GetEmpty()
    {
        return array(
            "alamat" => "",
            "dlt" => false,
            "email" => "",
            "jeniskelamin" => "",
            "nama" => "",
            "nohp" => "",
            "password" => "",
            "status" => "",
            "tanggallahir" => "",
            "usercode" => '',
            "userdate" => date("Y-m-d H:i:s"),
            "userid" => "",
            "username" => "");

    }
}
