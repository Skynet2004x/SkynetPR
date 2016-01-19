<?php

class Cart {
    /**
     * Products array
     *
     * @var array|mixed
     */
    private $products;


    /**
     *  Constructor
     */
    function __construct($user_id)
    {
	$sql = "SELECT id as c FROM cart where user_id = {$user_id}";
		$db = DB::getInstance(Config::get('db.host'), Config::get('db.user'), Config::get('db.password'), Config::get('db.db_name'));
		$res = $db->query($sql);		
		$this->products = $res === null ? array() : $res;
    }


    /**
     * products getter
     *
     * @return mixed
     */
    public function getProducts($user_id)
    {	
		return $this->products;
    }


    /**
     * adding product
     *
     * @param $id
     */
    public function addProduct($id)
    {
        /*$id = (int)$id;

        if (!in_array($id, $this->products)) {
            array_push($this->products, $id);
        }

        Cookie::set('ads', serialize($this->products));*/
    }


    /**
     * deleting product
     *
     * @param $id
     */
    public function deleteProduct($id)
    {
        /*$id = (int)$id;

        $key = array_search($id, $this->products);
        if ($key !== false){
            unset($this->products[$key]);
        }

        Cookie::set('ads', serialize($this->products));*/
    }


    /**
     *  clear cart
     */
    public function clear($user_id)
    {
        $sql = "delete FROM cart where user_id = {$user_id}";
		$db = DB::getInstance(Config::get('db.host'), Config::get('db.user'), Config::get('db.password'), Config::get('db.db_name'));
		$res = $db->query($sql);
		return true;
    }



    /**
     * check if empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        return !$this->products;
    }
}