<?php
require_once File::build_path(array("model", "ModelCart.php"));
require_once File::build_path(array('model','ModelUser.php'));

class ControllerCart extends Controller
{
    protected static $object = 'cart';

    public static function addToCart() {
        if(!isset($_SESSION['user'])){
            self::$object = 'user';
            $view = 'connect';
            $pagetitle = 'Connexion';
            require File::build_path(array('view','view.php'));
            die;
        }
        $controller = self::$object;
        $u = $_SESSION['user']->getLogin();
        $g = $_GET['glassesid'];
        if(ModelCart::isInStock($g) == false){
            $view = 'outOfStock';
            $pagetitle = 'Votre panier';
            require File::build_path(array("view", "view.php"));
            die;
        }
        ModelCart::addToCart($u, $g);
        $view = 'productAdded';
        $pagetitle = 'Votre panier';
        require File::build_path(array("view", "view.php"));
    }

    public static function read()
    {
        $controller = self::$object;
        $u = $_SESSION['user']->getLogin();
        $tab_c = ModelCart::getCartByUser($u);
        if($tab_c == false){
            $view='emptyCart';
            $pagetitle='Panier';
            require File::build_path(array('view','view.php'));
            die;
        }
        $i = 0;
        foreach ($tab_c as $c) {
            $tab[$i]['quantity'] = $c->getQuantity();
            $tab[$i]['id_glasses'] = htmlspecialchars($c->getIdGlasses());
            $tab[$i]['price'] = ModelGlasses::select($c->getIdGlasses())->getPrice();
            $i++;
        };
        

        $view='detail';
        $pagetitle='Panier';
        require File::build_path(array('view','view.php'));
    }

    public static function error($error = 'Une erreur est survenue')
    {
        $view = 'error';
        $pagetitle = 'Une erreur est survenue';
        require File::build_path(array("view", "view.php"));
    }
}
