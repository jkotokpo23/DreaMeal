<?php
/**
 * La classe TabCommande représente un ensemble de commandes associées à un utilisateur.
 */
    class TabCommande{
        private $tabMenu;
        private $tabPlat;
        private $tabBoisson;
        private $id_commande;

        /**
         * Constructeur de la classe TabCommande.
         *
         * @param string $id_user L'identifiant de l'utilisateur pour lequel on récupère les commandes.
         */
        public function __construct($id_user) {
            $conn_string = getDBparams();
        
            try {
                $pdo = new PDO($conn_string);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->beginTransaction();
                $query_menu = "SELECT * FROM commande NATURAL JOIN menu WHERE id_user = :id_user";
                $query_plat = "SELECT * FROM commande NATURAL JOIN plat WHERE id_user = :id_user";
                $query_boisson = "SELECT * FROM commande NATURAL JOIN boisson WHERE id_user = :id_user";
        
                $stmt_menu = $pdo->prepare($query_menu);
                $stmt_menu->bindParam(':id_user', $id_user);
                $stmt_menu->execute();
                $data_menu = $stmt_menu->fetchAll(PDO::FETCH_ASSOC);
        
                $stmt_plat = $pdo->prepare($query_plat);
                $stmt_plat->bindParam(':id_user', $id_user);
                $stmt_plat->execute();
                $data_plat = $stmt_plat->fetchAll(PDO::FETCH_ASSOC);
        
                $stmt_boisson = $pdo->prepare($query_boisson);
                $stmt_boisson->bindParam(':id_user', $id_user);
                $stmt_boisson->execute();
                $data_boisson = $stmt_boisson->fetchAll(PDO::FETCH_ASSOC);
        
                $tabx = array();
                $taby = array();
                $tabz = array();
        
                foreach ($data_menu as $row) {
                    $menu = new Menu($row['id_menu'], $row['nom'], $row['prix'], $row['image'], $row['composition'], $row['description']);
                    array_push($tabx, $menu);
                }
        
                foreach ($data_plat as $row) {
                    $plat = new Plat($row['id_plat'], $row['prix'], $row['description'], $row['image'], $row['nom']);
                    array_push($taby, $plat);
                }
        
                foreach ($data_boisson as $row) {
                    $boisson = new Boisson($row['id_boisson'], $row['nom'], $row['prix'], $row['image'], $row['quantite_en_cl']);
                    array_push($tabz, $boisson);
                }
        
                $this->tabMenu = $tabx;
                $this->tabPlat = $taby;
                $this->tabBoisson = $tabz;
                $pdo->commit();
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            } finally {
                $pdo = null;
            }
        }
        

        public function getMenu() {
            return $this->tabMenu;
        }

        public function getBoisson() {
            return $this->tabBoisson;
        }

        public function getPlat() {
            return $this->tabPlat;
        }
    } 
?>