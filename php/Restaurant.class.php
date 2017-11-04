<?php

class Restaurant{

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

        $sql = "SELECT r.name, r.description, r.postalcode, r.streetaddress, r.city, r.restaurant_type, u.firstname as manager_firstname, u.lastname as manager_lastname, u.email as manager_email
                FROM restaurant as r
                INNER JOIN users as u
                ON r.owner_id = u.user_id
                LIMIT 1";
        $result = $db->query($sql);
        $result = $result->fetch_assoc();

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



}