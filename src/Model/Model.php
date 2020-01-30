<?php 
namespace Code\Model;

use Code\Database\{Connection, Query};

class Model
{
    private $query;

    protected $table;

    protected $keyParameter = 'id';

    protected $data = [];

    public function __construct()
    {
        $this->query = new Query(Connection::getInstance());
        $this->query->setTable($this->table);
     
    }

    public function findAll()
    {
        return $this->query->findAll();
    }

    public function where(array $conditions = [])
    {
        $result = $this->query->where($conditions);

        if(count($result) == 1) return current($result);

        return $result;
    }   

    public function __set($name, $value)
    {
        $this->data[$name] = $value;   
    }

    public function save()
    {
        if(isset($this->data[$this->keyParameter])) {
            return $this->query->update($this->data);
        } else {
            return $this->query->insert($this->data);
        }
    }
}