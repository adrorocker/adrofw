<?php

/**
 * Db
 */

namespace Adroframework\Db;

use Adroframework\Db\Adapter\Adapter;

class Db
{
    protected $adapter;
    protected $select;
    protected $insert;
    protected $update;
    protected $delete;
    protected $where;
    protected $innerJoin;
    protected $query;
    protected $sth;
    protected $success;
    protected $error;
    protected $errorCode;

    public function __construct()
    {
        $this->adapter = new Adapter();
    }

    public function select($table, $colums = array('*'))
    {
        $size = count($colums);
        $this->select = 'SELECT ';
        for ($i = 0 ; $i < $size ; $i++) {
            if (($size - 1) == $i) {
                $this->select .= $colums[$i].' ';
            } else {
                $this->select .= $colums[$i].', ';    
            }
        }
        $this->select .= 'FROM '.$table;
        return $this;
    }

    public function insert($table,$colums = array(), $values = array())
    {
        $this->insert = 'INSERT INTO ' . $table;
        $cols = '(';
        $count = 1;
        foreach ($colums as $colum) {
            if($count == count($colums)) {
                $cols .= $colum;
            } else {
                $cols .= $colum.',';
            }
            $count ++;
        }
        $cols .= ')';
        $vals = '(';
        $count = 1;
        foreach ($values as $value) {
            if($count == count($values)) {
                $vals .= $value;
            } else {
                $vals .= $value.',';
            }
            $count ++;
        }
        $vals .= ')';
        $this->insert .= $cols . ' VALUES ' . $vals;
        return $this;
    }

    public function update($table = '', $keyValue = array())
    {
        $this->update = 'UPDATE ' . $table . ' SET ';
        $count = 1;
        foreach ($keyValue as $key => $value) {
            if ($count == count($keyValue)) {
                $this->update .= $key . ' = ' . $value;
            } else {
                $this->update .= $key . ' = ' . $value . ',';
            }
            $count ++;
        }
        return $this;
    }

    public function delete($table)
    {
        $this->update = 'DELETE FROM ' . $table . ' ';
        return $this;
    }

    public function where($conditions = '')
    {
        $this->where = ' WHERE '.$conditions;
        return $this;

    }

    public function innerJoin($origin,$dest = '', $colorg = '', $coldest = '')
    {
        if (is_array($origin)) {
            $this->innerJoin = '';
            foreach ($origin as $inner) {
               $this->innerJoin .= ' INNER JOIN '. $inner[1] . ' ON ' . $inner[0].'.'.$inner[2].' = '.$inner[1].'.'.$inner[3];
            }
            return $this;
        }
        $this->innerJoin = ' INNER JOIN '. $dest . ' ON ' . $origin.'.'.$colorg.' = '.$dest.'.'.$coldest;
        return $this;
    }

    public function query()
    {
        if($this->select) {
            $this->query = $this->select.$this->innerJoin.$this->where;
        } elseif ($this->insert) {
            $this->query = $this->insert;
        } elseif ($this->update) {
            $this->query = $this->update.$this->where;
        } elseif ($this->delete) {
            $this->query = $this->delete.$this->where;
        }
        $this->sth = $this->adapter->prepare($this->query);
        return $this;
    }

    public function execute($params = array())
    {
        $this->sth->execute($params);
        $this->execute = $this->sth->errorInfo();
        if ($this->execute[0] == '00000') {
            $this->success = true;
        } else {
            $this->success = false;
            $this->errorCode = $this->execute[1];
            $this->error = $this->execute[2];
        }
        return $this;
    }


    public function fetch()
    {
        return $this->sth->fetch(\PDO::FETCH_ASSOC);
    }

    public function fetchAll()
    {
        return $this->sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function clean()
    {
        $this->select       = null;
        $this->where        = null;
        $this->innerJoin    = null;
        $this->insert       = null;
        $this->query        = null;
        $this->sth          = null;
        $this->update       = null;
        $this->success      = null;
        $this->error        = null;
        $this->errorCode    = null;
        return $this;
    }

}