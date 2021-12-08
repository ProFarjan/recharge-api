<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'Database.php';

class Lib extends Database {

    private $token_user = 'admin';
    private $token_pass = '12456';

    public function get($params) {
        if ($params = $this->validParams($params)) {
            try {
                $stmt = $this->conn->prepare('SELECT ' . $params['cols'] . ' FROM ' . $params['table'] . ' WHERE ' . (empty($params['params']) ? 1 : $params['params']));
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return $this->errorException(['type' => '503', 'message' => $e->getMessage()]);
            }
        } else {
            return $this->errorException(['type'=>'500']);
        }
    }

    public function save($data,$params) {
        if ($params = $this->validParams($params)) {
            try {
                $this->conn->beginTransaction();
                $this->conn->exec("INSERT INTO " . $params['table'] . " (" . implode(',', array_keys($data)) . ")  VALUES (" . $this->postData(array_values($data)) . ")");
                $this->conn->commit();
                return [
                    'status' => 'success',
                    'lastId' => $this->conn->lastInsertId()
                ];
            } catch (PDOException $e) {
                return $this->errorException(['type' => '503', 'message' => $e->getMessage()]);
            }
        } else {
            return $this->errorException(['type' => '500']);
        }
    }

    public function login ($user) {
        $user['password'] = sha1($user['password']);
        $stmt = $this->conn->prepare('SELECT * FROM users WHERE ' . $this->assSql($user));
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        if ($res) {
            $res->accesToken = $this->getToken();
            unset($res->username);
            unset($res->password);
            unset($res->created_date);
        }
        return $res;
    }

    public function update($putData,$params) {
        if (array_key_exists('table', $params)) {
            try {
                $this->conn->beginTransaction();
                $this->conn->exec('UPDATE ' . $params['table'] . ' SET ' . $this->putFormatter($putData) . ' WHERE ' . $this->getParams($params));
                $this->conn->commit();
                return [ 'status' => 'success' ];
            } catch (PDOException $e) {
                return $this->errorException(['type' => '503', 'message' => $e->getMessage()]);
            }
        } else {
            return $this->errorException(['type' => '500']);
        }
    }

    public function delete($params) {
        if (array_key_exists('table', $params)) {
            try {
                $this->conn->beginTransaction();
                $this->conn->exec('DELETE FROM ' . $params['table'] . ' WHERE ' . $this->getParams($params));
                $this->conn->commit();
                return [ 'status' => 'success' ];
            } catch (PDOException $e) {
                return $this->errorException(['type' => '503', 'message' => $e->getMessage()]);
            }
        } else {
            return $this->errorException(['type' => '500']);
        }
    }

    private function validParams ($params) {
        if (!array_key_exists('table', $params)) {
            return false;
        }
        if (!array_key_exists('cols', $params)) {
            $params['cols'] = '*';
        }
        $params['params'] = $this->getParams($params);
        return $params;
    }

    private function getParams ($params) {
        $reserve_value = ['table','cols','sort','order','limit','params'];
        $res = '';
        foreach ($params as $k => $param) {
            $org_k = explode('_', $k);
            if (!empty($org_k[0]) && !in_array($org_k[0],$reserve_value)) {
                if (count($org_k) > 1) {
                    switch ($org_k[1]) {
                        case 'like' :
                            $this->likeCase($org_k,$param);
                            break;
                        case '!' :
                            $this->norCase($org_k,$param);
                            break;
                        case 'in' :
                            $res .= $this->inCase($org_k[0],$param);
                            break;
                        default:
                            $res .= $k . ' = ' . "$param and ";
                    }
                } else {
                    if (is_numeric($param)) {
                        $res .= $k . ' = ' . "$param and ";
                    } else {
                        $res .= $k . ' = ' . "'$param' and ";
                    }
                }
            }
        }
        if (empty($res)) {
            $res .= ' 1 ';
        }
        $res = trim($res, 'and ');

        if (array_key_exists('_sort', $params) && array_key_exists('_order', $params)) {
            $res .= ' ORDER BY ' . $params['_order'] . ' ' . $params['_sort'];
        }
        if (array_key_exists('_limit', $params)) {
            $res .= ' LIMIT ' . $params['_limit'];
        }
        return $res;
    }

    private function likeCase() {}
    private function norCase() {}
    private function inCase($col,$val) {
        $res = $col . ' IN (';
        $values = explode(',',$val);
        foreach ($values as $v) {
            if (is_numeric($v)) {
                $res .= "$v,";
            } else {
                $res .= "'$v',";
            }
        }
        return trim($res, ',') . ') ';
    }

    private function putFormatter ($data) {
        $res = '';
        foreach ($data as $k => $val) {
            if (is_numeric($val)) {
                $res .= $k . ' = ' . $val . ', ';
            } else {
                $res .= $k . ' = ' . "'$val', ";
            }
        }
        return trim($res,', ');
    }

    private function postData($data) {
        $res = "";
        foreach ($data as $val) {
            if (is_numeric($val)) {
                $res .= $val . ',';
            } else {
                $res .= "'$val'" . ',';
            }
        }
        return trim($res, ',');
    }

    private function assSql ($arr) {
        $res = '';
        if (count($arr) > 0) {
            foreach ($arr as $k => $val) {
                $res .= $k . ' = ' . "'$val'";
                $res .= " and ";
            }
            $res = trim($res, ' and ');
        }
        return $res;
    }

    public function errorException ($errArray) {
        if (!array_key_exists('status', $errArray)) {
            $errArray['status'] = 'failure';
        }
        return $errArray;
    }

    public function pro ($data,$ISDIE=false) {
        print_r('<pre>');
        print_r($data);
        print_r('</pre>');
        if ($ISDIE) {
            die();
        }
    }

    public function verifyToken ($token) {
        return ($token != $this->getToken()) ? ['status' => 'failure', 'message' => 'Unauthorized request'] : true ;
    }

    private function getToken () {
        return base64_encode(md5($this->token_user . ":" . $this->token_pass));
    }


}