<?php

/**
 * La classe Abonne représente un abonné sur le site.
 */
class Abonne{
    private $id_user;
    private $mail;
    private $date_naissance;
    private $id_adresse;
    private $password;
    private $balance;
    private $profil;
    private $sexe;
    private $nom;
    private $prenom;
    private $telephone;
    private Adresse $adresse;

    /**
     * Constructeur de la classe Abonne.
     *
     * @param string $id_user L'identifiant de l'utilisateur (ID ou email).
     */
    public function __construct(string $id_user) {
        $conn_string = getDBparams();
        try {
            $pdo = new PDO($conn_string);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();
            $query = "SELECT * FROM abonne NATURAL JOIN utilisateur WHERE id_user = :id_user OR mail = :mail";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id_user', $id_user);
            $stmt->bindParam(':mail', $id_user);
            $stmt->execute();
    
            if ($stmt->rowCount() == 0) {
                // Gestion du cas où aucun utilisateur n'est trouvé
                throw new Exception("Utilisateur non trouvé pour l'ID ou l'email : $id_user");
            }
    
            $abonneData = $stmt->fetch(PDO::FETCH_ASSOC);
    
            $this->nom = $abonneData['nom'];
            $this->prenom = $abonneData['prenom'];
            $this->telephone = $abonneData['num_telephone'];
            $this->balance = $abonneData['balance'];
            $this->sexe = $abonneData['sexe'];
            $this->mail = $abonneData['mail'];
            $this->date_naissance = $abonneData['date_naissance'];
            $this->id_adresse = $abonneData['id_adresse'];
            $this->id_user = $abonneData['id_user'];
            $this->balance = $abonneData['balance'];
            $pdo->commit();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        } finally {
            $pdo = null;
        }
    }
    

    // Getter methods
    public function getIdUser() {
        return $this->id_user;
    }

    public function getMail() {
        return $this->mail;
    }

    public function getDateNaissance() {
        return $this->date_naissance;
    }

    public function getIdAdresse() {
        return $this->id_adresse;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getBalance() {
        return $this->balance;
    }

    public function getProfil() {
        return $this->profil;
    }

    public function getSexe() {
        return $this->sexe;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    // Setter methods
    public function setIdUser($id_user) {
        $this->id_user = $id_user;
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }

    public function setDateNaissance($date_naissance) {
        $this->date_naissance = $date_naissance;
    }

    public function setIdAdresse($id_adresse) {
        $this->id_adresse = $id_adresse;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setBalance($balance) {
        $this->balance = $balance;
    }

    public function setProfil($profil) {
        $this->profil = $profil;
    }

    public function setSexe($sexe) {
        $this->sexe = $sexe;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setTelephone($num_telephone) {
        $this->telephone = $num_telephone;
    }

    public function getAdresse() {
        $this->adresse = new Adresse();
        if($this->id_adresse != null && $this->id_adresse != '') {
            $this->adresse->initialization($this->id_adresse);
        }
        return $this->adresse;
    }

}

?>
