<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\UserRepository")
 * @Annotation\Name("user")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="user_email", type="string", nullable=false)
     * @Annotation\Type("Zend\Form\Element\Email")
	 * @Annotation\Options({"label":"Email:"})
	 */
    protected $userEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="user_password", type="text", nullable=false)
     * @Annotation\Attributes({"type":"password"})
	 * @Annotation\Options({"label":"Password:"})        
	 */
    protected $userPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="user_salt", type="text", nullable=false)
     */
    protected $userSalt;

    /**
     * @var string
     *
     * @ORM\Column(name="user_vorname", type="string", length=100, nullable=true)
     */
    protected $userVorname;
    /**
     * @var string
     *
     * @ORM\Column(name="user_name", type="string", length=100, nullable=true)
     */
    protected $userName;
    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set userName
     *
     * @param string $userName
     * @return User
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string 
     */
    public function getUserName()
    {
        return $this->userName;
    }
    
    /**
     * Set userEmail
     *
     * @param string $userEmail
     * @return User
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    /**
     * Get userEmail
     *
     * @return string 
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * Set userPassword
     *
     * @param string $userPassword
     * @return User
     */
    public function setUserPassword($userPassword)
    {
        $this->userPassword = $userPassword;

        return $this;
    }

    /**
     * Get userPassword
     *
     * @return string 
     */
    public function getUserPassword()
    {
        return $this->userPassword;
    }

    /**
     * Set userSalt
     *
     * @param string $userSalt
     * @return User
     */
    public function setUserSalt($userSalt)
    {
        $this->userSalt = $userSalt;

        return $this;
    }

    /**
     * Get userSalt
     *
     * @return string 
     */
    public function getUserSalt()
    {
        return $this->userSalt;
    }

    /**
     * Set userVorname
     *
     * @param string $userVorname
     * @return User
     */
    public function setUserVorname($userVorname)
    {
        $this->userVorname = $userVorname;

        return $this;
    }

    /**
     * Get userVorname
     *
     * @return string 
     */
    public function getUserVorname()
    {
        return $this->userVorname;
    }
	
	    public function jsonSerialize() {
    	return [
	    	'userId' => $this->getUserId(),
	    	'userEmail' => $this->getUserEmail(),
	    	'userName' => $this->getUserName(),
			'userVorname' => $this->getUserVorname(),
			'userPassword' => $this->getUserPassword(),

    	];
    }
}
