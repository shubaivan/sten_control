<?php

namespace App\Entity;

use App\Repository\ControlRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ControlRepository::class)
 */
class Control
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=3)
     */
    private $fisrt_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=3)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $device_hash;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $mobile;

    /**
     * @return mixed
     */
    public function getFisrtName()
    {
        return $this->fisrt_name;
    }

    /**
     * @param mixed $fisrt_name
     * @return Control
     */
    public function setFisrtName($fisrt_name)
    {
        $this->fisrt_name = $fisrt_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeviceHash()
    {
        return $this->device_hash;
    }

    /**
     * @param mixed $device_hash
     * @return Control
     */
    public function setDeviceHash($device_hash)
    {
        $this->device_hash = $device_hash;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param mixed $mobile
     * @return Control
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     * @return Control
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
        return $this;
    }


}
