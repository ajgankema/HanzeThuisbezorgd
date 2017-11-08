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
}