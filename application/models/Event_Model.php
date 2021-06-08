<?php
class Event_Model extends CI_Model
{

    public $database;
    public $storage;
    public $fire;
    public $storageClient;
    public $defaultBucket;
    protected $dbname = 'event';
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

    public function getDetail(string $userID = null)
    {
        if (empty($userID) || !isset($userID)) {
            return false;
        }
        if ($this->database->getReference('eventdetail')->getSnapshot()->hasChild($userID)
        ) {
            return $this->database->getReference('eventdetail')->getChild($userID)->getValue();
        } else {
            return [];
        }
    }

    public function GetList()
    {
        $list = $this->database->getReference($this->dbname)
            ->orderByChild("dlt")
            ->equalTo(false)
            ->getValue();
        
        usort($list, function ($a, $b) {
            return strcmp($a["eventcode"], $b["eventcode"]);
        });

        return $list;
    }
   



    public function insert(array $data)
    {

        if (empty($data) || !isset($data)) {return false;}              
        $ref =   $this->database->getReference( $this->dbname)->push($data);
        $data['eventid'] = $ref->getKey();
        $this->database->getReference( $this->dbname . '/' . $data['eventid'] )->set($data);
        return $data;

    }
    public function addproduk(string $eventid,string $produkid)
    {

        if (empty($eventid) || !isset($eventid)) {return false;}              

        if (empty($produkid) || !isset($produkid)) {return false;} 
        //get produk
        $produk =  $this->database->getReference('produk')->getChild($produkid)->getValue();
        if (empty($produk) || !isset($produk)) {return false;} 
        // add ke event
        

    $ref=     $this->database->getReference( 'eventdetail/'.$eventid.'/'.$produkid)->set($produk);
    
        return true;

    }
    public function update(array $data, string $userID)
    {

        if (empty($data) || !isset($data)) {return false;}

        $updates = [
            $this->dbname . '/' . $userID => $data,
        ];
        $this->database->getReference() // this is the root reference
            ->update($updates);

        return $data;

    }
    public function SoftDelete( $userID)
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
    public function delete( $userID)
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
    public function deleteproduk($userID,$produkid)
    {
        if (empty($userID) || !isset($userID)) {
            return false;
        }
        if ($this->database->getReference('eventdetail/'.$userID)->getSnapshot()->hasChild($produkid)) {
            $this->database->getReference('eventdetail/'.$userID)->getChild($produkid)->remove();
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
            "eventid" => "",
            "eventnama" => "",
            "eventcode" => "",
            "eventdesc" => "",
            "status" => "",
            "dlt" => false,
          
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
