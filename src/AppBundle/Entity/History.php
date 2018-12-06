<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Employee
 *
 * @ORM\Table(name="history")
 * @ORM\Entity
 */
class History
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
     * @var \AppBundle\Entity\Employee
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employee")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="employee", referencedColumnName="id")
     * })
     */
    private $employee;


    /**
     * @var integer
     *
     * @ORM\Column(name="salary", type="integer", nullable=false)
     */
    private $salary;


    /**
     * @var integer
     *
     * @ORM\Column(name="month", type="string", nullable=false)
     */
    private $month;


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
     * Set employee
     *
     * @param \AppBundle\Entity\Employee $employee
     *
     * @return User
     */
    public function setEmployee(\AppBundle\Entity\Employee $employee)
    {
        $this->employee = $employee;
        return $this;
    }
    /**
     * Get role
     *
     * @return string
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * Set title
     *
     * @param string $month
     *
     * @return History
     */
    public function setMonth($month)
    {
        $this->month = $month;
        return $this;
    }
    /**
     * Get month
     *
     * @return string
     */
    public function getMonth()
    {
        return $this->month;
    }

}

