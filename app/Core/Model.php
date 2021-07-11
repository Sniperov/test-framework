<?php

namespace App\Core;

use App\Core\Database;
use App\Core\Config;

class Model extends Database{

    public $table_name = null;
    public $fields = null;

    public function firstById($id)
    {
        $sql = "SELECT * FROM $this->table_name WHERE id = $id LIMIT 1";
        $stm = $this->connect()->prepare($sql);
        $stm->execute();
        $data = $stm->fetch(\PDO::FETCH_ASSOC);

        return $data;
    }

    public function firstWhere($column, $value)
    {
        $value = $this->connect()->quote($value);

        $sql = "SELECT * FROM $this->table_name WHERE $column = $value";

        $stm = $this->connect()->prepare($sql);
        $stm->execute();
        $data = $stm->fetch(\PDO::FETCH_ASSOC);
        return $data;
    }

    public function create($data)
    {
        $values = [];
        foreach($this->fields as $field) {
            array_push($values, $this->connect()->quote($data[$field]));
        }
        $fields = implode(",", $this->fields);
        $values = implode(",", $values);

        $sql = "INSERT INTO $this->table_name ($fields) VALUES ($values)";
        $stm = $this->connect()->prepare($sql)->execute();
        return true;
    }
    
    public function update($id, $data)
    {
        $update = '';
        foreach ($this->fields as $key => $field) {
            if (isset($this->fields[$key+1])) {
                $update .= " $field = ".$this->connect()->quote($data[$field]).',';
            }
            else {
                $update .= " $field = ".$this->connect()->quote($data[$field]);
            }
        }
        $sql = "UPDATE $this->table_name SET $update WHERE id = $id";
        $stm = $this->connect()->prepare($sql)->execute();
    }

    public function updateColumn($id, $column, $value)
    {
        $value = $this->connect()->quote($value);
        if (in_array($column, $this->fields)) {
            $sql = "UPDATE $this->table_name SET $column = $value WHERE id = '$id'";
            $stm = $this->connect()->prepare($sql)->execute();
            return true;
        }
    }

    public function getWithPagination($limit, $page = 1, $sortBy, $sorting)
    {
        $sql = "SELECT * FROM $this->table_name";

        $res = $this->connect()->query($sql);
        $total_results = $res->fetchAll();
        $total_pages = ceil(count($total_results)/$limit);

        $starting_limit = ($page-1)*$limit;
        $show  = "SELECT * FROM $this->table_name ORDER BY $sortBy $sorting LIMIT $starting_limit,$limit";

        $stm = $this->connect()->prepare($show);
        $stm->execute();
        $data = $stm->fetchAll(\PDO::FETCH_ASSOC);

        return ['data' => $data, 'total_pages' => $total_pages, 'current_page' => $page];
    }
}