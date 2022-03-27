<?php

namespace App\Entity;

use App\Repository\ControlRepository;
use App\Validator\ContainsAlphanumeric;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ControlRepository::class)
 */
class Control
{
    private static $map = ['fisrt_name', 'last_name', 'device_hash', 'mobile', 'car_number'];
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=3)
     * @ContainsAlphanumeric()
     */
    private $fisrt_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=3)
     * @ContainsAlphanumeric()
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255, options={"defaul: ''"})
     * @Assert\NotBlank()
     */
    private $car_number;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $device_hash;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^[0-9]{10}+$/")
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
        if (strlen($mobile)) {
            $preg_match_all = preg_match_all('/[0-9]+/', $mobile, $m);
            if ($preg_match_all) {
                $mobile = implode("", array_shift($m));
            }
        }

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

    /**
     * @return mixed
     */
    public function getCarNumber()
    {
        return $this->car_number;
    }

    /**
     * @param mixed $car_number
     * @return Control
     */
    public function setCarNumber($car_number)
    {
        $this->car_number = $car_number;
        return $this;
    }

    /**
     * @return string[]
     */
    public static function getMap(): array
    {
        return self::$map;
    }
}
