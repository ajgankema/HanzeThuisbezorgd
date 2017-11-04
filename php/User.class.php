<?php

class User{

    private $loggedIn = false;
    private $role = null;
    private $firstname = null;
    private $lastname = null;
    private $email = null;

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
        }

    }

    /**
     * Important user functions
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

}