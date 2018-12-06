<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\History;
use AppBundle\Entity\Employee;
use AppBundle\Entity\Repository\HistoryRepository;
use AppBundle\Form\Type\HistoryType;
use DoctrineExtensions\Query\Mysql\Date;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
/**
 * Class HistoryController
 * @package AppBundle\Controller
 *
 * @RouteResource("History")
 */
class HistoryController extends FOSRestController implements ClassResourceInterface
{

    /**
     *
     * @ApiDoc(
     *     section="History",
     *     input="AppBundle\Form\Type\HistoryType",
     *     output="AppBundle\Entity\History",
     *     statusCodes={
     *         204 = "Returned when an existing task has been successful updated",
     *         400 = "Return when errors",
     *         404 = "Return when not found"
     *     }
     * )
     * @Route("add", name="add")
     * @Method({"POST","GET"})
     * @return RedirectResponse
     */
    public function minusAction()
    {

        $em = $this->getDoctrine()->getManager();
        $employee = $this->getDoctrine()->getManager()->getRepository(Employee::class)->findAll();
        $dates = new \DateTime('now');
        $days = $dates->format('d');
        $month = $dates->format('m');
        if($days == '25') {
            foreach ($employee as $e) {
                $salaries = $e->getSalary();
                $history = new History();
                $history->setSalary($salaries);
                $history->setMonth($month);
                $history->setEmployee($e);
                $em->persist($history);
                $em->flush();
            }
        }
        return $this->redirectToRoute('all');
    }

    /**
     *
     * @param History $history
     * @return View|\Symfony\Component\Form\Form
     *
     * @ApiDoc(
     *     section="History",
     *     input="AppBundle\Form\Type\HistoryType",
     *     output="AppBundle\Entity\History",
     *     statusCodes={
     *         204 = "Returned when an existing task has been successful updated",
     *         400 = "Return when errors",
     *         404 = "Return when not found"
     *     }
     * )
     * @Route("plus/{id}", name="plus")
     * @Method({"POST","GET"})
     * @return RedirectResponse
     */
    public function plusAction(History $history)
    {
        $em = $this->getDoctrine()->getManager();
        $own=$history->getOwn();
        $history->setOwn(++$own);

        $em->flush();

        return $this->redirectToRoute('all');
    }





}
