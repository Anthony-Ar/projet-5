<?php
declare(strict_types=1);

namespace App\Entity;

class Contact
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $email = null;
    private ?string $phoneNumber = null;

    /**
     * Magic method pour indiquer à l'entité comment se
     * comporter si elle est utilisée comme une chaîne de caractère
     * @return string
     */
    public function __toString() : string
    {
        return 'id: '.$this->id.', name: '.$this->name.', email: '.$this->email.', phone: '.$this->phoneNumber;
    }

    /**
     * Créer et hydrate une entité "Contact" à partir d'un tableau de valeur
     * @param $array
     * @return Contact
     */
    public static function fromArray($array) : Contact
    {
        $contact = new Contact();
        $contact
            ->setId($array['id'])
            ->setName($array['name'])
            ->setEmail($array['email'])
            ->setPhoneNumber($array['phone_number'])
        ;

        return $contact;
    }

    /**
     * @return int|null
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Contact
     */
    public function setId(?int $id) : Contact
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName() : ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Contact
     */
    public function setName(?string $name) : Contact
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail() : ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return Contact
     */
    public function setEmail(?string $email) : Contact
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber() : ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string|null $phoneNumber
     * @return Contact
     */
    public function setPhoneNumber(?string $phoneNumber) : Contact
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

}
