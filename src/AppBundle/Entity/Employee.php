<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Employee
 *
 * @ORM\Table(name="employees")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\EmployeeRepository")
 */
class Employee
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $id;


    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="text", length=65535, nullable=false)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text", length=65535, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $position;

    /**
     * @var integer
     *
     * @ORM\Column(name="salary", type="integer", nullable=false)
     */
    private $salary;

    /**
     * @var integer
     *
     * @ORM\Column(name="vacation", type="float", nullable=false)
     */
    private $vacation = 20;

    /**
     * @var integer
     *
     * @ORM\Column(name="own", type="float", nullable=false)
     */
    private $own = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="employment_date", type="datetime", nullable=true)
     */
    private $employmentDate;


    /**
     * @ORM\Column(name="images", type="string", nullable=true)
     *
     * @Assert\Image(mimeTypes="image/*" )
     */
    private $image;



    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return Employee
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Employee
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set position
     *
     * @param string $position
     *
     * @return Employee
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set employmentDate
     *
     * @param \DateTime $employmentDate
     *
     * @return Employee
     */
    public function setEmploymentDate($employmentDate)
    {
        $this->employmentDate = $employmentDate;

        return $this;
    }

    /**
     * Get EmploymentDate
     *
     * @return \DateTime
     */
    public function getEmploymentDate()
    {
        return $this->employmentDate;
    }
    /**
     * Set salary
     *
     * @param integer $salary
     *
     * @return Employee
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
     * Set vacation
     *
     * @param integer $vacation
     *
     * @return Employee
     */
    public function setVacation($vacation)
    {
        $this->vacation = $vacation;
        return $this;
    }
    /**
     * Get Vacation
     *
     * @return integer
     */
    public function getVacation()
    {
        return $this->vacation;
    }

    /**
     * Set own
     *
     * @param integer $own
     *
     * @return Employee
     */
    public function setOwn($own)
    {
        $this->own = $own;
        return $this;
    }
    /**
     * Get own
     *
     * @return integer
     */
    public function getOwn()
    {
        return $this->own;
    }

}

