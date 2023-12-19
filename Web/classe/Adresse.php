<?php
/**
 * La classe Adresse représente une adresse associée à un utilisateur.
 */
class Adresse{
    private $id_adresse;
    private $no_bat;
    private $ville;
    private $code_postal;
    private $nom_rue;

    /**
     * La classe Adresse représente une adresse associée à un utilisateur.
     */
    public function __construct() {
        $id_adresse = null;
        $this->no_bat = null;
        $this->ville = null;
        $this->code_postal = null;
        $this->nom_rue = null;
    }

    /**
     * Initialise les données de l'adresse à partir de l'identifiant.
     *
     * @param string $id_adresse L'identifiant de l'adresse.
     */
    public function initialization(string $id_adresse) {
        $conn_string = getDBparams();
        try {
            $pdo = new PDO($conn_string);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();
            $query = "SELECT * FROM adresse WHERE id_adresse = :id_adresse";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id_adresse', $id_adresse);
            $stmt->execute();
    
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($data) {
                $this->id_adresse = $data['id_adresse'];
                $this->no_bat = $data['no_bat'];
                $this->ville = $data['ville'];
                $this->code_postal = $data['code_postal'];
                $this->nom_rue = $data['nom_rue'];
            } else {
                // Gestion du cas où aucune adresse n'est trouvée
                throw new Exception("Adresse non trouvée pour l'ID : $id_adresse");
            } 
            $pdo->commit();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        } finally {
            $pdo = null;
        }
    }
    

    public function getIdAdresse() {
        return $this->id_adresse;
    }

    public function getNoBat() {
        return $this->no_bat;
    }

    public function getVille() {
        return $this->ville;
    }

    public function getCodePostal() {
        return $this->code_postal;
    }

    public function getNomRue() {
        return $this->nom_rue;
    }

    // Setter methods
    public function setIdAdresse($id_adresse) {
        $this->id_adresse = $id_adresse;
    }

    public function setNoBat($no_bat) {
        $this->no_bat = $no_bat;
    }

    public function setVille($ville) {
        $this->ville = $ville;
    }

    public function setCodePostal($code_postal) {
        $this->code_postal = $code_postal;
    }

    public function setNomRue($nom_rue) {
        $this->nom_rue = $nom_rue;
    }
}



?>
