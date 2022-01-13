<?php

class Controller{

    protected static $object;

    public static function error() {
        $object = 'glasses';
        $controller=$object;
        $view='error';
        $pagetitle='Erreur!';
        require File::build_path(array('view','view.php'));
    }

}