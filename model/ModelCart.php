<?php

require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelGlasses.php'));

class ModelCart extends Model {

    private $login_user;
    private $id_glasses;
    private $quantity;

    protected static $object = 'g_cart';
    protected static $primary = 'login_user';

    public function __construct($login_user = NULL, $id_glasses = NULL, $quantity = NULL)
    {
        if (!is_null($login_user) && !is_null($id_glasses) && !is_null($quantity)) {
            $this->login_user = $login_user;
            $this->id_glasses = $id_glasses;
            $this->quantity = $quantity;
        }
    }

    public function getLoginUser() {
        return $this->login_user;
    }

    public function getIdGlasses() {
        return $this->id_glasses;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getPrice() {
        return $this->price;
    }

    public static function addToCart($login_user, $id_glasses) {
        try {
            $sql = "SELECT stock FROM g_glasses WHERE id = :id";
            $req_prep = Model::getPDO()->prepare($sql);
            $values = array(
                'id' => $id_glasses
            );
            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelGlasses');
            $s = $req_prep->fetch();
            if($s->getStock() > 0){
                $sql = "SELECT * FROM g_cart WHERE login_user = :login_user AND id_glasses = :id_glasses";
                $req_prep = Model::getPDO()->prepare($sql);

                $values = array(
                    'login_user' => $login_user,
                    'id_glasses' => $id_glasses
                );
                $req_prep->execute($values);
                $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelCart');
                $p = $req_prep->fetch();
                if ($p == false) {
                    $sql = "INSERT INTO g_cart(login_user, id_glasses, quantity) VALUES (:login_user, :id_glasses, '1')";
                    $req_prep = Model::getPDO()->prepare($sql);

                    $values = array(
                        'login_user' => $login_user,
                        'id_glasses' => $id_glasses,
                    );
                    $req_prep->execute($values);
                    //return true;
                } else {
                    $sql = "UPDATE `g_cart` SET `quantity` = `quantity` + 1 WHERE login_user = :login_user AND id_glasses = :id_glasses";
                    $req_prep = Model::getPDO()->prepare($sql);

                    $values = array(
                        'login_user' => $login_user,
                        'id_glasses' => $id_glasses,
                    );
                    $req_prep->execute($values);
                }
                $sql = "UPDATE `g_glasses` SET `stock` = `stock` - 1 WHERE id = :id";
                $req_prep = Model::getPDO()->prepare($sql);
                $values = array(
                    'id' => $id_glasses
                );
                $req_prep->execute($values);
                return true;
            }else{
                return false;
            }
            
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            } else {
                echo 'Impossible de récupérer le panier de l\'utilisateur : ', $login_user;
            }
            die();
        }
    }

    public static function isInStock($id){
        $sql = "SELECT stock FROM g_glasses WHERE id = :id";
        $req_prep = Model::getPDO()->prepare($sql);
        $values = array(
            'id' => $id
        );
        $req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelGlasses');
        $stock = $req_prep->fetch();
        if($stock->getStock() <= 0){
            return false;
        }else{
            return true;
        }

    }

    public static function getCartByUser($login) {
        try {
            $sql = "SELECT * FROM g_cart WHERE login_user = :login_user";
            // Préparation de la requête
            $req_prep = Model::getPDO()->prepare($sql);
    
            $values = array(
                "login_user" => $login,
            );
            // On donne les valeurs et on exécute la requête	 
            $req_prep->execute($values);
        
            // On récupère les résultats comme précédemment
            $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelCart');
            $tab_c = $req_prep->fetchAll();
            // Attention, si il n'y a pas de résultats, on renvoie false
            if (empty($tab_c))
                return false;
            return $tab_c;
        } catch(PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage(); // affiche un message d'erreur
            } else {
                echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
            }
            die();
        }
    }

}