<?php
require_once File::build_path(array('controller','Controller.php'));
require_once File::build_path(array('model','ModelGlasses.php'));

class ControllerGlasses extends Controller {

    protected static $object = 'glasses';

    public static function readAll()
    {
        $controller = self::$object;
        $view = 'list';
        $pagetitle = 'Liste des Lunettes';
        $tab_g = ModelGlasses::selectAll();
        require File::build_path(array('view','view.php'));
    }

    public static function read(){
        if (ModelGlasses::select($_GET['glassesid']) == false){
            require File::build_path(array('view','glasses','error.php'));
            return false;
        }
        $g = ModelGlasses::select($_GET['glassesid']);
        $controller= self::$object;
        $view='detail';
        $pagetitle='Informations de la paire de lunettes';
        require File::build_path(array('view','view.php'));
    }

    public static function create(){
        if (isset($_SESSION['user'])) {
            if($_SESSION['user']->getIsAdmin() == 1) {
                $controller=self::$object;
                $view='create';
                $pagetitle='Inscription';
                require File::build_path(array('view','view.php'));
            }
            else {
                $view='error';
                require File::build_path(array('view','view.php'));
            }
        }
        else {
            $view='error';
            require File::build_path(array('view','view.php'));
        }
    }

    public static function created(){
        ModelGlasses::save(array(
            "id" => $_GET['glassesid'],
            "title" => $_GET['title'], 
            "description" => $_GET['description'], 
            "price" => $_GET['price'],
            "stock" => $_GET['stock']
        ));
        $tab_g = ModelGlasses::selectAll();
        $controller=self::$object;
        $view='created';
        $pagetitle='Article créé';
        require File::build_path(array('view', 'view.php'));
    }

    public static function delete() {
        if (isset($_SESSION['user'])) {
            if($_SESSION['user']->getIsAdmin() == 1) {
                $id = $_GET['glassesid'];
                ModelGlasses::delete($id);
                $tab_g=ModelGlasses::selectAll();
                $controller=self::$object;
                $view='deleted';
                $pagetitle='Article supprimé';
                require File::build_path(array('view', 'view.php'));
            }
            else {
                $view='error';
                require File::build_path(array('view','view.php'));
            }
        }
        else {
            $view='error';
            require File::build_path(array('view','view.php'));
        }
    }

    public static function update(){
        if (isset($_SESSION['user'])) {
            if($_SESSION['user']->getIsAdmin() == 1) {
                $id = $_GET['glassesid'];
                $g = ModelGlasses::select($id);
                $controller=self::$object;
                $view='update';
                $pagetitle='Mise à jour d\'un article';
                require File::build_path(array('view','view.php'));
            }
            else {
                $view='error';
                require File::build_path(array('view','view.php'));
            }
        }
        else {
            $view='error';
            require File::build_path(array('view','view.php'));
        }
    }

    public static function updated(){
        $values = array();
        !empty($_GET['newtitle']) ? $values['title'] = $_GET['newtitle'] : "";
        !empty($_GET['newdescription']) ? $values["description"] = $_GET['newdescription'] : "";
        !empty($_GET['newprice']) ? $values['price'] = ($_GET['newprice']) : "";
        !empty($_GET['newstock']) ? $values['stock'] = ($_GET['newstock']) : "";
        if(!empty($values)){
            ModelGlasses::update($values,array(
                "id" => $_GET['newglassesid']
                )
            );
            $controller=self::$object;
            $view='updated';
            $pagetitle='Maj dun article';
            require File::build_path(array('view','view.php'));
            die;
        }
        $controller=self::$object;
        $view='updated';
        $pagetitle='Maj dun article';
        require File::build_path(array('view','view.php'));
        
    }


}

?>