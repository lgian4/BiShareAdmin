<?php
class Produk_Model extends CI_Model
{

    public $database;
    public $storage;
    public $fire;
    public $storageClient;
    public $defaultBucket;
    protected $dbname = 'produk';
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
            return strcmp($a["produkcode"], $b["produkcode"]);
        });

        return $list;
    }
    public function GetListByToko($tokoid)
    {
        $list = $this->database->getReference($this->dbname)
            ->orderByChild("tokoid")
            ->equalTo($tokoid)
            ->getValue();
        unset($list['count']);
        usort($list, function ($a, $b) {
            return strcmp($a["produkcode"], $b["produkcode"]);
        });
        $hasil = [];
        for ($x = 0; $x < count($list); $x++) {
            if ($list[$x]['tokoid'] == $tokoid && $list[$x]['dlt']== false) {
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

    public function AddCountMedia($id)
    {
        $count = $this->database->getReference($this->dbname)->getChild("produkmediacount")->getValue() + 1;

        $this->database->getReference()->getChild($this->dbname)->getChild("produkmediacount")->set($count);
        
        return $count;
    }

    public function GetEmpty()
    {
        return array(
            "produkid" => "",
            "tokoid" => "",
            "tokoname" => "",
            "kategoriid" => "",
            "kategoriname" => "",
            "dlt" => false,
            "produkcode" => "",
            "produkdate" => date("Y-m-d H:i:s"),
            "produkname" => "",
            "stok" => 0,
            "harga" => 0,
            "deskripsi" => "",
            "fitur" => "",
            "spesifikasi" => "",
            "produkmedia" => [],
            "produkmediacount" => 0,
            "status" => '',
            "alasan" => '',
        );
    }
    public function GetMediaEmpty()
    {
        return array(
            "mediaid" => "",
            "produkid" => "",
            "mediaurl" => "",
            "medianama" => "",
            "mediatype" => "",
            "mediaext" => "",
            "mediadate" => date("Y-m-d H:i:s"),
            "mediasize" => 0,
            "dlt" => false,
        );
    }
}
