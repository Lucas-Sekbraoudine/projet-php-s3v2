<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR .'File.php';
require_once File::build_path(array('model','ModelUser.php'));
session_start();
require File::build_path(array('controller','routeur.php'));


