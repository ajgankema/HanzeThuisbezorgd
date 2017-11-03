<?php

class User{

    private $loggedIn = false;

    public function __construct(){

        if(!isset($_SESSION))session_start();
        if(isset($_SESSION['user_id']))$this->loggedIn=true;   //Gebruiker is al ingelogd als de statement TRUE is

    }

    public function isLoggedIn(){
        return $this->loggedIn;
    }

    //Is de huidige gebruiker een administrator?
    public function isAdmin(){
        //Return true als de gebruiker wel een administrator is
        if(isLoggedIn()){
            if($_SESSION['type']==1)return true;
        }
        return false;
    }

    //De gebruiker uitloggen
    public function logout(){
        //Gebruiker sessies legen
        unset($_SESSION['user_id']);
        unset($_SESSION['firstname']);
        unset($_SESSION['lastname']);
        unset($_SESSION['email']);
        unset($_SESSION['type']);

        $this->loggedIn = false;
    }

    //De registratie van de gebruiker
    public function register($post){

        //Include important files
        include_once("config.php");
        include_once("db.php");

        //Connect to the database
        $db = (new Db())->getConnection();

        //Escape alle strings
        $firstname = $db->real_escape_string($_POST['firstname']);
        $lastname = $db->real_escape_string($_POST['lastname']);
        $email = $db->real_escape_string($_POST['email']);
        $password = $db->real_escape_string($_POST['password']);
        $password_repeat = $db->real_escape_string($_POST['password_repeat']);

        //Komen de wachtwoorden overeen?
        if($password!=$password_repeat)return false;    //TODO: Een bericht laten weergeven dat de wachtwoorden niet overeenkomen

        //Is het e-mail al eerder geregistreerd?
        $sql = "SELECT email
                FROM users
                WHERE email = '$email'";
        $result = $db->query($sql);
        if($result->num_rows)return false;      //TODO: Een bericht laten weergeven dat de email al bestaat

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

        return false;

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
        $sql = "SELECT *
                FROM users
                WHERE email = '$email'";
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
        return false;   //TODO: Een bericht laten weergeven dat het email of wachtwoord niet overeen komt

    }

    //Een functie voor inloggen
    private function setSessions($user){
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['firstname'] = $user['firstname'];
        $_SESSION['lastname'] = $user['lastname'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['type'] = $user['type'];
        return true;
    }

}