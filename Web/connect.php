<?php
session_start();

require_once "./include/function.inc.php";
require_once "./classe/Abonne.php";

function startsWith($haystack, $needle) {
    return (substr($haystack, 0, strlen($needle)) === $needle);
}

if ((isset($_POST['pass_word']) && isset($_POST['id']) && !empty($_POST['pass_word']) && !empty($_POST['id'])) || isset($_SESSION["donnees"])) {
    if (isset($_SESSION["donnees"])) {
        $data = explode('/', $_SESSION["donnees"]);
        unset($_SESSION["donnees"]);
        $id = $data[1];
        $mp = $data[0];
    } else {
        $id = $_POST['id'];
        $mp = $_POST['pass_word'];
    }

    include "database.php";

    try {
        $pdo = new PDO($conn_string);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        $query = "SELECT * FROM abonne NATURAL JOIN utilisateur WHERE id_user=:id and password=:mp";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':mp', $mp);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $abonne = new Abonne($id);
            $_SESSION['id'] = $abonne->getIdUser();
            $_SESSION['abonne'] = serialize($abonne);
            $_SESSION["prenom"] = $abonne->getPrenom();
            $pdo->commit(); 
            $pdo = null;
            header("Location: index.php");
            exit();
        }

        $query = "SELECT * FROM abonne NATURAL JOIN utilisateur WHERE mail=:id and password=:mp";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':mp', $mp);
        $stmt->execute();

        if ($stmt->rowCount() > 0 && startsWith($id,'user')) {
            $abonne = new Abonne($id);
            $_SESSION['id'] = $abonne->getIdUser();
            $_SESSION['abonne'] = serialize($abonne);
            $_SESSION["prenom"] = $abonne->getPrenom();
            $pdo->commit(); 
            $pdo = null;
            header("Location: index.php");
            exit();
        }
        if ($stmt->rowCount() > 0 && !startsWith($id,'admn')) {
            header("Location: admin.php");
            exit();
        }
        $pdo->commit(); 
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    } finally {
        $pdo = null;
    }
} else {
    header("Location:connexion.php");
    exit();
}
?>
