<?php
require_once File::build_path(array('model','ModelUser.php'));
require_once File::build_path(array('lib','Security.php'));

Class ControllerUser extends Controller{

    protected static $object = 'user';

    


    public static function readAll() {
        $tab_u = ModelUser::selectAll(); 

        $view = 'list';
        $pagetitle = 'Liste des utilisateurs';
        require File::build_path(array('view','view.php'));
    }

    public static function read(){
        if (ModelUser::select($_GET['login']) == false){
            require File::build_path(array('view','user','error.php'));
            return false;
        }
        $u = ModelUser::select($_GET['login']);
        $controller='user';
        $view='detail';
        $pagetitle='Informations de l\'utilisateur';
        require File::build_path(array('view','view.php'));
    }

    public static function update(){
        if (isset($_SESSION['user'])) {
            if($_SESSION['user']->getIsAdmin() == 1) {
                $login = $_GET['login'];
                $u = ModelUser::select($login);
                $controller='user';
                $view='update';
                $pagetitle="Mise à jour";
                $isUpdating=true;
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
        !empty($_GET['newname']) ? $values["name"] = $_GET['newname'] : "";
        !empty($_GET['newsurname']) ? $values["surname"] = $_GET['newsurname'] : "";
        !empty($_GET['newpassword']) ? $values["password"] = Security::hacher($_GET['newpassword']) : "";
        if (!empty($values)) {
            ModelUser::update($values, array(
                "login" => $_GET['login']
                )
            );
            $controller='user';
            $view='updated';
            $pagetitle='Maj dun utilisateur';
            require File::build_path(array('view','view.php'));
        }else{
            $controller='user';
            $view='updated';
            $pagetitle='Maj dun utilisateur';
            require File::build_path(array('view','view.php'));
        }
        

    }

    public static function delete(){
        if (isset($_SESSION['user'])) {
            if($_SESSION['user']->getIsAdmin() == 1) {
                $login = $_GET['login'];
                ModelUser::delete($login);
                $tab_u = ModelUser::selectAll();
                $controller='user';
                $view='deleted';
                $pagetitle='Suppression utilisateur';
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
    
    public static function create() {
            $controller='user';
            $view='update';
            $pagetitle='Créer un nouveau compte';
            $isUpdating=false;
            require File::build_path(array('view','view.php'));
    }

    public static function created() {
        $data = array (
            "newpassword" => Security::hacher($_GET['newpassword']),
            "confirmed_password" => Security::hacher($_GET['confirmed_password'])
        );
        if (ModelUser::passwordMatched($data)) {
            ModelUser::save(array(
                    "login" => $_GET['login'],
                    "name" => $_GET['newname'],
                    "surname" => $_GET['newsurname'],
                    "password" => Security::hacher($_GET['newpassword']),
                    "isAdmin" => 0
                )
            );
            $tab_u = ModelUser::selectAll();
            $controller='user';
            $view='created';
            $pagetitle='Utilisateur créé';
            require File::build_path(array('view', 'view.php'));
        } else {
            $tab_u = ModelUser::selectAll();
            $controller='user';
            $view='errorPasswordConfirmation';
            $pagetitle='Erreur';
            require File::build_path(array('view', 'view.php'));
        }
        
    }

    public static function connect() {
        $controller = 'user';
        $view='connect';
        $pagetitle='Connexion';
        require File::build_path(array('view', 'view.php')); 
    }

    public static function connected() {
        $data = array(
            "login" => $_GET['login'],
            "password" => Security::hacher($_GET['password'])
        );
        $u = ModelUser::connect($data);
        if($u == false){
            $controller = 'user';
            $view='errorConnect';
            $pagetitle='Erreur!';
            require File::build_path(array('view','view.php'));
        }else{
            $_SESSION['user'] = $u;
            $controller = 'user';
            $view='connected';
            $pagetitle='Connecté';
            require File::build_path(array('view', 'view.php'));
        }
    }

    public static function setAdmin() {
        if (isset($_SESSION['user'])) {
            if($_SESSION['user']->getIsAdmin() == 1) {
                $login = $_GET['login'];
                ModelUser::setAdmin($login);
                $controller = 'user';
                $view = 'setAdminDone';
                $pagetitle = 'Administrateur créé';
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

    public static function removeAdmin() {
        if (isset($_SESSION['user'])) {
            if($_SESSION['user']->getIsAdmin() == 1) {
                $login = $_GET['login'];
                ModelUser::removeAdmin($login);
                $controller = 'user';
                $view = 'removeAdminDone';
                $pagetitle = 'Cet utilisateur n\'est plus administrateur';
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

    public static function disconnect() {
        session_unset();
        $tab_g = ModelGlasses::selectAll();
        $controller = 'user';
        $view='disconnect';
        require File::build_path(array('view', 'view.php'));
    }

}