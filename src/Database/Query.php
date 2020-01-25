<?php 
namespace Code\Database;

class Query
{
    private $connection;

    protected $table = null;

    public function __construct(\PDO $pdo)
    {
        $this->connection = $pdo;
    }

    public function setTable($table)
    {
        $this->table = $table;
    }

    public function findAll($fields = '*')
    {
        $sql = 'SELECT ' . $fields . ' FROM ' . $this->table;

        $select = $this->connection->query($sql);

        return $select->fetchAll(\PDO::FETCH_OBJ);
    }

    public function where(array $conditions = [], $fields = '*')
    {
        $sql = 'SELECT ' . $fields . ' FROM ' . $this->table . ' WHERE ';

        $where = '';

        foreach($conditions as $key => $cond) {
            if($where) {
                $where .= ' AND ' . $key . ' = ' . ':' . $key;
            } else {
                $where .= $key . ' = ' . ':' . $key;
            }
            
        }

        $sql =  $sql . $where;
        
        $result = $this->execute($sql, $conditions);

        return $result->fetchAll(\PDO::FETCH_OBJ);
    }

    public function find(int $id)
    {
        $result = $this->where(['id' => $id]);

        return current($result);
    }

    public function insert(array $data = [])
    {  
        $keys = array_keys($data);
        $fields = implode(', ', $keys);
        $binds  = ':' . implode(', :', $keys);

        $sql = 'INSERT INTO ' . $this->table . '(' . $fields . ', created_at, updated_at) 
                VALUES(' . $binds . ', NOW(), NOW())';
                
        return $this->execute($sql, $data);
    }

    public function update($data)
    {
        if(!array_key_exists('id', $data)) {
			throw new \Exception('É preciso informar um ID válido para update!');
		}

		$sql = 'UPDATE ' . $this->table . ' SET ';

		$set = null;
		$binds = array_keys($data);

        foreach($binds as $v) {
			if($v !== 'id') {
				$set .= is_null($set) ? $v . ' = :' . $v : ', ' .  $v . ' = :' . $v ;
			}
		}
        $sql .= $set . ', updated_at = NOW() WHERE id = :id';
        
        return $this->execute($sql, $data);
    }

    public function delete(int $id)
	{
		$sql = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        return $this->execute($sql, ['id' => $id]);
	}

    private function execute($querySql, array $data = [])
    {
        $pdoExecute = $this->connection->prepare($querySql);
        
        foreach($data  as $key => $value) {
            $pdoExecute->bindValue(':' . $key, $value, 
            gettype($value) != 'integer' ? \PDO::PARAM_STR : \PDO::PARAM_INT );
        }

        $pdoExecute->execute();

        return $pdoExecute;
    }
}