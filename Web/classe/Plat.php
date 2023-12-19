<?php
/**
 * La classe Plat représente un plat proposé dans un restaurant.
 */
class Plat {
    private $id_plat;
    private $prix;
    private $description;
    private $image;
    private $nom;

    /**
     * Constructeur de la classe Plat.
     *
     * @param string $id_plat L'identifiant du plat.
     * @param float $prix Le prix du plat.
     * @param string $description La description du plat.
     * @param string $image Le chemin de l'image associée au plat.
     * @param string $nom Le nom du plat.
     */
    public function __construct($id_plat, $prix, $description, $image, $nom) {
        $this->id_plat = $id_plat;
        $this->prix = $prix;
        $this->description = $description;
        $this->image = $image;
        $this->nom = $nom;
    }

    public function getIdPlat() {
        return $this->id_plat;
    }

    public function setIdPlat($id_plat) {
        $this->id_plat = $id_plat;
    }

    public function getPrix() {
        return $this->prix;
    }

    public function setPrix($prix) {
        $this->prix = $prix;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }
}


?>