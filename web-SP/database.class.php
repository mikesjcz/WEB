<?php
include_once("settings.inc.php");

class Database {
    
    private $db; // PDO objekt databaze

         /**
          * konstruktor databaze
          **/
    public function __construct(){
        global $db_server, $db_name, $db_user, $db_pass;        
        // informace se berou ze settings
        $this->db = new PDO("mysql:host=$db_server;port=3307;dbname=$db_name", $db_user, $db_pass);
        session_start();
    }
    

    
    /**
     *  Provede dotaz a buď vrátí jeho výsledek, nebo null a vypíše chybu.
     *  @param string $dotaz    Dotaz.
     *  @return object          Vysledek dotazu.
     */
    private function executeQuery($dotaz){
        $res = $this->db->query($dotaz);
        if (!$res) {
            $error = $this->db->errorInfo();
            echo $error[2];
            return null;
        } else {
            return $res;            
        }
    }
    
    /**
     *  Prevede vysledny objekt dotazu na pole.
     *  @param object $obj  Objekt s vysledky dotazu.
     *  @return array       Pole s vysledky dotazu.
     */
    private function resultObjectToArray($obj){         
        return $obj->fetchAll();      
    }
    
    /**
     *  Vraci prava uzivatelu.
     *  @return array   Dostupna prava uzivatelu.
     */
    public function allRights(){
        $q = "SELECT * FROM tab_prava;";
        $res = $this->executeQuery($q);
        $res = $this->resultObjectToArray($res);
        return array_reverse($res); // pole otocim            
    }
    
     /**
     *  Vraci licence uzivatelu.
     *  @return array   Dostupne lucence uzivatelu.
     */
    
    public function allLicences(){
        $q = "SELECT * FROM tab_licence;";
        $res = $this->executeQuery($q);
        $res = $this->resultObjectToArray($res);
        return array_reverse($res); // pole otocim            
    }
    
     /**
     *  Vraci znamky.
     *  @return array   Dostupne znamky.
     */
    
    
    public function allZnamky(){
        $q = "SELECT * FROM tab_znamky;";
        $res = $this->executeQuery($q);
        $res = $this->resultObjectToArray($res);
        return array_reverse($res); // pole otocim            
    }
    
     /**
     *  Vraci clanky.
     *  @return array   Dostupne clanky.
     */
    
     public function allClanky(){
        $q = "SELECT * FROM tab_clanky;";
        $res = $this->executeQuery($q);
        $res = $this->resultObjectToArray($res);
        return array_reverse($res); // pole otocim            
    }
    
     /**
     *  Vraci hodnoceni.
     *  @return array   Dostupne hodnoceni.
     */
    
    public function allHodnoceni($idclanek){
        $q = "SELECT * FROM tab_hodnoceni WHERE idclanek=$idclanek;";
        $res = $this->executeQuery($q);
        $res = $this->resultObjectToArray($res);
        return array_reverse($res); // pole otocim            
    }
    
    /**
     *  Vraci vsechny informace o uzivateli.
     *  @param string $login    Login uzivatele.
     *  @return array           Pole s informacemi o konkretnim uzivateli nebo null.
     */
    public function allUserInfo($login){
        $q = "SELECT * FROM tab_uzivatele, tab_prava      
                WHERE tab_uzivatele.login = '$login'
                  AND tab_prava.idprava = tab_uzivatele.idprava;";
        $res = $this->executeQuery($q);
        $res = $this->resultObjectToArray($res);
        //print_r($res);
        if($res != null && count($res)>0){
            // vracim pouze prvni radek, ve kterem je uzivatel
            return $res[0];
        } else {
            return null;
        }
    }
    
    /**
     *  Vraci vsechny informace o vsech uzivatelich.
     *  @return array           Pole s informacemi o konkretnim uzivateli nebo null.
     */
    public function allUsersInfo(){
        $q = "SELECT * FROM tab_uzivatele, tab_prava
                WHERE tab_prava.idprava = tab_uzivatele.idprava;";
        $res = $this->executeQuery($q);
        $res = $this->resultObjectToArray($res);
        //print_r($res);
        if($res != null && count($res)>0){
            // vracim vse
            return $res;
        } else {
            return null;
        }
    }
    
    /**
     *  Overi, zda dany uzivatel ma dane heslo.
     *  @param string $login  Login uzivatele.
     *  @param string $pass     Heslo uzivatele.
     *  @return boolean         Jsou hesla stejna?
     */
    public function isPasswordCorrect($login, $pass){
        $usr = $this->allUserInfo($login);
        if($usr==null){ // uzivatel neni v DB
            return false;
        }
        return $usr["heslo"]==$pass; // je heslo stejne?
    }
    
    /**
     *  Overi heslo uzivatele a pokud je spravne, tak uzivatele prihlasi.
     *  @param string $login    Login uzivatele.
     *  @param string $pass     Heslo uzivatele.
     *  @return boolean         Podarilo se prihlasit.
     */
    public function userLogin($login, $pass){
        if(!$this->isPasswordCorrect($login,$pass)){// neni heslo spatne?
            return false; // spatne heslo
        }
        // ulozim uzivatele do session
        $_SESSION["user"] = $this->allUserInfo($login);
        return true;
    }
    
    /**
     *  Odhlasi uzivatele.
     */
    public function userLogout(){
        // odstranim session
        session_unset($_SESSION["user"]);
    }
    
    /**
     *  Je uzivatel prihlasen?
     */
    public function isUserLoged(){
        return isset($_SESSION["user"]);
    }
    
    /**
     *  Vytvori v databazi noveho uzivatele.s
     *  @return boolean         Podarilo se uzivatele vytvorit
     */
    public function addNewUser($login,$jmeno, $heslo, $email, $idLicence, $adresa, $mesto, $idPrava){
        $q = "INSERT INTO tab_uzivatele(login,jmeno,heslo,email,idlicence, adresa, mesto, idprava)
                VALUES ('$login','$jmeno','$heslo','$email','$idLicence','$adresa','$mesto','$idPrava')";
        $res = $this->executeQuery($q);
        if($res == null){
            return false;
        } else {
            return true;
        }
    }
    
    /**
     *  Vytvori v databazi noveho uzivatele.s
     *  @return boolean         Podarilo se uzivatele vytvorit
     */
    public function addNewHodnoceni( $idclanek, $iduzivatele, $originalita, $tema, $techkvalita, $jazykkvalita, $doporuceni, $poznamky ){
        $q = "INSERT INTO tab_hodnoceni(idclanek, iduzivatele, originalita, tema, techkvalita, jazykkvalita, doporuceni, poznamky)
                VALUES ('$idclanek','$iduzivatele','$originalita','$tema','$techkvalita','$jazykkvalita','$doporuceni', '$poznamky')";
        $res = $this->executeQuery($q);
        if($res == null){
            return false;
        } else {
            return true;
        }
    }
    
    /**
     *  Upravi informace o danem uzivateli.
     *  ... vse potrebne ...
     *  @return boolean         Podarilo se data upravit?
     */
    public function updateUserInfo($userId, $jmeno, $heslo, $email, $idLicence, $adresa, $mesto, $idPrava){
        $q = "UPDATE tab_uzivatele
                SET jmeno='$jmeno', heslo='$heslo', email='$email', idlicence='$idLicence', adresa='$adresa', mesto='$mesto', idprava=$idPrava 
                WHERE iduzivatel=$userId";
        $res = $this->executeQuery($q);
        if($res == null){
            return false;
        } else {
            return true;
        }
    }
    
    /**
     *  Smaze daneho uzivatele z databaze.
     *  @param integer $userId  ID uzivatele.
     *  @return boolean         Podarilo se?
     */
    public function deleteUser($userId){
        $q = "DELETE FROM tab_uzivatele
                WHERE iduzivatel=$userId";
        $res = $this->executeQuery($q);
        if($res == null){
            return false;
        } else {
            return true;
        }
    }
    
     /**
     *  Vytvoreni v databazi noveho clanku.
     *
     *  @return boolean         Podarilo se clanek vytvorit
     */
    public function addNewClanek($nazev, $autori, $clanek, $pdf){
        $q = "INSERT INTO tab_clanky(nazev, autori, clanek, pdf)
                VALUES ('$nazev','$autori','$clanek','$pdf')";
        $res = $this->executeQuery($q);
        if($res == null){
            return false;
        } else {
            return true;
        }
    }
    
    /**
     *  Vraci informace o clancích.
     *  @return array           Pole s informacemi o konkretnim clanku nebo null.
     */
    public function allClankyInfo(){
        $q = "SELECT * FROM tab_clanky";
               
        $res = $this->executeQuery($q);
        $res = $this->resultObjectToArray($res);
        //print_r($res);
        if($res != null && count($res)>0){
            // vracim vse
            return $res;
        } else {
            return null;
        }
    }
    
     /**
     *  Smaze dany clanek z databaze.
     *  @param integer $clanekId  ID clanku.
     *  @return boolean         Podarilo se?
     */
    public function deleteClanek($clanekId){
        $q = "DELETE FROM tab_clanky
                WHERE idclanek=$clanekId";
        $res = $this->executeQuery($q);
        if($res == null){
            return false;
        } else {
            return true;
        }
    }

        /**
     *  schvali dany clanek.
     *  @param integer $clanekID  ID clanku.
     *  @return boolean         Podarilo se?
     */
    public function schvalClanek($clanekId){
        $q = "UPDATE tab_clanky SET schvaleno=1 WHERE idclanek=$clanekId";
        $res = $this->executeQuery($q);
        if($res == null){
            return false;
        } else {
            return true;
        }
    }

   
    
}



?>