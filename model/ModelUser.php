<?php
require_once File::build_path(array('model','Model.php'));

class ModelUser extends Model{
    private $login;
    private $name;
    private $surname;
    private $password;
    private $isAdmin;

    protected static $object = 'g_user';
    protected static $primary = 'login';

    public function getLogin() {
        return $this->login;
    }

    public function getName() {
        return $this->name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getIsAdmin(){
        return $this->isAdmin;
    }

    public function setLogin($l) {
        return $this->login = $l;
    }

    public function setName($n) {
        return $this->name = $n;
    }

    public function setSurname($s) {
        return $this->surname = $s;
    }

    public function setPassword($p) {
        return $this->password = $p;
    }


    
    public function __construct($l=NULL,$p=NULL,$n=NULL,$s=NULL){
        if(!is_null($l) && !is_null($p) && !is_null($n) && !is_null($s)){
            $this->login = $l;
            $this->name = $n;
            $this->surname = $s;
            $this->password = $p;
        }
    }
    

    public static function setAdmin($login) {
        try {
            $sql = "UPDATE `g_user` SET `isAdmin` = '1' WHERE `g_user`.`login` = :login";
            $req_prep = Model::getPDO()->prepare($sql);
            $values = array(
                "login" => $login
            );
            $req_prep->execute($values);
            $isAdmin = true;
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            } else {
                echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
            }
            die();
        }
    }

    public static function removeAdmin($login) {
        try {
            $sql = "UPDATE `g_user` SET `isAdmin` = '0' WHERE `g_user`.`login` = :login";
            $req_prep = Model::getPDO()->prepare($sql);
            $values = array(
                "login" => $login
            );
            $req_prep->execute($values);
            $isAdmin = false;
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            } else {
                echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
            }
            die();
        }
    }

    public static function passwordMatched($data) {
        return $data['newpassword'] == $data['confirmed_password'];
    }
    
    public static function connect($data) {
        try {
            $sql = "SELECT * FROM g_user WHERE g_user.login = :login AND g_user.password = :password";
        $req_prep = Model::getPDO()->prepare($sql);
        $values = array(
            "login" => $data['login'],
            "password" => $data['password']
        );
        $req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUser');
        return $req_prep->fetch();
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            } else {
                echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
            }
            die();
        }
        
    }
        



}

