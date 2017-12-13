<?php 
    // načtení souboru s funkcemi 
    include("database.class.php");
    $PDOObj = new Database();
?>

<?php 
    // načtení hlavičky stránky
    if(!$PDOObj->isUserLoged()){    
        include("zaklad.php");
    }else{
        include("zakladP.php");
    }
    
    // jméno stránky
    head("KHR - uživatel");
?>

<?php
   
    // odhlášení uživatele
    if(isset($_REQUEST["action"]) && $_REQUEST["action"]=="logout"){
        $PDOObj->userLogout();
        header("Location: prihlaseni");
    }
    
    // přihlášení uživatele
    if(isset($_REQUEST["action"]) && $_REQUEST["action"]=="login"){
        $res = $PDOObj->userLogin($_REQUEST["login"],$_REQUEST["heslo"]);    
        if(!$res){
             echo "<b>Přihlášení se nezdařilo!<b><br><br>";
        }else{
            header("Location: prihlaseni");
        }
    }
    
    // nepřihlášený uživatel
    if(!$PDOObj->isUserLoged()){
        
?>       
        <center>
            <b>Přihlášení uživatele:<br><br></b>
                
            <form action="" method="POST">
            
            <table>
                <tr>
                    <td>Login:</td>
                    <td><input type="text" name="login"></td>
                </tr>
                <tr>
                    <td>&nbsp</td>
                    <td>&nbsp</td>
                </tr>
                <tr>
                    <td>Heslo:</td>
                    <td><input type="password" name="heslo"></td>
                </tr>
            </table>
            
            <input type="hidden" name="action" value="login">
            <br>
            
            <input type="submit" name="potvrzeni" value="Přihlásit">
            
            </form>
        </center>
<?php
    // přihlášený uživatel
    } else {              
?>             

        <center>
            <b>Přihlášený uživatel:</b>
            <br><br>
       
<?php 
            echo "<b>Jméno: </b>".$_SESSION["user"]["jmeno"]."<br>
                  <b>Login: </b>".$_SESSION["user"]["login"]."<br>
                  <b>Licence: </b>".$_SESSION["user"]["idlicence"]."<br><br>            
                  <b>E-mail: </b>".$_SESSION["user"]["email"]."<br><br>
                  <b>Adresa: </b>".$_SESSION["user"]["adresa"].", ".$_SESSION["user"]["mesto"]."<br><br>
                  <b>Právo: </b>".$_SESSION["user"]["nazev"]."<br>";
?>
            <br><br>
        
            Odhlášení uživatele:
            <form action="" method="POST">
                <input type="hidden" name="action" value="logout">
                <input type="submit" name="potvrzeni" value="Odhlásit">
            </form>
        </center>      
        
<?php               
    }

    // patička
    foot();
?>           