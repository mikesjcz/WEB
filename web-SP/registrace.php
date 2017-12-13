<?php 
    // načtení souboru s funkcemi 
    include("database.class.php");
    $PDOObj = new Database();

    // načtení hlavičky stránky
    if(!$PDOObj->isUserLoged()){
        include("zaklad.php");
    }else{
        include("zakladP.php");
    }
    
    //  jméno stránky
    head("KHR - registrace");

    // zaregistrování hráče
    if(isset($_POST['potvrzeni'])){
        if($_POST["heslo"]==$_POST["heslo2"]){
            if($PDOObj->allUserInfo($_POST["login"])!=null){
                // CHYBA špatný login
                echo "<b>Tento login už existuje. Zvolte si prosím jiný.</b><br><br>";
            } else {
                $PDOObj->addNewUser($_POST["login"], $_POST["jmeno"], $_POST["heslo"], $_POST["email"], $_POST["licence"], $_POST["adresa"], $_POST["mesto"], $_POST["pravo"]);    
                $PDOObj->userLogin($_POST["login"],$_POST["heslo"]);
            }
        } else {
            // CHYBA špatné heslo
            echo "<b>Hesla nejsou stejná!</b><br><br>";
        }
        
    }
    
    // nepřihlášený uživatel
    if(!$PDOObj->isUserLoged()){   
?>

        <center>
            <b>Registrační formulář</b>
            
            <form action="" method="POST" oninput="x.value=(pas1.value==pas2.value)?'OK':'Nestejná hesla'">
            
            <table>
                <tr>
                    <td>Login:</td>
                    <td><input type="text" name="login" value="<?php echo @$_POST["login"]; ?>" required></td>
                </tr>
                <tr>
                    <td>Heslo 1:</td>
                    <td><input type="password" name="heslo" id="pas1" required></td>
                </tr>
                <tr>
                    <td>Heslo 2:</td>
                    <td><input type="password" name="heslo2" id="pas2" required></td>
                </tr>
                <tr>
                    <td>Ověření hesla:</td>
                    <td><output name="x" for="pas1 pas2"></output></td>
                </tr>
                <tr>
                    <td>Jméno:</td>
                    <td><input type="text" name="jmeno" value="<?php echo @$_POST["jmeno"]; ?>" required></td>
                </tr>
                <tr>
                    <td>E-mail:</td>
                    <td><input type="email" name="email" value="<?php echo @$_POST["email"]; ?>" required></td>
                </tr>
                <tr>
                    <td>Licence:</td>
                    <td><?php echo createSelectBoxL($PDOObj->allLicences(),null); ?></td>
                </tr>                      
                <tr>
                    <td>Adresa:</td>
                    <td><input type="text" name="adresa" value="<?php echo @$_POST["adresa"]; ?>" required></td>
                </tr>
                <tr>
                    <td>Město:</td>
                    <td><input type="text" name="mesto" value="<?php echo @$_POST["mesto"]; ?>" required></td>
                </tr>
                <tr>
                    <td>Právo:</td>
                    <td><?php echo createSelectBox($PDOObj->allRights(),null); ?></td>
                </tr>
            </table>
            
            <br>
            <input type="submit" name="potvrzeni" value="Registrovat">
            
            </form>
        </center>
<?php

    // přihlášený uživatel
    } else {
    
    // přesměrování na informace o uživateli
    header("Location: prihlaseni");  
            
?>              <center>
        <b>Přihlášený uživatel se nemůže znovu registrovat.</b>
                </center>
<?php             
    }

    foot();
?>
             