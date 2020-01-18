<?php 
namespace Code\Database;

class Query
{
    private $connection;

    protected $table = 'products';

    public function __construct(\PDO $pdo)
    {
        $this->connection = $pdo;
    }

    public function findAll($fields = '*')
    {
        $sql = 'SELECT ' . $fields . ' FROM ' . $this->table;

        $select = $this->connection->query($sql);

        return $select->fetchAll(\PDO::FETCH_OBJ);
    }

    public function find($id)
    {
        //SELECT * FROM table WHERE id = $id;...
    }

    public function insert(array $data = [])
    {  
        $keys = array_keys($data);
        $fields = implode(', ', $keys);
        $binds  = ':' . implode(', :', $keys);

        $sql = 'INSERT INTO ' . $this->table . '(' . $fields . ', created_at, updated_at) 
                VALUES(' . $binds . ', NOW(), NOW())';
                
        $stmt = $this->connection->prepare($sql);

        foreach($data as $key => $value) {
            $paramType = is_int($key) ? \PDO::PARAM_INT : \PDO::PARAM_STR;

            $stmt->bindValue(':' . $key, $value, $paramType);
        }

        print $stmt->execute();
    }
}