<?php

include_once 'Database.php';

class Lib extends Database {

    public function get($params) {
        if ($params = $this->validParams($params)) {
            try {
                $stmt = $this->conn->prepare('SELECT ' . $params['cols'] . ' FROM ' . $params['table'] . " WHERE ". $params['params']);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                $this->errorException(['type' => '503', 'message' => $e->getMessage()]);
            }
        } else {
            $this->errorException(['type'=>'500']);
        }
    }

    public function save($data,$params) {
        if ($params = $this->validParams($params)) {
            try {
                if (count($data['value']) == 0) {
                    $this->conn->exec('INSERT INTO ' . $params['table'] . ' (' . implode(',', $data['column']) . ')  VALUES ' . implode(',', $data['value'][0]));
                } else {
                    $this->conn->beginTransaction();
                    foreach ($data['value'] as $value) {
                        $sql = 'INSERT INTO ' . $params['table'] . ' (' . implode(',', $data['column']) . ')  VALUES ' . implode(',', $value);
                    }
                    $this->conn->commit();
                }
            } catch (PDOException $e) {
                $this->errorException(['type' => '503', 'message' => $e->getMessage()]);
            }
        } else {
            $this->errorException(['500']);
        }
    }

    public function delete($params) {
        if ($this->validDeleteParams($params)) {
            try {
                $this->conn->exec('DELETE FROM ' . $params['table'] . ' WHERE (' . implode(',', $params['cols']));
            } catch (PDOException $e) {
                $this->errorException(['type' => '503', 'message' => $e->getMessage()]);
            }
        } else {
            $this->errorException(['500']);
        }
    }


    private function validParams ($params) {
        if (!in_array($params, 'table')) {
            return false;
        }
        if (!in_array($params, 'cols')) {
            $params['cols'] = '*';
        }
        if (!in_array($params, 'params')) {
            $params['params'] = '1';
        }
        return $params;
    }

    private function validDeleteParams ($params) {
        return (in_array($params, 'table') && in_array($params, 'cols'));
    }

    public function errorException ($errArray) {

    }


}