<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Employee;
use AppBundle\Entity\History;
use AppBundle\Entity\Repository\EmployeeRepository;
use AppBundle\Form\Type\EmployeeType;
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
 * Class EmployeeController
 * @package AppBundle\Controller
 *
 * @RouteResource("Employee")
 */
class EmployeeController extends FOSRestController implements ClassResourceInterface
{

    /**
     * Gets a collection of Tasks
     *
     * @return array
     *
     * @ApiDoc(
     *     section="Employee",
     *     output="AppBundle\Entity\Employee",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     *
     * @Route("/", name="all")
     * @Method("GET")
     */

    public function allGetAction(Request $request)
    {
        $queryBuilder = $this->getTaskRepository()->searchQuery();
        if ($request->query->getAlnum('filter')) {
            $queryBuilder
                ->where('e.title LIKE :name')
                ->orwhere('e.description LIKE :name')
                ->setParameter('name', '%' . $request->query->getAlnum('filter') . '%');
        }
        $query = $queryBuilder->getQuery();
        $paginator  = $this->get('knp_paginator');
        $tasks = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );

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

        return $this->render('Employee/all.html.twig', [
            'employees' => $tasks
        ]);
    }




    /**
     * Add a new task
     * @param Request $request
     * @return View|\Symfony\Component\Form\Form
     *
     * @ApiDoc(
     *     section="Employee",
     *     output="AppBundle\Entity\Employee",
     *     statusCodes={
     *         201 = "Returned when a new task has been successful created",
     *         404 = "Return when not found"
     *     }
     * )
     * @Route("/creates", name="create")
     * @Method({"POST", "GET"})
     */
    public function postAction(Request $request)
    {
        $form = $this->createForm(EmployeeType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $task = $form->getData();
            if($task->getImage()!=null) {
                $file = $task->getImage();
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('image_directory'),
                    $fileName
                );

                $task->setImage($fileName);
            }
            $em->persist($task);
            $em->flush();
            return $this->redirectToRoute('all');
        }
        return $this->render('Employee/create.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * Update employee
     * @param Request $request
     * @param Employee $employee
     * @return View|\Symfony\Component\Form\Form
     *
     * @ApiDoc(
     *     section="Employee",
     *     input="AppBundle\Form\Type\EmployeeType",
     *     output="AppBundle\Entity\Employee",
     *     statusCodes={
     *         204 = "Returned when an existing employee has been successful updated",
     *         400 = "Return when errors",
     *         404 = "Return when not found"
     *     }
     * )
     * @Route("/edit/{id}", name="edit")
     * @Method({"POST","GET"})
     */
    public function patchAction(Request $request, Employee $employee)
    {
        if($employee->getImage()!=null)
            $employee->setImage(new File($this->getParameter('image_directory').'/'.$employee->getImage()));
        $form = $this->createForm('AppBundle\Form\Type\EmployeeType', $employee);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $employee->getImage();
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),
                $fileName
            );
            $employee->setImage($fileName);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('all', array('id' => $employee->getId()));
        }
        return $this->render('Employee/edit.html.twig', array(
            'employee' => $employee,
            'form' => $form->createView()
        ));
    }

    /**
     *
     * @param Employee $employee
     * @return View|\Symfony\Component\Form\Form
     *
     * @ApiDoc(
     *     section="Employee",
     *     input="AppBundle\Form\Type\EmployeeType",
     *     output="AppBundle\Entity\Employee",
     *     statusCodes={
     *         204 = "Returned when an existing task has been successful updated",
     *         400 = "Return when errors",
     *         404 = "Return when not found"
     *     }
     * )
     * @Route("minus/{id}", name="minus")
     * @Method({"POST","GET"})
     * @return RedirectResponse
     */
    public function minusAction(Employee $employee)
    {
        $em = $this->getDoctrine()->getManager();
        $vacation=$employee->getVacation();
        $employee->setVacation(--$vacation);

        $em->flush();

        return $this->redirectToRoute('all');
    }

    /**
     *
     * @param Employee $employee
     * @return View|\Symfony\Component\Form\Form
     *
     * @ApiDoc(
     *     section="Employee",
     *     input="AppBundle\Form\Type\EmployeeType",
     *     output="AppBundle\Entity\Employee",
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
    public function plusAction(Employee $employee)
    {
        $em = $this->getDoctrine()->getManager();
        $own=$employee->getOwn();
        $employee->setOwn(++$own);

        $em->flush();

        return $this->redirectToRoute('all');
    }

    /**
     * Start task
     * @param Request $request
     * @param Employee $task
     * @return View|\Symfony\Component\Form\Form
     *
     * @ApiDoc(
     *     section="Employee",
     *     input="AppBundle\Form\Type\EmployeeType",
     *     output="AppBundle\Entity\Employee",
     *     statusCodes={
     *         204 = "Returned when an existing task has been successful updated",
     *         400 = "Return when errors",
     *         404 = "Return when not found"
     *     }
     * )
     * @Route("/edits/{id}", name="edit-view")
     * @Method({"POST","GET"})
     * @return RedirectResponse
     */
    public function editAction(Request $request, Employee $task)
    {
        $form = $this->createForm(EmployeeType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            // for now
            return $this->redirectToRoute('all'
            );
        }
        return $this->render('Employee/edit-view.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @return EmployeeRepository
     */
    private function getTaskRepository()
    {
        return $this->get('crv.doctrine_entity_repository.employee');
    }
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }



}
