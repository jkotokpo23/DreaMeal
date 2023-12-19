<?php

/**
 * La classe Menu représente un menu proposé dans un restaurant.
 */
class Menu {
    private $id_menu;
    private $nom;
    private $prix;
    private $image;
    private $composition;
    private $description;

    /**
     * Constructeur de la classe Menu.
     *
     * @param string $id_menu L'identifiant du menu.
     * @param string $nom Le nom du menu.
     * @param float $prix Le prix du menu.
     * @param string $image Le chemin de l'image associée au menu.
     * @param string $composition La composition du menu.
     * @param string $description La description du menu.
     */
    public function __construct($id_menu, $nom, $prix, $image, $composition, $description) {
        $this->id_menu = $id_menu;
        $this->nom = $nom;
        $this->prix = $prix;
        $this->image = $image;
        $this->composition = $composition;
        $this->description = $description;
    }

    public function getIdMenu() {
        return $this->id_menu;
    }

    public function setIdMenu($id_menu) {
        $this->id_menu = $id_menu;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getPrix() {
        return $this->prix;
    }

    public function setPrix($prix) {
        $this->prix = $prix;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function getComposition() {
        return $this->composition;
    }

    public function setComposition($composition) {
        $this->composition = $composition;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
}


?>