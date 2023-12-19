<?php
    declare(strict_types=1);
    function getDBparams(){
        $host = "localhost";
        $port = "5432";
        $dbname = "projet_bd";
        $user = "postgres";
        $password = "t26DY8+N";
        $conn_string = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";
        return $conn_string;
    }
    
    function generateLocalisation():string{
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $url="http://www.geoplugin.net/xml.gp?ip=".$ip_address;
        $fic= file_get_contents($url);
        if(!empty($fic)){
            $xml = new SimpleXMLElement($fic);
            $res= "<p>Pays : ".$xml->geoplugin_countryName."</p>";
            $res.= "<p>Region : ".$xml->geoplugin_region."</p>";
            $res.= "<p>Ville : ".$xml->geoplugin_city."</p>";
        }
        else{
            $res="<p>Localisation indisponible</p>";
        }
        return $res;
    }

    function annuler($id){
        $conn_string = getDBparams();
        $pdo = new PDO($conn_string);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        $query = "DELETE FROM reservation WHERE id_reserv= :id";
        $stmpInsert= $pdo->prepare($query);
        $stmpInsert->bindParam(":id", $id);
        $stmpInsert->execute();
        $pdo->commit();
        $pdo = null;

       
    }

    

    function get_id_user() {
        $conn_string = getDBparams();
        $pdo = new PDO($conn_string);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        $randomNumber = random_int(10000000000, 99999999999);
        $id_usr = 'user'.$randomNumber;
        $query = "SELECT * FROM utilisateur WHERE id_user = :id_usr";
        $stmt = $pdo->prepare($query);    
        $stmt->bindParam(':id_usr', $id_usr);
        $stmt->execute();

        while ($stmt->rowCount() !== 0) {
            $randomNumber = random_int(10000000000, 99999999999);
            $id_usr = 'user'.$randomNumber;
            $stmt->bindParam(':id_usr', $id_usr);
            $stmt->execute();
        }
        $pdo->commit();
        $pdo = null;
        return $id_usr;
    }

    function getIDPlat(): string {
        $conn_string = getDBparams();
        try {
            $pdo = new PDO($conn_string);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();
            $randomNumber = random_int(10000000000, 99999999999);
            $id_plat = 'plt' . $randomNumber;
            $query = "SELECT * FROM plat WHERE id_plat = :id_plat";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id_plat', $id_plat);
            $stmt->execute();
            while ($stmt->rowCount() !== 0) {
                $randomNumber = random_int(10000000000, 99999999999);
                $id_plat = 'plt' . $randomNumber;
                $stmt->bindParam(':id_plat', $id_plat);
                $stmt->execute();
            }
            $pdo->commit();
            $pdo = null;
            return $id_plat;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return '';
        }
    }
    

    function getIDBoisson(): string {
        $conn_string = getDBparams();
        try {
            $pdo = new PDO($conn_string);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();
            $randomNumber = random_int(10000000000, 99999999999);
            $id_boisson = 'bsn' . $randomNumber;
            $query = "SELECT * FROM boisson WHERE id_boisson = :id_boisson";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id_boisson', $id_boisson);
            $stmt->execute();
            while ($stmt->rowCount() !== 0) {
                $randomNumber = random_int(10000000000, 99999999999);
                $id_boisson = 'bsn' . $randomNumber;
    
                $stmt->bindParam(':id_boisson', $id_boisson);
                $stmt->execute();
            }
            $pdo->commit();
            $pdo = null;
            return $id_boisson;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return '';
        }
    }
    

    function getIDMenu(): string {
        $conn_string = getDBparams();
    
        try {
            $pdo = new PDO($conn_string);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();
            $randomNumber = random_int(10000000000, 99999999999);
            $id_menu = 'mnu' . $randomNumber;
            $query = "SELECT * FROM menu WHERE id_menu = :id_menu";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id_menu', $id_menu);
            $stmt->execute();
    
            while ($stmt->rowCount() !== 0) {
                $randomNumber = random_int(10000000000, 99999999999);
                $id_menu = 'mnu' . $randomNumber;
    
                $stmt->bindParam(':id_menu', $id_menu);
                $stmt->execute();
            }
            $pdo->commit();
            $pdo = null;
            return $id_menu;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return '';
        }
    }
    

    function get_id_commande(): string {
        include('./database.php'); // Assurez-vous que votre fichier database.php est correctement inclus
    
        $conn_string = getDBparams();
    
        try {
            $pdo = new PDO($conn_string);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();
            $randomNumber = random_int(10000000000, 99999999999);
            $id_commande = 'cmd' . $randomNumber;
            $query = "SELECT * FROM commande WHERE id_user = :id_commande";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id_commande', $id_commande);
            $stmt->execute();
            while ($stmt->rowCount() !== 0) {
                $randomNumber = random_int(10000000000, 99999999999);
                $id_commande = 'cmd' . $randomNumber;
    
                $stmt->bindParam(':id_commande', $id_commande);
                $stmt->execute();
            }
            $pdo->commit();
            $pdo = null;
            return $id_commande;
    
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return '';
        }
    }
    


    function getDateDuJour($format = "Y-m-d") {
        return date($format);
    }

    function getIDCommande(): string {
        $conn_string = getDBparams();
    
        try {
            $pdo = new PDO($conn_string);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();
            $date = getDateDuJour();
            $query = "SELECT COUNT(*) AS nombre_de_resultats FROM commande WHERE heure LIKE :date";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':date', '%' . $date . '%');
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = (string)((int)$row['nombre_de_resultats'] + 1);
            $date = preg_replace("/-/", "", $date);
    
            while (strlen($count) < 4) {
                $count = "0" . $count;
            }
            $id_commande = 'cmd' . $date . $count;
            $pdo->commit();
            $pdo = null;
            return $id_commande;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return ''; 
        }
    }
    

    function getHeureActuelle() {
        $heureActuelle = new DateTime();
        if ($heureActuelle->format('H') >= 21 || $heureActuelle->format('H') < 11) {
            return '11:00';
        }
        $heureActuelle->modify('+1 hour');
        return $heureActuelle->format('H:i');
    }

    function getDateMax($format = "Y-m-d") {
        $dateDuJour = date("Y-m-d");
        $dateDuJourPlus7 = date($format, strtotime($dateDuJour . "+7 days"));
        return $dateDuJourPlus7;
    }

    function isBoisson($boisson):bool{
        return ((substr($boisson, 0, 3) === 'bsn') || substr($boisson, 0, 1) === 'B');
    }

    function isPlat($plat):bool{
        return ((substr($plat, 0, 3) === 'plt') || substr($plat, 0, 1) === 'P');
    }

    function isMenu($menu):bool{
        return ((substr($menu, 0, 3) === 'mnu') || substr($menu, 0, 1) === 'M');
    }

    function get_id_reserv(): string {
        global $connexion;
        
        $conn_string = getDBparams();
    
        try {
            $pdo = new PDO($conn_string);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();
            $randomNumber = random_int(10000000000, 99999999999);
            $id_rsv = 'rsrv' . $randomNumber;
            $query = "SELECT * FROM reservation WHERE id_reserv = :id_rsv";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id_rsv', $id_rsv);
            $stmt->execute();
            while ($stmt->rowCount() !== 0) {
                $randomNumber = random_int(10000000000, 99999999999);
                $id_rsv = 'rsrv' . $randomNumber;
    
                $stmt->bindParam(':id_rsv', $id_rsv);
                $stmt->execute();
            }
            $pdo->commit();
            $pdo = null;
            return $id_rsv;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return '';
        }
    }
    

    function get_id_adresse(): string {
        $conn_string = getDBparams();
    
        try {
            $pdo = new PDO($conn_string);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();
            $randomNumber = random_int(1000000, 9999999);
            $id_adresse = 'adr' . $randomNumber;
            $query = "SELECT * FROM adresse WHERE id_adresse = :id_adresse";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id_adresse', $id_adresse);
            $stmt->execute();
    
            while ($stmt->rowCount() !== 0) {
                $randomNumber = random_int(10000000000, 99999999999);
                $id_adresse = 'adr' . $randomNumber;
    
                $stmt->bindParam(':id_adresse', $id_adresse);
                $stmt->execute();
            }
            $pdo->commit();
            $pdo = null;
            return $id_adresse;
    
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return ''; 
        }
    }
    

    function same(string $pw1, string $pw2):bool{
        return $pw1 == $pw2;
    }

    function is_phone_in_database(string $phone): bool {
        $conn_string = getDBparams();
        try {
            $pdo = new PDO($conn_string);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();
            $query = "SELECT * FROM utilisateur WHERE num_telephone = :phone";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':phone', $phone);
            $stmt->execute();
    
            $rowCount = $stmt->rowCount();
            $pdo->commit();
            $pdo = null;
            return $rowCount != 0;
    
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }
    

    

    function is_mail_in_database(string $mail): bool {
        $conn_string = getDBparams();
        try {
            $pdo = new PDO($conn_string);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();
            $query = "SELECT * FROM abonne WHERE mail = :mail";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':mail', $mail);
            $stmt->execute();
    
            $rowCount = $stmt->rowCount();
            $pdo->commit();
            $pdo = null;
            return $rowCount != 0;
    
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }
    

    function toTimestamp($dateStr) {
       
        $chaineTimestamp = urldecode($dateStr);
        $date = DateTime::createFromFormat("d/m/Y h:i A", $chaineTimestamp);
        if ($date !== false) {
            return $date->format("d-m-Y H:i:s");
        } else {
            return "La conversion a échoué.";
        }
    }

    function convertirHeure($heure24) {
        if (strpos($heure24, ':') === false) {
            $heure24 .= ':00';
        }
        $heureObj = DateTime::createFromFormat('H:i:s', $heure24);
        if (!$heureObj) {
            $heureObj = DateTime::createFromFormat('H:i', $heure24);
            if (!$heureObj) {
                return "Format d'heure invalide";
            }
        }
        $heure12 = $heureObj->format('g:i A');
    
        return $heure12;
    }

    function convertirFormatDate($dateHeure) {
        $dateTimeObj = DateTime::createFromFormat('Y-m-d g:i A', $dateHeure);
        if ($dateTimeObj === false) {
            return "Format de date invalide";
        }
        $nouveauFormat = $dateTimeObj->format('m/d/Y g:i A');
        return $nouveauFormat;
    }
    
    function updateReservation($dateHeure) {
        $dateTimeObj = DateTime::createFromFormat('Y-m-d g:i A', $dateHeure);
        if ($dateTimeObj === false) {
            return "Format de date invalide";
        }
        $nouveauFormat = $dateTimeObj->format('m/d/Y g:i A');
        return $nouveauFormat;
    } 
    

?>