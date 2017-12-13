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
    head("KHR - správa uživatelů");
?>

<?php
    // nepřihlášený uživatel       
    if(!$PDOObj->isUserLoged()){    
?>

        <center>
            <b>K navštívení obsahu této stránky je nutné se nejdříve <a href="prihlaseni">přihlásit</a>.</b>
        </center>
        
<?php
    // nepřihlášený uživatel
    } else {
    
        // uživatel není admin
        if($_SESSION["user"]["idprava"]!=1){               
?>

        <center>
            <b>Správu uživatelů mohou provádět pouze uživatelé s právem Administrátor.</b>
        </center>
        
<?php
        // uživatel je admin                
        } else {
              
            // smazání uživatele                     
            if(isset($_POST["potvrzeni"]) && isset($_POST["user-id"])){
                if($_POST["user-id"]!=""){
                    $res = $PDOObj->deleteUser($_POST["user-id"]);
                    if($res){
                        echo "<center><b>Uživatel s ID:".$_POST["user-id"]." byl smazán.</b></center><br><br>";
                    } else {
                        echo "<center><b>Uživatele s ID:".$_POST["user-id"]." se nepodařilo smazat!</b></center><br><br>";
                    }
                } else {
                    // CHYBA špatný užavetel ke smazání
                    echo "<b>Neznámé ID uživatele. Mazání nebylo provedeno!</b><br><br>";
                }
            }

?>         

        <center>
            <b>Seznam uživatelů:</b>
        
            <table border="1">
                <tr>
                    <th>&nbspID&nbsp</th>
                    <th>&nbspLogin&nbsp</th>
                    <th>&nbspJméno&nbsp</th>
                    <th>&nbspE-mail&nbsp</th>
                    <th>&nbspLicence&nbsp</th>
                    <th>&nbspAdresa&nbsp</th>
                    <th>&nbspPrávo&nbsp</th>
                    <th>&nbspAkce&nbsp</th>
                </tr>
                
<?php  
                // výpis uživatelů
                $users = $PDOObj->allUsersInfo();
                foreach($users as $u){
                    if($u["iduzivatel"]!=$_SESSION["user"]["iduzivatel"]){
                        echo "<tr>
                                  <td>&nbsp$u[iduzivatel]&nbsp</td>
                                  <td>&nbsp$u[login]&nbsp</td>
                                  <td>&nbsp$u[jmeno]&nbsp</td>
                                  <td>&nbsp$u[email]&nbsp</td>
                                  <td>&nbsp$u[idlicence]&nbsp</td>
                                  <td>&nbsp$u[adresa],&nbsp$u[mesto]&nbsp</td>
                                  <td>&nbsp$u[nazev]&nbsp</td>
                                  <td>
                                      <form action='' method='POST'>
                                          <input type='hidden' name='user-id' value='$u[iduzivatel]'>
                                          <input type='submit' name='potvrzeni' value='Smazat'>
                                      </form>
                                  </td>
                              </tr>";
                    }
                }
?>
            
            </table>  
        </center>      
<?php          
        }
    }
?>

<?php
    // patička
    foot();
?>
             