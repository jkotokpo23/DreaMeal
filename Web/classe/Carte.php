<?php 
/**
 * La classe Carte représente la carte du restaurant, contenant des menus, des plats et des boissons.
 */
class Carte{
    private $menus;
    private $plats;
    private $boissons;
    /**
     * Constructeur de la classe Carte.
     * Initialise les menus, plats et boissons à partir des données de la base de données.
     */
    public function __construct() {
        $conn_string = getDBparams();
    
        try {
            $pdo = new PDO($conn_string);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();
            // Récupération des menus
            $query_menu = "SELECT * FROM menu";
            $stmt_menu = $pdo->query($query_menu);
            $this->menus = $stmt_menu->fetchAll(PDO::FETCH_ASSOC);
    
            // Récupération des boissons
            $query_boisson = "SELECT * FROM boisson";
            $stmt_boisson = $pdo->query($query_boisson);
            $this->boissons = $stmt_boisson->fetchAll(PDO::FETCH_ASSOC);
    
            // Récupération des plats
            $query_plat = "SELECT * FROM plat";
            $stmt_plat = $pdo->query($query_plat);
            $this->plats = $stmt_plat->fetchAll(PDO::FETCH_ASSOC);
    
            // Création des objets Menu, Boisson et Plat
            $this->menus = array_map(function($row) {
                return new Menu($row['id_menu'], $row['nom'], $row['prix'], $row['image'], $row['composition'], $row['description']);
            }, $this->menus);
    
            $this->boissons = array_map(function($row) {
                return new Boisson($row['id_boisson'], $row['nom'], $row['prix'], $row['image'], $row['quantite_en_cl']);
            }, $this->boissons);
    
            $this->plats = array_map(function($row) {
                return new Plat($row['id_plat'], $row['prix'], $row['description'], $row['image'], $row['nom']);
            }, $this->plats);
            $pdo->commit();
        } catch (PDOException $e) {
            // Gestion des erreurs PDO
            echo "Erreur : " . $e->getMessage();
        } finally {
            $pdo = null;
        }
    }
    
    public function getMenus()
    {
        return $this->menus;
    }

    public function getPlats()
    {
        return $this->plats;
    }

    public function getBoissons()
    {
        return $this->boissons;
    }

}

?>