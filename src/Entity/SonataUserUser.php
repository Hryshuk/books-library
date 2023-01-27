<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser;
use App\Repository\SonataUserUserRepository;

/**
* @ORM\Entity(repositoryClass=SonataUserUserRepository::class)
* @ORM\Table(name="sonata_user__user")
*/
class SonataUserUser extends BaseUser
{
/**
* @ORM\Id
* @ORM\GeneratedValue
* @ORM\Column(type="integer")
*/
protected $id;

public function getId(): ?int
{
    return $this->id;
}
}