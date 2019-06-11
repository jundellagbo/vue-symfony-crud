<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NamesRepository")
 */
class Names implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", length=100)
     */
    private $fullname;

    // Get All data to JSON
    public function jsonSerialize() {
        return array(
            "id" => $this->id,
            "fullname" => $this->fullname
        );
    }

    // Getters and Setters
    public function getId() {
        return $this->id;
    }

    public function getFullname() {
        return $this->fullname;
    }

    public function setFullname( $fullname ) {
        return $this->fullname = $fullname;
    }
}
