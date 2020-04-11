<?php

namespace CreditBundle\Entity;

use CreditBundle\Services\CurrentTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="credit_customer",
 *     uniqueConstraints={@ORM\UniqueConstraint(columns={
 *          "first_name", "last_name", "date_of_birth"
 *     })}
 * )
 * @ORM\HasLifecycleCallbacks
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="first_name", length=255, nullable=false)
     * @Assert\NotBlank(message = "First name is required field")
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", name="last_name", length=255, nullable=false)
     * @Assert\NotBlank(message = "Last name is required field")
     */
    protected $lastName;

    /**
     * @ORM\Column(type="integer", name="salary", nullable=false)
     * @Assert\NotBlank(message = "Salary is required field")
     */
    protected $salary;

    /**
     * @ORM\Column(type="date", name="date_of_birth", nullable=false)
     * @Assert\NotBlank(message = "Date of birth is required field")
     */
    protected $dateOfBirth;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="string", name="credit_score", length=16, columnDefinition="enum('good', 'bad')")
     */
    protected $creditScore = 'bad';


    public function __construct()
    {
        $this->updatedAt = CurrentTime::getTime();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Customer
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Customer
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set salary
     *
     * @param integer $salary
     * @return Customer
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * Get salary
     *
     * @return integer
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * Set dateOfBirth
     *
     * @param DateType $dateOfBirth
     * @return Customer
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth.
     *
     * @return DateType
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set creditScore
     *
     * @param string $creditScore
     * @return Customer
     */
    public function setCreditScore($creditScore)
    {
        $this->creditScore = $creditScore;

        return $this;
    }

    /**
     * Get creditScore
     *
     * @return integer
     */
    public function getCreditScore()
    {
        return $this->creditScore;
    }
    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->updatedAt = CurrentTime::getTime();
    }
}
