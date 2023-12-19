<?php
/**
 * La classe Commande représente une commande effectuée par un utilisateur.
 */
class Commande {
    private $id_commande;
    private $heure;
    private $numero;
    private $solde;
    private $statut;
    private $id_user;
    private $tabMenu;
    private $tabBoisson;
    private $tabPlat;

    /**
     * Constructeur de la classe Commande.
     *
     * @param string $id_commande L'identifiant de la commande.
     */
    public function __construct($id_commande) {
        $this->id_commande = $id_commande;
        $conn_string = getDBparams();
    
        try {
            $pdo = new PDO($conn_string);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();
            // Récupération des données de commande
            $query_commande = "SELECT * FROM commande WHERE id_commande = :id_commande";
            $stmt_commande = $pdo->prepare($query_commande);
            $stmt_commande->bindParam(':id_commande', $id_commande);
            $stmt_commande->execute();
            $data_commande = $stmt_commande->fetch(PDO::FETCH_ASSOC);
    
            $this->heure = $data_commande['heure'];
            $this->solde = $data_commande['solde'];
    
            // Récupération des boissons
            $query_boisson = "SELECT * FROM contient NATURAL JOIN boisson WHERE id_commande = :id_commande";
            $stmt_boisson = $pdo->prepare($query_boisson);
            $stmt_boisson->bindParam(':id_commande', $id_commande);
            $stmt_boisson->execute();
            $this->tabBoisson = $stmt_boisson->fetchAll(PDO::FETCH_ASSOC);
    
            // Récupération des menus
            $query_menu = "SELECT * FROM inclut NATURAL JOIN menu WHERE id_commande = :id_commande";
            $stmt_menu = $pdo->prepare($query_menu);
            $stmt_menu->bindParam(':id_commande', $id_commande);
            $stmt_menu->execute();
            $this->tabMenu = $stmt_menu->fetchAll(PDO::FETCH_ASSOC);
    
            // Récupération des plats
            $query_plat = "SELECT * FROM se_compose NATURAL JOIN plat WHERE id_commande = :id_commande";
            $stmt_plat = $pdo->prepare($query_plat);
            $stmt_plat->bindParam(':id_commande', $id_commande);
            $stmt_plat->execute();
            $this->tabPlat = $stmt_plat->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        } finally {
            $pdo = null;
        }
    }
    

    public function getIdCommande() {
        return $this->id_commande;
    }

    public function setIdCommande($id_commande) {
        $this->id_commande = $id_commande;
    }

    public function getHeure() {
        return $this->heure;
    }

    public function setHeure($heure) {
        $this->heure = $heure;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function getSolde() {
        return $this->solde;
    }

    public function setSolde($solde) {
        $this->solde = $solde;
    }

    public function getStatut() {
        return $this->statut;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
    }

    public function getIdUser() {
        return $this->id_user;
    }

    public function setIdUser($id_user) {
        $this->id_user = $id_user;
    }

    public function getPlats() {
        return $this->tabPlat;
    }

    public function getMenus() {
        return $this->tabMenu;
    }
    

    public function getBoissons() {
        return $this->tabBoisson;
    }

    
} 


?>