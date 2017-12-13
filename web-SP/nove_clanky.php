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
    head("KHR - správa článků");
?>

<?php
    // nepřihlášený uživatel       
    if(!$PDOObj->isUserLoged()){      
?>
        <center>
        <b>K navštívení obsahu této stránky je nutné se nejdříve <a href="index.php?page=0">přihlásit</a>.</b>
        </center>
<?php

    // přihlášený užovatel
    } else { 

        // uživarel není administrátor ani školitel
        if($_SESSION["user"]["idprava"]>2){
               
?>
        <center><b>Pro správu článků je třeba být školitel nebo administrátor.</b><center>
<?php
        
        // uživatel je školitel
        } else if($_SESSION["user"]["idprava"]==2){
          
          
            if(isset($_POST["hodnoceni"]) && isset($_POST["clanek-id"])){
                // zadost o smazani uzivatele
                if($_POST["clanek-id"]!=""){
                   
                    $_SESSION["clanek"] = $_POST["clanek-id"];
                    
                    header("Location: hodnoceni"); 
                   
                } else {
                    echo "<b>Neznámé ID článku. Hodnocení není možné!</b><br><br>";
                }
            }   
?>

        <center>
            <b>Správu uživatelů mohou provádět pouze uživatelé s právem Administrátor.</b>
            <br><br>
            Hodnocení článků:<br>
          
            <table border="1">
                <tr>
                    <th>&nbspNÁZEV&nbsp</th>
                   <th>&nbspAUTOŘI&nbsp</th>
                   <th>&nbspPDF&nbsp</th>
                    <th>&nbspAKCE&nbsp</th>
<?php  
                
                // zobrazení článků    
                $clanky = $PDOObj->allClankyInfo();
                    foreach($clanky as $u){
                        echo "<tr>
                                <td>&nbsp$u[nazev]&nbsp</td>
                                <td>&nbsp$u[autori]&nbsp</td>
                                <td>&nbsp<a href='soubory/$u[pdf]'>$u[pdf]</a>&nbsp</td>
                                <td>
                                    <form action='' method='POST'>
                                        <input type='hidden' name='clanek-id' value='$u[idclanek]'>
                                        <input type='submit' name='hodnoceni' value='Hodnocení'>
                                    </form>
                                </td>
                              </tr>";
                      }
?>            
            </table>  
        </center>
        
<?php
        
        // uživatel je administrátor      
        } else{ // neni navstevnik
                         
            // zpracovani odeslanych formularu
            if(isset($_POST["potvrzeni"]) && isset($_POST["clanek-id"])){
                // zadost o smazani uzivatele
                if($_POST["clanek-id"]!=""){
                    $res = $PDOObj->deleteClanek($_POST["clanek-id"]);
                    if($res){
                        echo "<center><b>Článek s ID:".$_POST["clanek-id"]." byl smazán.</b></center><br><br>";
                    } else {
                        echo "<center><b>Článek s ID:".$_POST["clanek-id"]." se nepodařilo smazat!</b></center><br><br>";
                    }
                } else {
                    echo "<b>Neznámé ID článku. Mazání nebylo provedeno!</b><br><br>";
                }
            }
            
            if(isset($_POST["schvaleni"]) && isset($_POST["clanek-id"])){
                // zadost o schvaleni clanku
                if($_POST["clanek-id"]!=""){
                    $res = $PDOObj->schvalClanek($_POST["clanek-id"]);
                    if($res){
                        echo "<center><b>Článek s ID:".$_POST["clanek-id"]." byl schválen.</b></center><br><br>";
                    } else {
                        echo "<center><b>Článek s ID:".$_POST["clanek-id"]." se nepodařilo chválit!</b></center><br><br>";
                    }
                } else {
                    echo "<b>Neznámé ID článku. Schválení nebylo provedeno!</b><br><br>";
                }
            }

?>
        <center>
            <b>Seznam článků:</b>
        
            <table border="1">
                <tr>
                    <th>&nbspNÁZEV&nbsp</th>
                    <th>&nbspAUTOŘI&nbsp</th>
                    <th>&nbspPDF&nbsp</th>
                    <th>&nbspHODNOCENI&nbsp</th>
                    <th>&nbspSTAV&nbsp</th>
                    <th>&nbspAKCE&nbsp</th>
<?php  
                // zobrazení článků        
                $clanky = $PDOObj->allClankyInfo();
                      foreach($clanky as $u){
                        echo "<tr>
                                <td>&nbsp$u[nazev]&nbsp</td>
                                <td>&nbsp$u[autori]&nbsp</td>
                                <td>&nbsp<a href='soubory/$u[pdf]'>$u[pdf]</a>&nbsp</td>
                                <td>
                                    <table border='0'>
                                ";
                        
                        $hodnoceni =  $PDOObj->allHodnoceni($u["idclanek"]);
                        
                        foreach($hodnoceni as $h){
                            $prumer = ($h["originalita"]+$h["tema"]+$h["techkvalita"]+$h["jazykkvalita"] +$h["doporuceni"] )/5;
                            echo "<tr>
                                      <td>&nbspHodnotil:&nbsp$h[iduzivatele]&nbsp</td>
                                      <td>&nbspHodnocení:&nbsp$h[originalita]&nbsp</td>
                                      <td>&nbsp$h[tema]&nbsp</td>
                                      <td>&nbsp$h[techkvalita]&nbsp</td>
                                      <td>&nbsp$h[jazykkvalita]&nbsp</td>
                                      <td>&nbsp$h[doporuceni]&nbsp</td>
                                      <td>&nbspPrůměr:&nbsp$prumer&nbsp</td>
                                      <td>&nbspPoznámka:&nbsp$h[poznamky]&nbsp</td>
                                      
                                  </tr>
                                  ";
                        
                        }
                        echo "      </table>
                                </td>
                                <td>&nbsp";
                        if($u["schvaleno"]==0){
                            echo "neschvaleno";
                        }
                        else{
                            echo "schvaleno";
                        }         
                                
                        echo        "&nbsp</td>
                                <td>
                                    <form action='' method='POST'>
                                        <input type='hidden' name='clanek-id' value='$u[idclanek]'>
                                        <input type='submit' name='potvrzeni' value='Smazat'>";
                                        
                                        
                        if($u["schvaleno"]==0){
                            echo "<input type='submit' name='schvaleni' value='Schválit'>";
                        }
                        echo            "            </form>
                                </td>
                              </tr>";
                        }
?>            
           </table>  
        </center>
                
<?php             
        }
    }

    // paticka
    foot();
?>
             