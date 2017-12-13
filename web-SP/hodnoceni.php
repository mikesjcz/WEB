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

    // pridani noveho hodnoceni
    if(isset($_POST['potvrzeni'])){
        
         $res = $PDOObj->addNewHodnoceni($_SESSION["clanek"], $_SESSION["user"]["iduzivatel"],$_POST["znamkaO"],$_POST["znamkaT"],$_POST["znamkaTK"],$_POST["znamkaJK"],$_POST["znamkaD"],$_POST["poznamky"]);
                    if($res){
                        echo "<center><b>Článek s ID:".$_SESSION["clanek"]." byl ohodnocen.</b></center><br><br>";
                    } else {
                        echo "<center><b>Článek s ID:".$_SESSION["clanek"]." se nepodařilo ohodnotit!</b></center><br><br>";
                    }
    }
    
    // přhlášený uživatel
    if($PDOObj->isUserLoged()){
    
        $nclanek = $_SESSION["clanek"];

        $clanek;
        $clanky = $PDOObj->allClanky();

                foreach($clanky as $u){
                    if($u["idclanek"]==$nclanek){
?>                    
                    
                            <center>
                            <b>Článek:</b>
                                                                                              
                            <table border="0">
                            <tr>
                                <td>Název:<td>
                                <td><?php echo $u["nazev"] ?><td>
                            </tr>
                            <tr>
                                <td>Autoři:<td>
                                <td><?php echo $u["autori"] ?><td>
                            </tr>
                            <tr>
                                <td>Abstract:<td>
                                <td><?php echo $u["clanek"] ?><td>
                            </tr>
                            <tr>
                                <td>Pdf:<td>
                                <td><?php echo $u["pdf"] ?><td>
                            </tr>
       
                        </table>  
                    </center>
<?php
                    break;
                    }
                }
                
?>



        <center>
            <br><br>
            <b>Formulář hodnocení.</b>
            
            <form action="" method="POST" oninput="x.value=(pas1.value==pas2.value)?'OK':'Nestejná hesla'">
            
            <table>
                <tr>
                    <td>Originalita:</td>
                    <td><?php echo createSelectBoxZO($PDOObj->allZnamky(),null); ?></td>
                   
                   </tr><tr> 
                    <td>Téma:</td>
                    <td><?php echo createSelectBoxZT($PDOObj->allZnamky(),null); ?></td>
                
                </tr>
                
                <tr> 
                    <td>Technická kvalita:</td>
                    <td><?php echo createSelectBoxZTK($PDOObj->allZnamky(),null); ?></td>
                
                </tr>
                
                <tr> 
                    <td>Jazyková kvalita:</td>
                    <td><?php echo createSelectBoxZJK($PDOObj->allZnamky(),null); ?></td>
                
                </tr>
                
                <tr> 
                    <td>Doporučení:</td>
                    <td><?php echo createSelectBoxZD($PDOObj->allZnamky(),null); ?></td>
                </tr>
                 <tr>
                    <td>Poznámky:</td>
                    <td><input type="text" name="poznamky" value="<?php echo @$_POST["poznamky"]; ?>"></td>
                </tr>
                
            </table>
            
            <br>
            <input type="submit" name="potvrzeni" value="Ohodnotit">
            
            </form>
        </center>
<?php

    // nepřihlášený uživatel
    } else {

            
?>              <center>
        <b>Přihlášený uživatel se nemůže znovu registrovat.</b>
                </center>
<?php             
    }



    foot();
?>
             