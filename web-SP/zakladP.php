 <?php 
// zaklad stránky

/**
 *
 *
 *
 *  Vytvoreni hlavicky stranky.
 *  @param string $title Nazev stranky.
 */
function head($title=""){    
?>
<!doctype>
<html lang="cs">
    <head>
    <!-- nastaveni bootstrapu  -->
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="icon" href="images/icon/icon_300x300.png">
        <title><?php echo $title; ?></title>
        <style>
            body { background-color: orange; }
            nav { background-color: darkblue; margin-bottom: 10px; padding: 5px; color:lightgray;}
            nav a { color: aliceblue; padding: 5px;}
        </style>    
    </head>
    <body>
        
        <center>
            <h1>Konference<br><h2>hokejových rozhodčích</h2></h1>
        </center>  
              <!-- nastaveni ovladaci lišty  -->
        <nav class="navbar navbar-inverse">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="konference">Domů</a>
            </div>
                       <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="novinky">Novinky</a></li>
                    <li><a href="skoleni">Školení</a></li>
                    <li><a href="pravidla">Pravidla</a></li>
                    <li><a href="odkazy">Odkazy</a></li>
                    <li><a href="kontakt">Kontakt</a></li>
                                                                      
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href= "nove_clanky"><span class="glyphicon glyphicon-text-background"></span> Správa článků</a></li>
                   <li><a href= "sprava_uctu"><span class="glyphicon glyphicon-wrench"></span> Správa uživatelů</a></li>
                    <li><a href= "nastaveni"><span class="glyphicon glyphicon-cog"></span> Osobní údaje</a></li>
                    <li><a href="prihlaseni"><span class="glyphicon glyphicon-log-in"></span> Odhlásit</a></li>
                </ul>
            </div>
        </nav>
        
        <div>
         
<?php 
}

/**
 *  Vytvoreni paticky.
 */
function foot(){
?>                
        </div>
    </body>
</html>


<?php
    
}


/**
 *  Vytvori selectbox s pravi uzivatelu.
 *  @param array $rights    Vsechna dostupna prava.
 *  @param integer $selected    Zvolena polozka nebo null.
 *  @return string          Vytvoreny selectbox.
 */
function createSelectBox($rights,$selected){
    $res = '<select name="pravo">';
    foreach($rights as $r){
        if($selected!=null && $selected==$r['idprava']){ // toto bylo ve stupu
            $res .= "<option value='".$r['idprava']."' selected>$r[nazev]</option>";    
        } else { // nemam vstup
            $res .= "<option value='".$r['idprava']."'>$r[nazev]</option>";    
        }        
    }
    $res .= "</select>";
    return $res;
}

/**
 *  Vytvori selectbox s licencemi.
 *  @param array $rights    Vsechny dostupne licence.
 *  @param integer $selected    Zvolena polozka nebo null.
 *  @return string          Vytvoreny selectbox.
 */
function createSelectBoxL($rights,$selected){
    $res = '<select name="licence">';
    foreach($rights as $r){
        if($selected!=null && $selected==$r['idlicence']){ // toto bylo ve stupu
            $res .= "<option value='".$r['idlicence']."' selected>$r[nazevL]</option>";    
        } else { // nemam vstup
            $res .= "<option value='".$r['idlicence']."'>$r[nazevL]</option>";    
        }        
    }
    $res .= "</select>";
    return $res;
}


function createSelectBoxZO($rights,$selected){
    $res = '<select name="znamkaO">';
    foreach($rights as $r){
        if($selected!=null && $selected==$r['idznamky']){ // toto bylo ve stupu
            $res .= "<option value='".$r['idznamky']."' selected>$r[1]</option>";    
        } else { // nemam vstup
            $res .= "<option value='".$r['idznamky']."'>$r[1]</option>";    
        }        
    }
    $res .= "</select>";
    return $res;
}

function createSelectBoxZT($rights,$selected){
    $res = '<select name="znamkaT">';
    foreach($rights as $r){
        if($selected!=null && $selected==$r['idznamky']){ // toto bylo ve stupu
            $res .= "<option value='".$r['idznamky']."' selected>$r[1]</option>";    
        } else { // nemam vstup
            $res .= "<option value='".$r['idznamky']."'>$r[1]</option>";    
        }        
    }
    $res .= "</select>";
    return $res;
}

function createSelectBoxZTK($rights,$selected){
    $res = '<select name="znamkaTK">';
    foreach($rights as $r){
        if($selected!=null && $selected==$r['idznamky']){ // toto bylo ve stupu
            $res .= "<option value='".$r['idznamky']."' selected>$r[1]</option>";    
        } else { // nemam vstup
            $res .= "<option value='".$r['idznamky']."'>$r[1]</option>";    
        }        
    }
    $res .= "</select>";
    return $res;
}

function createSelectBoxZJK($rights,$selected){
    $res = '<select name="znamkaJK">';
    foreach($rights as $r){
        if($selected!=null && $selected==$r['idznamky']){ // toto bylo ve stupu
            $res .= "<option value='".$r['idznamky']."' selected>$r[1]</option>";    
        } else { // nemam vstup
            $res .= "<option value='".$r['idznamky']."'>$r[1]</option>";    
        }        
    }
    $res .= "</select>";
    return $res;
}

function createSelectBoxZD($rights,$selected){
    $res = '<select name="znamkaD">';
    foreach($rights as $r){
        if($selected!=null && $selected==$r['idznamky']){ // toto bylo ve stupu
            $res .= "<option value='".$r['idznamky']."' selected>$r[1]</option>";    
        } else { // nemam vstup
            $res .= "<option value='".$r['idznamky']."'>$r[1]</option>";    
        }        
    }
    $res .= "</select>";
    return $res;
}
?>