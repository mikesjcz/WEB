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
    
    // jméno stránky
    head("KHR - nový článek");
    
    
    

// zkontroluje zda je soubor skutečný nebo falešný
if(isset($_POST["ulozit"])) {
    
        $target_dir = "soubory/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $imageFileName= pathinfo($target_file,PATHINFO_BASENAME);
    
        if($imageFileType=="pdf"){
        
            if (!file_exists($target_file)) {
    
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    $PDOObj->addNewClanek($_POST["nazev"], $_POST["autori"], $_POST["clanek"], $imageFileName);
        
                    header("Location: novinky");  
                } else {
                    echo "CHYBA soubor nebylo možné odeslat.";
                }
            }else {
                echo "CHYBA soubor již existuje.";
            }
        }else{
            echo "CHYBA soubor není ve formátu pdf.";
        }
        
}

    
    
    // nepřihlášený uživatel
    if(!$PDOObj->isUserLoged()){ // neni prihlasen
    
?>       
        <center>
            <b>K navštívení obsahu této stránky je nutné se nejdříve <a href="index.php?page=0">přihlásit</a>. </b>  
        </center>
<?php
    //přihlášený uživatel
    } else {
        
        // uživatel je návštěvník
        if($_SESSION["user"]["idprava"]==4){
             
?>
        <center><b>Návštěvník není oprávněn přidávat články.</b></center>
<?php
        
        // uživatel není návštěvník     
        } else { 

?>  
        <center>
            <h2>Nový příspěvek</h2>
            
            
            <form action="" method="POST" oninput="x.value=(pas1.value==pas2.value)?'OK':'Nestejná hesla'" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>NÁZEV PŘÍSPĚVKU:</td>
                    <td><input type="text" name="nazev" value="<?php echo @$_POST["nazev"]; ?>" required></td>
                </tr>
                <tr>
                    <td>AUTOŘI:</td>
                    <td><input type="text" name="autori" value="<?php echo @$_POST["autori"]; ?>" required></td>
                </tr>
                <tr>
                    <td>ABSTRACT:</td>
                    <td><input type="text" name="clanek" value="<?php echo @$_POST["clanek"]; ?>" required></td></tr>
                <tr>
                    <td>PDF SOUBOR:</td>
                    <td>
                        <input type="file" name="fileToUpload" id="fileToUpload">
                    </td>
                </tr>
            </table> 
            <br>
            
            <input type="submit" value="Přidat příspěvek" name="ulozit">
            </form>
            
  
        </center>
        
<?php              
      }
    }
?>

<?php
    // patička
    foot();
?>
             