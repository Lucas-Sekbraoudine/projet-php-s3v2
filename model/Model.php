<?php

require_once File::build_path(array('config', 'Conf.php'));

class Model
{
    private static $pdo = NULL;
    protected static $object;
    protected static $primary;
    protected static $table_name;

    private static function init()
    {
        $hostname = Conf::getHostname();
        $database_name = Conf::getDatabase();
        $login = Conf::getLogin();
        $password = Conf::getPassword();


        try {
            self::$pdo = new PDO("mysql:host=$hostname;dbname=$database_name", $login, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }


    public static function getPDO()
    {
        if (is_null(self::$pdo)) {
            self::init();
        }
        return self::$pdo;
    }

    public static function selectAll() {
        $table_name = static::$object;
        $class_name = 'Model' . ucfirst(str_replace('g_','',$table_name));

        try {
            $sql = "SELECT * FROM $table_name";
            $rep = self::getPDO()->query($sql);
            $rep->setFetchMode(PDO::FETCH_CLASS, $class_name);
            return $rep->fetchAll();
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            } else {
                echo "Impossible de récupérer la table $table_name";
            }
            die();
        }
    }

    public static function select($primary_value) {
        $table_name = static::$object;
        $class_name = 'Model' . ucfirst(str_replace('g_','',$table_name));
        $primary_key = static::$primary;

        try {
            $sql = "SELECT * from $table_name WHERE $primary_key= :primary_value";
            $req_prep = self::getPDO()->prepare($sql);

            $values = array(
                "primary_value" => $primary_value,
            );
            $req_prep->execute($values);

            $req_prep->setFetchMode(PDO::FETCH_CLASS, $class_name);
            $tab_selected = $req_prep->fetchAll();

            if (empty($tab_selected))
                return false;
            return $tab_selected[0];
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            } else {
                echo "Impossible de récupérer $primary_value de la table $class_name";
                echo '<a href=""> retour a la page d\'accueil </a>';
            }
            die();
        }
    }
    

    public static function delete($primary_value) {
        $table_name = static::$object;
        $class_name = 'Model' . ucfirst(str_replace('g_','',$table_name));
        $primary_key = static::$primary;

        try {
            $sql = "DELETE FROM $table_name WHERE $primary_key = :primary_value";
            $req_prep = self::getPDO()->prepare($sql);

            $values = array(
                "primary_value" => $primary_value,
            );

            $req_prep->execute($values);
            return true;
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            } else {
                echo "Impossible de supprimer l'objet $primary_value de la table $class_name";
                echo '<a href=""> retour a la page d\'accueil </a>';
            }
            die();
        }
    }

    public static function update($values, $data)
    {
        $table_name = static::$object;
        try {
            $sql = "UPDATE " . $table_name . " SET";
            foreach (array_keys($values) as $key) {
                $sql .= " $key = :$key, ";
            }
            $sql = rtrim($sql, ", ") . " WHERE";
            foreach (array_keys($data) as $key)
                $sql .= " $key = :$key AND";
            $sql = rtrim($sql, " AND");
            
            $req_prep = Model::getPDO()->prepare($sql);
            $req_prep->execute(array_merge($values, $data));
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            } else {
                echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
            }
            die();
        }
    }

    public static function save($data)
    {
        $table_name = static::$object;
        try {
            $sql = "INSERT INTO " . $table_name . " VALUES (";
            foreach (array_keys($data) as $key)
                $sql .= ":$key, ";
            $sql = rtrim($sql, ", ");
            $sql .= ")";
            $req_prep = Model::getPDO()->prepare($sql);
            $req_prep->execute($data);
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

?>