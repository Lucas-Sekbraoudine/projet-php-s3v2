<?php

require_once File::build_path(array('model', 'Model.php'));

class ModelGlasses extends Model {
    private $id;
    private $title;
    private $description;
    private $price;
    private $stock;

    protected static $object = 'g_glasses';
    protected static $primary = 'id';

    public function __construct($id = NULL, $title = NULL, $description = NULL, $price = NULL)
    {
        if (!is_null($id) && !is_null($title) && !is_null($description) && !is_null($price)) {
            $this->id = $id;
            $this->title = $title;
            $this->description = $description;
            $this->price = $price;
        }
    }
    

    // id      

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }


    // title      

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }


    // description      

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }


    // price      

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function setStock($stock)
    {
        return $this->stock = $stock;
    }

}




