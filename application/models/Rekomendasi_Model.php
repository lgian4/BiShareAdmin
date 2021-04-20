<?php
class Rekomendasi_Model extends CI_Model
{

    public $database;
    public $storage;
    public $fire;
    public $storageClient;
    public $defaultBucket;
    protected $dbname = 'rekomendasi';
    public function __construct()
    {
        $this->load->library('firebase');
        $this->fire = $this->firebase->init();
        $this->database = $this->fire->createDatabase();
        $this->storage = $this->fire->createStorage();

        $this->storageClient = $this->storage->getStorageClient();
        $this->defaultBucket = $this->storage->getBucket();
    }

    public function get(string $userID = null)
    {
        if (empty($userID) || !isset($userID)) {
            return false;
        }
        if ($this->database->getReference($this->dbname)->orderByChild("dlt")
            ->equalTo(false)->getSnapshot()->hasChild($userID)
        ) {
            return $this->database->getReference($this->dbname)->getChild($userID)->getValue();
        } else {
            return false;
        }
    }

    public function GetList()
    {
        $list = $this->database->getReference($this->dbname)
            ->orderByChild("dlt")
            ->equalTo(false)
            ->getValue();
        unset($list['count']);
        usort($list, function ($a, $b) {
            return strcmp($a["urutan"], $b["urutan"]);
        });

        return $list;
    }
    
    public function GetListByProduk($produkid)
    {
        $list = $this->database->getReference($this->dbname)
            ->orderByChild("produkid")
            ->equalTo($produkid)
            ->getValue();
        unset($list['count']);
        usort($list, function ($a, $b) {
            return strcmp($a["produkcode"], $b["produkcode"]);
        });
        $hasil = [];
        for ($x = 0; $x < count($list); $x++) {
            if ($list[$x]['produkid'] == $produkid) {
                array_push($hasil, $list[$x]);
            }
        }
        return $hasil;
    }


    public function insert(array $data, string $userID)
    {

        if (empty($data) || !isset($data)) {
            return false;
        }

        $updates = [
            $this->dbname . '/' . $userID => $data,
        ];
        $this->database->getReference() // this is the root reference
            ->update($updates);

        return $data;
    }
    public function SoftDelete(int $userID)
    {
        if (empty($userID) || !isset($userID)) {
            return false;
        }
        if ($this->database->getReference($this->dbname)->getSnapshot()->hasChild($userID)) {
            $data = $this->database->getReference($this->dbname)->getChild($userID)->getValue();
            $data['dlt'] = true;
            $updates = [
                $this->dbname . '/' . $userID => $data,
            ];
            $this->database->getReference() // this is the root reference
                ->update($updates);

            return true;
        } else {
            return false;
        }
    }
    public function delete(int $userID)
    {
        if (empty($userID) || !isset($userID)) {
            return false;
        }
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

  
    public function GetEmpty()
    {
        return array(
            "rekomendasiid" => "",
            "produkid" => "",
            "produkname" => "",            
            "dlt" => false,
            "urutan" => 0,            
        );
    }    
}
