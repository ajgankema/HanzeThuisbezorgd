<?php

class User{

    private $loggedIn = false;
    private $role = null;
    private $firstname = null;
    private $lastname = null;
    private $email = null;
    private $user_id = null;

    /**
     * Constructor
     */
    public function __construct(){

        if(!isset($_SESSION))session_start();
        if(isset($_SESSION['user_id'])){
            //Gebruiker is al ingelogd als de statement TRUE is
            $this->loggedIn=true;
            $this->role=$_SESSION['role_name'];
            $this->firstname=$_SESSION['firstname'];
            $this->lastname=$_SESSION['lastname'];
            $this->email=$_SESSION['email'];
            $this->user_id=$_SESSION['user_id'];
        }

    }

    /**
     * General
     */

    //Is de huidige gebruiker ingelogd?
    public function isLoggedIn(){
        return $this->loggedIn;
    }

    //Is de huidige gebruiker een administrator?
    public function isAdmin(){
        //Return true als de gebruiker wel een administrator is
        if($this->isLoggedIn()){
            if($_SESSION['role_id']==2)return true;
        }
        return false;
    }

    //Is de huidige gebruiker een restaurant beheerder?
    public function isRestaurantManager(){
        //Return true als de gebruiker wel een restaurant beheerder is
        if($this->isLoggedIn()){
            if($_SESSION['role_id']==3)return true;
        }
        return false;
    }

    /**
     * Login & Registratie
     */

    //De registratie van de gebruiker
    public function register($firstname, $lastname, $email, $password, $password_repeat){

        //Variable klaar zetten
        $error = array();

        //Include important files
        include_once("config.php");
        include_once("db.php");

        //Connect to the database
        $db = (new Db())->getConnection();

        //Escape alle strings
        $firstname = $db->real_escape_string($firstname);
        $lastname = $db->real_escape_string($lastname);
        $email = $db->real_escape_string($email);
        $password = $db->real_escape_string($password);
        $password_repeat = $db->real_escape_string($password_repeat);

        //Zijn alle velden lang genoeg?
        if(strlen($firstname)<2)$error[5]=true;   //Voornaam te kort
        if(strlen($lastname)<2)$error[6]=true;  //Achternaam te kort
        if(strlen($email)<5)$error[7]=true;     //Email te kort
        if(strlen($password)<5)$error[8]=true;  //Wachtwoord te kort

        //Is de email wel echt een email?
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error[7]=true;
        }

        //Als er een error aanwezig is, dan word die nu gereturned
        if(!empty($error))return $error;

        //Komen de wachtwoorden overeen?
        if($password!=$password_repeat)return 2;    //Een bericht weergeven dat de wachtwoorden niet overeen komen

        //Is het e-mail al eerder geregistreerd?
        $sql = "SELECT email
                FROM users
                WHERE email = '$email'";
        $result = $db->query($sql);
        if($result->num_rows)return 3;      //Een bericht laten weergeven dat de email al bestaat

        //Wachtwoord encryptie
        $hash = password_hash($password, PASSWORD_BCRYPT, $config['ENCRYPT_OPTIONS']);

        //Gebruiker opslaan
        $sql = "INSERT INTO users
                  (firstname, lastname, email, hash)
                VALUES
                  ('$firstname','$lastname','$email','$hash')";
        $result = $db->query($sql);

        //Database afsluiten
        $db->close();

        if($result){
            //Registratie successvol!
            //Nu kan de gebruiker ook gelijk worden ingelogd

            if($this->tryLogin($email, $password))return true;  //Gebruiker geregistreerd en ingelogd

        }

        return 4;   //Er ging iets fout

    }

    //Een login poging wagen
    public function tryLogin($email, $password){

        //Include important files
        include_once("db.php");

        //Connect to the database
        $db = (new Db())->getConnection();

        //Escape the strings
        $email = $db->real_escape_string($email);
        $password = $db->real_escape_string($password);

        //Get appointed user
        $sql = "SELECT u.user_id, u.firstname, u.lastname, u.email, u.hash, u.active, u.role_id, r.role_name
                FROM users as u
                INNER JOIN roles as r
                ON r.role_id = u.role_id
                WHERE u.email = '$email'";
        $results = $db->query($sql);
        $results = $results->fetch_assoc();

        //De hash van de gebruiker
        $hash = $results['hash'];

        //Komt het overeen met het wachtwoord als je het in een hash gooit?
        if(password_verify($password,$hash)){

            //Het wachtwoord komt overeen met de hash, de gebruiker mag nu worden ingelogd
            $this->setSessions($results);
            return true;

        }

        //Inloggen mislukt
        return 2;

    }

    //Een functie voor inloggen
    private function setSessions($user){
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['firstname'] = $user['firstname'];
        $_SESSION['lastname'] = $user['lastname'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role_id'] = $user['role_id'];
        $_SESSION['role_name'] = $user['role_name'];
        return true;
    }

    //De gebruiker uitloggen
    public function logout(){
        //Gebruiker sessies legen
        unset($_SESSION['user_id']);
        unset($_SESSION['firstname']);
        unset($_SESSION['lastname']);
        unset($_SESSION['email']);
        unset($_SESSION['role_id']);
        unset($_SESSION['role_name']);

        $this->loggedIn = false;
    }

    public function newPassword($pass, $new_pass, $new_pass_again){

        //Making ready a variable
        $error = array();

        //Include important files
        include_once("config.php");
        include_once("db.php");

        //Connect to the database
        $db = (new Db())->getConnection();

        //Escape strings
        $pass = $db->real_escape_string($pass);
        $new_pass = $db->real_escape_string($new_pass);
        $new_pass_again = $db->real_escape_string($new_pass_again);
        $user_id = $db->real_escape_string($this->getUserId());

        //Have the fields been entered correctly?
        if(strlen($new_pass)<5)$error[2]=true;    //Not long enough

        //Komen de wachtwoorden overeen?
        if($new_pass!=$new_pass_again)$error[3]=true;    //Een bericht weergeven dat de wachtwoorden niet overeen komen

        //Is het wachtwoord correct?
        $sql = "SELECT hash
                FROM users
                WHERE user_id = '$user_id'";
        $result = $db->query($sql);
        $result = $result->fetch_assoc();

        //De hash van de gebruiker
        $hash = $result['hash'];

        //Komt het overeen met het wachtwoord als je het in een hash gooit?
        if(!password_verify($pass,$hash)){
            $error[4]=true;     //Wachtwoord was incorrect
        }

        //Als er een error aanwezig is, dan word die nu gereturned
        if(!empty($error))return $error;

        //Wachtwoord encryptie
        $hash = password_hash($new_pass, PASSWORD_BCRYPT, $config['ENCRYPT_OPTIONS']);

        //Save it to the database
        $sql = "UPDATE users
                SET
                  hash = '$hash'
                WHERE
                  user_id = '$user_id'";
        $result = $db->query($sql);

        //Close the database
        $db->close();

        //Has it been uploaded?
        if($result){
            return true;
        }
        return false;

    }


    /**
     * Adres functies
     */

    public function addAddress($streetname, $housenumber, $postalcode, $city, $standard){

        //Making ready a variable
        $error = array();

        //Include important files
        include_once("db.php");

        //Connect to the database
        $db = (new Db())->getConnection();

        //Escape strings
        $streetname = $db->real_escape_string($streetname);
        $housenumber = $db->real_escape_string($housenumber);
        $postalcode = $db->real_escape_string($postalcode);
        $city = $db->real_escape_string($city);
        $standard = $db->real_escape_string($standard);
        $user_id = $db->real_escape_string($this->getUserId());

        //Will the address be standard?
        if(!empty($standard)){
            $standard=1;    //The address will be a standard address
        } else {
            $standard=0;    //The address wont be a standard address
        }

        //Have the fields been entered correctly?
        if(strlen($streetname)<3)$error[2]=true;    //Not long enough
        if(strlen($housenumber)<1)$error[3]=true;   //Nothing filled in
        if(strlen($postalcode)<6)$error[4]=true;    //Dutch postal code is always 6 long
        if(strlen($city)<3)$error[5]=true;          //Not long enough

        //Als er een error aanwezig is, dan word die nu gereturned
        if(!empty($error))return $error;

        //Save it to the database
        $sql = "INSERT INTO Addresses
                  (streetname, housenumber, postalcode, city, standard_address, user_id)
                VALUES
                  ('$streetname','$housenumber','$postalcode','$city','$standard','$user_id')";
        $result = $db->query($sql);

        //Close the database
        $db->close();

        //Has it been uploaded?
        if($result){
            return true;
        }
        return false;

    }

    public function editAddress($streetname, $housenumber, $postalcode, $city, $standard, $address_id){

        //Making ready a variable
        $error = array();

        //Include important files
        include_once("db.php");

        //Connect to the database
        $db = (new Db())->getConnection();

        //Escape strings
        $streetname = $db->real_escape_string($streetname);
        $housenumber = $db->real_escape_string($housenumber);
        $postalcode = $db->real_escape_string($postalcode);
        $city = $db->real_escape_string($city);
        $standard = $db->real_escape_string($standard);
        $address_id = $db->real_escape_string($address_id);
        $user_id = $db->real_escape_string($this->getUserId());

        //Will the address be standard?
        if(!empty($standard)){
            $standard=1;    //The address will be a standard address
        } else {
            $standard=0;    //The address wont be a standard address
        }

        //Have the fields been entered correctly?
        if(strlen($streetname)<3)$error[2]=true;    //Not long enough
        if(strlen($housenumber)<1)$error[3]=true;   //Nothing filled in
        if(strlen($postalcode)<6)$error[4]=true;    //Dutch postal code is always 6 long
        if(strlen($city)<3)$error[5]=true;          //Not long enough

        //Als er een error aanwezig is, dan word die nu gereturned
        if(!empty($error))return $error;

        //Save it to the database
        $sql = "UPDATE Addresses
                SET
                  streetname = '$streetname',
                  housenumber = '$housenumber',
                  postalcode = '$postalcode',
                  city = '$city',
                  standard_address = $standard
                WHERE
                  user_id = '$user_id'
                AND
                  address_id = '$address_id'";
        $result = $db->query($sql);

        //Close the database
        $db->close();

        //Has it been uploaded?
        if($result){
            return true;
        }
        return false;

    }

    public function removeAddress($address_id){

        //Include important files
        include_once("db.php");

        //Connect to the database
        $db = (new Db())->getConnection();

        //Escape strings
        $address_id = $db->real_escape_string($address_id);
        $user_id = $db->real_escape_string($this->getUserId());

        //Do database
        $sql = "DELETE FROM addresses
                WHERE address_id = '$address_id'
                AND user_id = '$user_id'";
        $result = $db->query($sql);

        if($result){
            return true;
        }
        return false;

    }

    public function getAddresses(){

        //Include important files
        include_once("db.php");

        //Connect to the database
        $db = (new Db())->getConnection();

        //Escape strings
        $user_id = $db->real_escape_string($this->getUserId());

        //Get the addresses
        $sql = "SELECT address_id, streetname, housenumber, postalcode, city, standard_address
                FROM addresses
                WHERE user_id = '$user_id'";
        $results = $db->query($sql);

        //Making a cleaner array
        $array = array();
        while($row = $results->fetch_assoc()){
            array_push($array,$row);
        }

        return $array;

    }


    /**
     *  Review functies
     */

    public function addUserReview($title, $description, $rating){

        //Making ready a variable
        $error = array();

        //Include important files
        include_once("db.php");

        //Connect to the database
        $db = (new Db())->getConnection();

        //Escape strings
        $title = $db->real_escape_string($title);
        $description = $db->real_escape_string($description);
        $rating = $db->real_escape_string($$rating);
        $user_id = $db->real_escape_string($this->getUserId());

        //Will the address be standard?
        if(!empty($standard)){
            $standard=1;    //The address will be a standard address
        } else {
            $standard=0;    //The address wont be a standard address
        }

        //Have the fields been entered correctly?
        if(strlen($title)<3)$error[2]=true;    //Not long enough
        if(strlen($description)<1)$error[3]=true;   //Nothing filled in

        //Als er een error aanwezig is, dan word die nu gereturned
        if(!empty($error))return $error;

        //Save it to the database
        $sql = "INSERT INTO Reviews
                  (title, description, rating)
                VALUES
                  ('$title','$description','$rating')
                WHERE user_id = '$user_id'";

        $result = $db->query($sql);

        //Close the database
        $db->close();

        //Has it been uploaded?
        if($result){
            return true;
        }
        return false;

    }

    public function getAllUserReviews(){

        //Include important files
        include_once("db.php");

        //Connect to the database
        $db = (new Db())->getConnection();

        //Escape strings
        $user_id = $db->real_escape_string($this->getUserId());

        //Get the Reviews
        $sql = "SELECT review_id, reviews.restaurant_id, user_id, title, reviews.description, rating, restaurant.name 
                FROM reviews 
                INNER JOIN restaurant ON restaurant.restaurant_id = reviews.restaurant_id
                WHERE user_id = '$user_id'";
        $results = $db->query($sql);
        //Making a cleaner array
        $array = array();
        while($row = $results->fetch_assoc()){
            array_push($array,$row);
        }
        return $array;

    }

    public function removeReview($review_id){

        //Include important files
        include_once("db.php");

        //Connect to the database
        $db = (new Db())->getConnection();

        //Escape strings
        $user_id = $db->real_escape_string($this->getUserId());

        //Get the Reviews
        $sql = "DELETE FROM reviews
                WHERE review_id = '$review_id'";
        $result = $db->query($sql);
        if($result){
            header("Location: ".$config['Base_URL']."/Thuisbezorgd/Account/index.php");
            return true;
        }
        return false;

    }
        public function updateReview($title, $description, $rating, $review_id){

        //Include important files
        include_once("db.php");


        $db = (new Db())->getConnection();

        //Escape strings
        $title = $db->real_escape_string($title);
        $description = $db->real_escape_string($description);
        $rating = $db->real_escape_string($rating);
        $review_id = $db->real_escape_string($review_id);

        //Have the fields been entered correctly?
        if(strlen($title)<3)$error[2]=true;    //Not long enough
        //if(strlen($description)<1)$error[3]=true;   //Nothing filled in
        if(strlen($rating)<1)$error[4]=true;    //Dutch postal code is always 6 long

        //Als er een error aanwezig is, dan word die nu gereturned
        if(!empty($error))return $error;

        //Get the Reviews
        $sql = "UPDATE reviews
                SET
                  title = '$title',
                  description = '$description',
                  rating = '$rating'
                WHERE
                  review_id = '$review_id'";
        $result = $db->query($sql);
        if($result){
            header("Location: ".$config['Base_URL']."/Thuisbezorgd/Account/index.php");
            return true;
        }
        return false;

    }
    /**
     * Getters
     */

    public function getRole(){
        return $this->role;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

}