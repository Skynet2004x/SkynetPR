<?php
// класс корзины.. по сути нужен для вывода количества товаров в корзине и очистки ее.
class Cart {
    private $products;

    function __construct($user_id)
    {
	$sql = "SELECT id as c FROM cart where user_id = {$user_id}";
		$db = DB::getInstance(Config::get('db.host'), Config::get('db.user'), Config::get('db.password'), Config::get('db.db_name'));
		$res = $db->query($sql);		
		$this->products = $res === null ? array() : $res;
    }

    public function getProducts($user_id)
    {	
		return $this->products;
    }

    public function clear($user_id)
    {
        $sql = "delete FROM cart where user_id = {$user_id}";
		$db = DB::getInstance(Config::get('db.host'), Config::get('db.user'), Config::get('db.password'), Config::get('db.db_name'));
		$res = $db->query($sql);
		return true;
    }

    public function isEmpty()
    {
        return !$this->products;
    }
}