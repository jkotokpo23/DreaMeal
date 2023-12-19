<?php
     require "./include/function.inc.php";

    if(isset($_POST["nomPlat"]) && isset($_POST["prixPlat"]) && isset($_POST["descriptionPlat"])){
        $nom = $_POST["nomPlat"];
        $id_plat = getIDPlat();
        $prix = (int)$_POST["prixPlat"];
        $description = $_POST["descriptionPlat"];
        $conn_string = getDBparams();
        $pdo = new PDO($conn_string);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        $query = "INSERT INTO plat (id_plat, nom, description, prix) VALUES (:id_plat, :nom, :description, :prix)";
        $stmpInsert= $pdo->prepare($query);
        $stmpInsert->bindParam(":id_plat", $id_plat);
        $stmpInsert->bindParam(":nom", $nom);
        $stmpInsert->bindParam(":description", $description);
        $stmpInsert->bindParam(":prix", $prix);
        $stmpInsert->execute(); 
        $pdo->commit();
        $pdo = null;
        header("Location:admin.php");
    }

    if(isset($_POST["nomBoisson"]) && isset($_POST["prixBoisson"]) && isset($_POST["quantite"])){
        $nom = $_POST["nomBoisson"];
        $id_plat = getIDBoisson();
        $prix = (int)$_POST["prixBoisson"];
        $description = $_POST["quantite"];

        $conn_string = getDBparams();
        $pdo = new PDO($conn_string);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        $query = "INSERT INTO boisson (id_plat, nom, quantite_en_cl, prix) VALUES (:id_boisson, :nom, :description, :prix)";
        $stmpInsert= $pdo->prepare($query);
        $stmpInsert->bindParam(":id_boisson", $id_boisson);
        $stmpInsert->bindParam(":nom", $nom);
        $stmpInsert->bindParam(":description", $description);
        $stmpInsert->bindParam(":prix", $prix);
        $stmpInsert->execute(); 
        $pdo->commit();
        $pdo = null;
        header("Location:admin.php");
    }

    if(isset($_POST["nomMenu"]) && isset($_POST["prixMenu"]) && isset($_POST["composition"]) && isset($_POST["description"])){
       
        $nom = $_POST["nomMenu"];
        $id_plat = getIDMenu();
        $prix = (int)$_POST["prixMenu"];
        $description = $_POST["composition"];
        $composition = $_POST["description"];
        $conn_string = getDBparams();
        $pdo = new PDO($conn_string);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        $query = "INSERT INTO menu (id_menu, nom, composition, prix) VALUES (:id_menu, :nom, :description, :prix)";
        $stmpInsert= $pdo->prepare($query);
        $stmpInsert->bindParam(":id_menu", $id_menu);
        $stmpInsert->bindParam(":nom", $nom);
        $stmpInsert->bindParam(":description", $description);
        $stmpInsert->bindParam(":prix", $prix);
        $stmpInsert->execute(); 
        $pdo->commit();
        $pdo = null;
        header("Location:admin.php");
    }


?>