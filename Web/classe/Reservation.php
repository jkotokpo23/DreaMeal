<?php
/**
 * La classe Reservation représente une réservation dans un restaurant.
 */
class Reservation {
    private $id_table;
    private $id_user;
    private $id_reserv;
    private $heure;
    private $validite;
    private $nomTable;
    private $capacite; 

    /**
     * Constructeur de la classe Reservation.
     *
     * @param int $id_table L'identifiant de la table réservée.
     * @param string $id_user L'identifiant de l'utilisateur effectuant la réservation.
     * @param int $id_reserv L'identifiant de la réservation.
     * @param string $heure L'heure de la réservation.
     * @param string $nomTable Le nom de la table réservée.
     * @param int $capacite La capacité de la table réservée.
     * @param bool $validite La validité de la réservation (par défaut à true).
     */
    public function __construct($id_table, $id_user, $id_reserv, $heure, $nomTable, $capacite, $validite = true) {
        $this->id_table = $id_table;
        $this->id_user = $id_user;
        $this->id_reserv = $id_reserv;
        $this->heure = $heure;
        $this->validite = $validite;
        $this->nomTable = $nomTable;
        $this->capacite = $capacite;
    }

    public function getIdTable() {
        return $this->id_table;
    }

    public function setIdTable($id_table) {
        $this->id_table = $id_table;
    }

    public function getIdUser() {
        return $this->id_user;
    }

    public function setIdUser($id_user) {
        $this->id_user = $id_user;
    }

    public function getIdReserv() {
        return $this->id_reserv;
    }

    public function setIdReserv($id_reserv) {
        $this->id_reserv = $id_reserv;
    }

    public function getHeure() {
        return $this->heure;
    }

    public function setHeure($heure) {
        $this->heure = $heure;
    }

    public function getValidite() {
        return $this->validite;
    }

    public function setValidite($validite) {
        $this->validite = $validite;
    }

    public function getNomTable() {
        return $this->nomTable;
    }

    public function getCapacite() {
        return $this->capacite;
    }
}

?>