<?php
class Cart
{
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
		
		/*$sql = "SELECT count(id) FROM cart where user_id = {$user_id}";
		$db = DB::getInstance(Config::get('db.host'), Config::get('db.user'), Config::get('db.password'), Config::get('db.db_name'));
		$res = $db->query($sql);
		print_r($res);
		$this->products = Cookie::get('ads') == null ? array() : $res[0];
        /*$this->products = Cookie::get('ads') == null ?
            array()
            :
            unserialize(Cookie::get('ads'));*/
    }


    /**
     * products getter
     *
     * @return mixed
     */
    public function getProducts($user_id)
    {		
	
$sql = "SELECT count(id) FROM cart where user_id = {$user_id}";
		$db = DB::getInstance(Config::get('db.host'), Config::get('db.user'), Config::get('db.password'), Config::get('db.db_name'));
		$res = $db->query($sql);
		print_r($res);	
        return $this->products;
    }


    /**
     * adding product
     *
     * @param $id
     */
    public function addProduct($id, $user)
    {
        $id = (int)$id;
		$user_id = (int)$user;
		

        if (!in_array($id, $this->products)) {
            array_push($this->products, $id);
        }

        Cookie::set('ads'.$user_id, serialize($this->products));
    }


    /**
     * deleting product
     *
     * @param $id
     */
    public function deleteProduct($id, $user_id)
    {
        $id = (int)$id;

        $key = array_search($id, $this->products);
        if ($key !== false){
            unset($this->products[$key]);
        }

        Cookie::set('ads'.$user_id, serialize($this->products));
    }


    /**
     *  clear cart
     */
    public function clear()
    {
        Cookie::delete('ads');
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
