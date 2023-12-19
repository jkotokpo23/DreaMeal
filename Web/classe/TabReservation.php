<?php
    /**
     * La classe TabReservation gère un tableau de réservations.
     */
    class TabReservation{
        private $tab;
        /**
         * Constructeur de la classe TabReservation.
         *
         * @param int $id_user Identifiant de l'utilisateur pour lequel les réservations sont récupérées.
         */
        public function __construct($id_user) {
            $conn_string = getDBparams();
            try {
                $pdo = new PDO($conn_string);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->beginTransaction();
                $query = "SELECT * FROM Reservation NATURAL JOIN TableRestau WHERE id_user = :id_user";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':id_user', $id_user);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                $tabx = array();
                foreach ($data as $row) {
                    $reservation = new Reservation($row['id_table'], $row['id_user'], $row['id_reserv'], $row['heure'], $row['nom'], $row['capacite']);
                    array_push($tabx, $reservation);
                }
                $this->tab = $tabx;
                $pdo->commit();
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            } finally {
                $pdo = null;
            }
        }
        

        public function getReservation() {
            return $this->tab;
        }

        public function getOneReservation($id_reserv){
            $count = count($this->tab);
            $i = 0; $found = false;
            $rsrv = null;
            while ($i < $count && $found == false) {
                $r = $this->tab[$i]; $idR = $r->getIdReserv();
                $idR = preg_replace('/\s+/','',$idR);
                if ( $idR == $id_reserv){
                    $found = true;
                    $rsrv = $r;
                }
                $i++;
            }
            return $rsrv;
        }
        public function getReservationCR($id_table){
            $tabx = array();
            if(count( $this->tab) != 0){
                for($i=0; $i < count($this->tab); $i++){
                    if( $this->tab[$i]->getIdTable() == $id_table ){
                        array_push($tabx, $this->tab[$i]);
                    }
                }
            }
            return $tabx;
        }
    }
    
?>