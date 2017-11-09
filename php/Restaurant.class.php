<?php

class Restaurant{

    private $restaurant_id;
    private $name;
    private $description;
    private $postalcode;
    private $streetaddress;
    private $city;
    private $restaurant_type;
    private $manager_firstname;
    private $manager_lastname;
    private $manager_email;

    public function __construct(){

        global $db;
        if(empty($db)){
            include_once("db.php");
            $db = (new Db())->getConnection();
        }

        $sql = "SELECT r.restaurant_id, r.name, r.description, r.postalcode, r.streetaddress, r.city, r.restaurant_type, u.firstname as manager_firstname, u.lastname as manager_lastname, u.email as manager_email
                FROM restaurant as r
                INNER JOIN users as u
                ON r.owner_id = u.user_id
                LIMIT 1";
        $result = $db->query($sql);
        $result = $result->fetch_assoc();

        $this->restaurant_id = $result['restaurant_id'];
        $this->name = $result['name'];
        $this->description = $result['description'];
        $this->postalcode = $result['postalcode'];
        $this->streetaddress = $result['streetaddress'];
        $this->city = $result['city'];
        $this->restaurant_type = $result['restaurant_type'];
        $this->manager_firstname = $result['manager_firstname'];
        $this->manager_lastname = $result['manager_lastname'];
        $this->manager_email = $result['manager_email'];

    }

    /**
     * @return Integer
     */
    public function getRestaurantId()
    {
        return $this->restaurant_id;
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return String
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return String
     */
    public function getPostalcode()
    {
        return $this->postalcode;
    }

    /**
     * @return String
     */
    public function getStreetaddress()
    {
        return $this->streetaddress;
    }

    /**
     * @return String
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return String
     */
    public function getRestaurantType()
    {
        return $this->restaurant_type;
    }

    /**
     * @return String
     */
    public function getManagerFirstname()
    {
        return $this->manager_firstname;
    }

    /**
     * @return String
     */
    public function getManagerLastname()
    {
        return $this->manager_lastname;
    }

    /**
     * @return String
     */
    public function getManagerEmail()
    {
        return $this->manager_email;
    }

    /**
     * @param = the new name or w/e
     * Sets the new value for every restaurant param
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function setPostalcode($postalcode)
    {
        $this->postalcode = $postalcode;
    }
    public function setStreetaddress($streetaddress)
    {
        $this->streetaddress = $streetaddress;
    }
    public function setCity($city)
    {
        $this->city = $city;
    }
    public function setRestaurantType($type)
    {
        $this->restaurant_type = $type;
    }

    /**
     * Saves the new values in the database
     */
    public function saveRestaurant()
    {
        global $db;

        $qry = "UPDATE restaurant SET 
                  name = '$this->name',
                  description = '$this->description',
                  postalcode = '$this->postalcode',
                  streetaddress = '$this->streetaddress',
                  city = '$this->city',
                  restaurant_type = '$this->restaurant_type'
                  WHERE restaurant_id = '$this->restaurant_id'";
        $result = $db->query($qry);
        if($result)
            return true;

        return false;
    }

    /**
     * Places a order for the restaurant
     */
    public function placeOrder($user_id, $streetname, $housenumber, $postalcode, $city, $payment, $shoppingcart_array){

        //Setup the variables
        $error = array();
        $datetime = date("Y-m-d H:i:s");

        //Include important files
        include_once("db.php");

        //Connect to the database
        $db = (new Db())->getConnection();

        //Escape strings
        $user_id = $db->real_escape_string($user_id);
        $streetname = $db->real_escape_string($streetname);
        $housenumber = $db->real_escape_string($housenumber);
        $postalcode = $db->real_escape_string($postalcode);
        $city = $db->real_escape_string($city);
        $payment = $db->real_escape_string($payment);
        $restaurant_id = $db->real_escape_string($this->getRestaurantId());

        //Have the fields been entered correctly?
        if(strlen($streetname)<3)$error[2]=true;    //Not long enough
        if(strlen($housenumber)<1)$error[3]=true;   //Nothing filled in
        if(strlen($postalcode)<6)$error[4]=true;    //Dutch postal code is always 6 long
        if(strlen($city)<3)$error[5]=true;          //Not long enough

        //Als er een error aanwezig is, dan word die nu gereturned
        if(!empty($error))return $error;

        //Save it to the database
        $sql = "INSERT INTO orders
                  (restaurant_id, user_id, streetname, housenumber, postalcode, city, date_created)
                VALUES
                  ('$restaurant_id','$user_id','$streetname','$housenumber','$postalcode','$city','$datetime')";
        $result = $db->query($sql);

        //Get the order_id
        $sql = "SELECT order_id
                FROM orders
                ORDER BY order_id DESC
                LIMIT 1";
        $result = $db->query($sql);
        $order_id = $result->fetch_assoc()['order_id'];

        //Put the shoppingcart array in a reasonable array
        $orders_id = array();
        $orders_price = array();
        $order = "";
        foreach($shoppingcart_array as $key=>$value){
            $prod_id = $value['product_id'];
            $price = $value['price'];
            for($x=0;$x<$value['max_amount'];$x++){
                if(strlen($order)>0)$order.=",";
                $order.="(";
                $order.=$order_id.",".$prod_id.",".$price;
                array_push($orders_id,$prod_id);
                array_push($orders_price,$price);
                $order.=")";
            }
        }

        //Save it to the database
        $sql = "INSERT INTO order_contents
                  (order_id, product_id, price)
                VALUES
                  $order";
        $result = $db->query($sql);

        return true;

    }

    public function getOrders(){

        //Include important files
        include_once("db.php");

        //Connect to the database
        $db = (new Db())->getConnection();

        //Escape strings
        $restaurant_id = $db->real_escape_string($this->getRestaurantId());

        //Get the addresses
        $sql = "SELECT u.firstname, u.lastname, u.email, o.order_id, o.streetname, o.housenumber, o.postalcode, o.city, o.date_created
                FROM orders as o
                INNER JOIN users as u
                ON o.user_id = u.user_id
                WHERE o.restaurant_id = '$restaurant_id'
                ORDER BY date_created DESC";
        $results = $db->query($sql);

        //Making a cleaner array
        $array = array();
        while($row = $results->fetch_assoc()){
            array_push($array,$row);
        }

        return $array;

    }

    public function getOrderDetails($order_id){

        //Include important files
        include_once("db.php");

        //Connect to the database
        $db = (new Db())->getConnection();

        //Escape strings
        $restaurant_id = $db->real_escape_string($this->getRestaurantId());
        $order_id = $db->real_escape_string($order_id);

        //Get the order contents
        $sql = "SELECT DISTINCT p.name, oc.price, (SELECT COUNT(product_id) FROM order_contents WHERE order_id=oc.order_id AND product_id=oc.product_id) as aantal
                FROM order_contents as oc
                INNER JOIN products as p
                ON p.product_id = oc.product_id
                WHERE order_id = '$order_id'";
        $results = $db->query($sql);

        //Making a cleaner array
        $array = array();
        while($row = $results->fetch_assoc()){
            array_push($array,$row);
        }

        return $array;

    }

}