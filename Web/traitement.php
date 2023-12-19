<?php session_start();
    require "./include/function.inc.php";
    require_once "./classe/Abonne.php";
    
    //Inscription sur le site web
    if((isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['phone']) && isset($_POST['birthdate']) && isset($_POST['email']) && isset($_POST['sexe']) && isset( $_POST['password']) && isset( $_POST['passwordconf'])) && 
      (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['phone']) && !empty($_POST['birthdate']) && !empty($_POST['email']) && !empty($_POST['sexe']) && !empty( $_POST['password']) && !empty( $_POST['passwordconf']))){
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $birthdate = $_POST['birthdate'];
        $sexe = $_POST['sexe'];
        $passwordX = $_POST['password'];
        $passwordY = $_POST['passwordconf'];

        if(!same($passwordX, $passwordY)){ 
            header("Location:inscription.php?pw=false");
            session_destroy();
            exit;
        }
        include "database.php";
        global $connexion;
        $id_user = get_id_user();
        $id_adresse = null;

        if(!empty($_POST['no_bat']) && !empty($_POST['no_rue']) && !empty($_POST['ville']) && !empty($_POST['code_postal'])){
            $no_bat = (int)$_POST['no_bat'];
            $ville = $_POST['ville'];
            $code_postal = $_POST['code_postal'];
            $rue = $_POST['no_rue'];
            $id_adresse = get_id_adresse();
            $conn_string = getDBparams();
            $pdo = new PDO($conn_string);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();
            $query = "INSERT INTO adresse (id_adresse, no_bat, ville,code_postal, nom_rue) VALUES (:id_adresse, :no_bat, :ville, :code_postal , :rue)";
            $stmpInsert= $pdo->prepare($query);
            $stmpInsert->bindParam(":id_adresse", $id_adresse);
            $stmpInsert->bindParam(":no_bat", $no_bat);
            $stmpInsert->bindParam(":ville", $ville);
            $stmpInsert->bindParam(":code_postal", $code_postal);
            $stmpInsert->bindParam(":rue", $rue);
            $stmpInsert->execute();
            $pdo->commit();
            $pdo = null;

        }
         
       

        if(!is_mail_in_database($email) && !is_phone_in_database($phone)) {
            $conn_string = getDBparams();
            $pdo = new PDO($conn_string);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();
            $query = "INSERT INTO utilisateur (id_user, nom, prenom, num_telephone) VALUES (:id_user, :mail, :prenom, :phone)";
            $stmpInsert= $pdo->prepare($query);
            $stmpInsert->bindParam(":id_user", $id_user);
            $stmpInsert->bindParam(":mail", $email);
            $stmpInsert->bindParam(":prenom", $prenom);
            $stmpInsert->bindParam(":phone", $phone);
            $stmpInsert->execute();
            $pdo->commit();
            $pdo = null;

            $pdo = new PDO($conn_string);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();
            $query = "INSERT INTO abonne (id_user, mail, date_naissance, password, sexe, id_adresse) VALUES (:id_user, :email, :birthdate, :passwordX, :sexe, :id_adresse)";
            $stmpInsert= $pdo->prepare($query);
            $stmpInsert->bindParam(":id_user", $id_user);
            $stmpInsert->bindParam(":email", $email);
            $stmpInsert->bindParam(":birthdate", $birthdate);
            $stmpInsert->bindParam(":passwordX", $passwordX);
            $stmpInsert->bindParam(":sexe", $sexe);
            $stmpInsert->bindParam(":id_adresse", $id_adresse);
            $stmpInsert->execute();
            $pdo->commit();
            $pdo = null;

            $data = $passwordX.'/'.$id_user;
            $_SESSION["donnees"] = $data;
            //header("Location:connect.php");
        }else{
            if(is_mail_in_database($email) && !is_phone_in_database($phone)) echo "Mail deja utilisé";
            if(is_phone_in_database($phone) && !is_mail_in_database($email)) echo "Numero de telephone déja utilisé";
            if(is_phone_in_database($phone) && is_mail_in_database($email)) echo "Mail et numero de telephone deja utilisés";    
        }

    }


    //Realisation d'une reservation d'un abonné
    if(isset($_SESSION["id"]) && !empty($_SESSION["id"]) && isset($_GET['cap']) && isset($_GET['table']) && isset($_GET['time'])) {
        $id_table = $_GET['table'];
        $time = $_GET['time'];
        $id_reserv = get_id_reserv();
        $abonne = unserialize($_SESSION["abonne"]);
        $id_user = $abonne->getIdUser();
        $pdo = new PDO($conn_string);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        $query = "INSERT INTO reservation (id_table, id_user, id_reserv, heure) VALUES (:id_table, :id_user, :id_reserv, :time)";
        $stmpInsert= $pdo->prepare($query);
        $stmpInsert->bindParam(":id_table", $id_table);
        $stmpInsert->bindParam(":id_user", $id_user);   
        $stmpInsert->bindParam(":id_reserv", $id_reserv);
        $stmpInsert->bindParam(":time", $time);
        $stmpInsert->execute();
        $pdo->commit();
        $pdo = null;
        header("Location:result.php?data=".$id_reserv);
        
    }

    //reservartion ou updating d'une réservation antérieure pour un abonne
    if(isset($_SESSION["id"]) && !empty($_SESSION["id"]) && isset($_GET['pick']) && !isset($_GET['nom'])){
            $id_table = explode('|',$_GET['pick'])[0];
            $time =  explode('|',$_GET['pick'])[1];
            $id_reserv = get_id_reserv();
            $abonne = unserialize($_SESSION["abonne"]);
            $id_user = $abonne->getIdUser();
        
            if(count(explode('|',$_GET['pick'])) == 2){
                $conn_string = getDBparams();
                $pdo = new PDO($conn_string);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->beginTransaction();
                $query = "INSERT INTO reservation (id_table, id_user, id_reserv, heure) VALUES (:id_table, :id_user, :id_reserv, :time)";
                $stmpInsert= $pdo->prepare($query);
                $stmpInsert->bindParam(":id_table", $id_table);
                $stmpInsert->bindParam(":id_user", $id_user);   
                $stmpInsert->bindParam(":id_reserv", $id_reserv);
                $stmpInsert->bindParam(":time", $time);
                $stmpInsert->execute();
                $pdo->commit();
                $pdo = null;
                header("Location:result.php?data=".$id_reserv);

            }else{
                $id_reserv = explode('|',$_GET['pick'])[2];
                print_r (explode('|',$_GET['pick']));
                $query = "UPDATE reservation SET heure = $1, id_table = $2 WHERE id_reserv = $3";

                $conn_string = getDBparams();
                $pdo = new PDO($conn_string);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->beginTransaction();
                $query = "UPDATE reservation SET heure = :time, id_table = :id_table WHERE id_reserv = :id_reserv";
                $stmpInsert= $pdo->prepare($query);
                $stmpInsert->bindParam(":time", $time);
                $stmpInsert->bindParam(":id_table", $id_table);
                $stmpInsert->bindParam(":id_reserv", $id_reserv);
                $stmpInsert->execute();
                $pdo->commit();
                $pdo = null;
                header("Location:result.php?data=".$id_reserv);
            }
    }

    //Reservation pour un non abonne
    if(!isset($_SESSION["id"]) && isset($_GET['pick']) && isset($_GET['nom'])){
        $id_table = explode('|',$_GET['pick'])[0];
        $time = explode('|',$_GET['pick'])[1];
        $nom = $_GET['nom'];
        $prenom = $_GET['prenom'];
        $phone = $_GET['phone'];
        $plus = $_GET['plus'];
        $id_reserv = get_id_reserv();
        $id_user = get_id_user();

        $conn_string = getDBparams();
        $pdo = new PDO($conn_string);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        $query = "INSERT INTO utilisateur (id_user, nom, prenom, num_telephone) VALUES (:id_user, :nom, :prenom, :phone)";
        $stmpInsert= $pdo->prepare($query);
        $stmpInsert->bindParam(":id_user", $id_user);
        $stmpInsert->bindParam(":nom", $nom);
        $stmpInsert->bindParam(":prenom", $prenom);
        $stmpInsert->bindParam(":phone", $phone);
        $stmpInsert->execute();

        $query = "INSERT INTO nonabonne (id_user,plus) VALUES (:id_user, :plus)";
        $stmpInsert= $pdo->prepare($query);
        $stmpInsert->bindParam(":id_user", $id_user);
        $stmpInsert->bindParam(":plus", $plus);
        $stmpInsert->execute();

        $query = "INSERT INTO reservation (id_table, id_user, id_reserv, heure) VALUES (:id_table, :id_user, :id_reserv, :time)";
        $stmpInsert= $pdo->prepare($query);
        $stmpInsert->bindParam(":id_table", $id_table);
        $stmpInsert->bindParam(":id_user", $id_user);
        $stmpInsert->bindParam(":id_reserv", $id_reserv);
        $stmpInsert->bindParam(":time", $time);
        $stmpInsert->execute();

        $pdo->commit();
        $pdo = null; 
        header("Location:result.php?data=".$id_reserv);
}


    //Rechercher un nouveau créneau pour une réservation
    if(isset($_POST['check']) && isset($_POST['capacite']) && isset($_POST['time']) &&  isset($_POST['date']) &&  isset($_POST['id_reserv']) && isset($_POST['id_table'])){
        $time = $_POST['date'].' '.convertirHeure($_POST['time']);
        $time = convertirFormatDate($time);
        $capacite = $_POST['capacite'];
        $id_reserv = $_POST['id_reserv'];
        $table = $_POST['id_table'];
        echo $time;
        header("Location:booking.php?time="."$time&capacite=$capacite&reserve=$id_reserv&tab=$table");
    } 

    //Commander
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["food"])  && isset($_POST["timeC"])  && isset($_POST["dateC"])) {
            $selectedFood = $_POST["food"]; 
            $id_cmd = getIDCommande();
            $code = (int)substr($id_cmd, -4);
            $heure = $_POST["dateC"]." ".$_POST['timeC'].":00";
            if(isset($_SESSION['id'])){ 
                $abonne = unserialize($_SESSION["abonne"]);
                $id_user = $abonne->getIdUser();
                $x = (int)$abonne->getBalance();
                $balance = (int)$x;
            }
            else{
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $phone = substr($_POST['phone'], 0, 4);
                $id_user = get_id_user();
                $conn_string = getDBparams();

                $pdo = new PDO($conn_string);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->beginTransaction();
                $query = "INSERT INTO utilisateur (id_user, nom, prenom, num_telephone) VALUES (:id_user, :nom, :prenom, :phone)";
                $stmpInsert= $pdo->prepare($query);
                $stmpInsert->bindParam(":id_user", $id_user);
                $stmpInsert->bindParam(":nom", $nom);
                $stmpInsert->bindParam(":prenom", $prenom);
                $stmpInsert->bindParam(":phone", $phone);
                $stmpInsert->execute();
                $query = "INSERT INTO nonabonne (id_user) VALUES (:id_user)";
                $stmpInsert= $pdo->prepare($query);
                $stmpInsert->bindParam(":id_user", $id_user);
                $stmpInsert->execute();
                $pdo->commit();
                $pdo = null; 
                $balance = 500;
            }
            
            $prix = 0;
            if(count($selectedFood) > 0){
                for ($i = 0; $i < count($selectedFood); $i++) {
                    $pick = $selectedFood[$i];
                    $prix += (int)(explode('/', $pick))[1];
                    $item = (explode('/', $pick))[0];
                    if($balance < $prix){
                        header("Location:result.php");
                    }

                }
            }
                
            if(count($selectedFood) > 0 && $prix < $balance){
                $nouveausolde = (int)$balance - (int)$prix;
                $conn_string = getDBparams();
                $pdo = new PDO($conn_string);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->beginTransaction();
                $query = "INSERT INTO commande (id_commande, id_user, heure, solde, numero) VALUES (:id_cmd, :id_user, :heure, :prix, :code)";
                $stmpInsert= $pdo->prepare($query);
                $stmpInsert->bindParam(":id_cmd", $id_cmd);
                $stmpInsert->bindParam(":id_user", $id_user);
                $stmpInsert->bindParam(":heure", $heure);
                $stmpInsert->bindParam(":prix", $prix);
                $stmpInsert->bindParam(":code", $code);
                $stmpInsert->execute();
                
                for ($i = 0; $i < count($selectedFood); $i++) {
                    $pick = $selectedFood[$i];
                    $item = (explode('/', $pick))[0];

                    if(isBoisson($item)) $query = "INSERT INTO contient (id_commande, id_boisson) VALUES (:id_cmd, :item)";       
                    if(isMenu($item)) $query = "INSERT INTO inclut (id_commande, id_menu) VALUES (:id_cmd, :item)";
                    if(isPlat($item)) $query = "INSERT INTO se_compose (id_commande, id_plat) VALUES (:id_cmd, :item)";
                    
                    $stmpInsert= $pdo->prepare($query);
                    $stmpInsert->bindParam(":id_cmd", $id_cmd);
                    $stmpInsert->bindParam(":item", $item);
                    $stmpInsert->execute();
                    echo $item;
                }
                $query = "UPDATE abonne SET balance = :nouveausolde WHERE id_user = :id_user";
                $stmpInsert= $pdo->prepare($query);
                $stmpInsert->bindParam(":nouveausolde", $nouveausolde);
                $stmpInsert->bindParam(":id_user", $id_user);
                $stmpInsert->execute();
                $pdo->commit();
                $pdo = null; 

                if(isset($_SESSION['id'])){
                    $abonne->setBalance($nouveausolde);
                    unset($_SESSION['abonne']);
                    $_SESSION['abonne'] = serialize($abonne);
                }
                echo $id_cmd;
                header("Location:result.php?data=".$id_cmd);
            }
        } else {
            echo "No food selected.";
        }
    }
    

    //Deconnection
    if(isset($_GET["action"]) && $_GET["action"]=='logout'){
        session_destroy();
        header("Location: connexion.php");
    }

?>





