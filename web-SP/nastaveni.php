<?php 
    // načtení souboru s funkcemi 
    include("database.class.php");
    $PDOObj = new Database();
?>

<?php 
    // nacteni hlavičky stránky
    if(!$PDOObj->isUserLoged()){
        include("zaklad.php");
    }else{
        include("zakladP.php");
    }
    
    // jméno stránky
    head("KHR - osobní údaje");
?>

<?php
   // odeslání změněných údajů
    if(isset($_POST['potvrzeni'])){
        // je správné aktuální heslo?
        if($PDOObj->isPasswordCorrect($_SESSION["user"]["login"], $_POST["heslo-puvodni"])){
            // jsou zadaná stejná hesla?
            if($_POST["heslo"]==$_POST["heslo2"]){
                if($_POST["heslo"]==""){
                    // když ne tak nech původní
                    $heslo = $_SESSION["user"]["heslo"];
                } else { 
                    // když ano tak nastav nové heslo
                    $heslo = $_POST["heslo"]; 
                }
                // změn údaje o uživately
                $PDOObj->updateUserInfo($_SESSION["user"]["iduzivatel"], $_POST["jmeno"], $heslo, $_POST["email"], $_POST["licence"], $_POST["adresa"] , $_POST["mesto"] , $_POST["pravo"]);                                                
                // přihlaš se pod novými údaji
                $PDOObj->userLogin($_SESSION["user"]["login"],$heslo); 
                
                // HOTOVO vpořádku změněno   
                echo "<center><b>Osobní údaje byly změněny.</b><center><br><br>";
            } else {
                //  CHYBA hesla nejsou stejná
               echo '<center> <font color="#FF0000"><b>Vámi zadaná hesla nejsou stejná!</b></font></center><br><br>';
            }            
        } else {
            // CHYBA spatně zadané současnéheslo
            echo '<center> <font color="#FF0000"><b>Vámi zadané současné heslo není správné!</b></font></center><br><br>';
        }
    }
    
    // nepřihlášený uživatel    
    if(!$PDOObj->isUserLoged()){
   
?>
        K navštívení obsahu této stránky je nutné se nejdříve <a href="prihlaseni">přihlásit</a>. 

<?php
    // přihlášený uživatel
    } else { 
             
?>      
        <center>
            <b>Osobní údaje</b><br>
            
            <form action="" method="POST" oninput="x.value=(pas1.value==pas2.value)?'OK':'Nestejná hesla'">
                              <br>
            <!-- tabulka pro změnu údajů -->                         
            <table>
                <tr>
                    <td>Login:</td><td><?php echo $_SESSION["user"]["login"]; ?></td>
                </tr>
                <tr>
                    <td>Současné heslo:</td><td><input type="password" name="heslo-puvodni" required></td>
                </tr>
                <tr>
                    <td>Heslo 1:</td><td><input type="password" name="heslo" id="pas1"></td>
                </tr>
                <tr>
                    <td>Heslo 2:</td><td><input type="password" name="heslo2" id="pas2"></td>
                </tr>
                <tr>
                    <td>Licence:</td>
                    <td><?php echo createSelectBoxL($PDOObj->allLicences(),$_SESSION["user"]["idlicence"]); ?></td>
                </tr>
                <tr>
                    <td>Ověření hesla:</td><td><output name="x" for="pas1 pas2"></output></td></tr>
                <tr>
                    <td>Jméno:</td><td><input type="text" name="jmeno" value="<?php echo $_SESSION["user"]["jmeno"]; ?>" required></td>
                </tr>
                <tr>
                    <td>E-mail:</td><td><input type="email" name="email" value="<?php echo $_SESSION["user"]["email"]; ?>" required></td>
                </tr>
                <tr>
                    <td>Adresa:</td><td><input type="text" name="adresa" value="<?php echo $_SESSION["user"]["adresa"]; ?>" required></td>
                </tr>
                <tr>
                    <td>Město:</td><td><input type="text" name="mesto" value="<?php echo $_SESSION["user"]["mesto"]; ?>" required></td>
                </tr>
                <tr>
                    <td>Právo:</td>
                    <td><?php echo createSelectBox($PDOObj->allRights(),$_SESSION["user"]["idprava"]); ?></td>
                </tr>
            </table>
            
            <input type="submit" name="potvrzeni" value="Upravit osobní údaje">
            
            </form>
        </center>
<?php
              
    }
?>

<?php
    // patička
    foot();
?>
             