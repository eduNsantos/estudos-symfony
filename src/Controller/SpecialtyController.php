<?php

namespace App\Controller;

use App\Entity\Specialty;
use App\Traits\CRUDTrait;
use App\Form\SpecialtyType;
use App\Interfaces\CRUDInterface;
use App\Controller\Abstraction\AbstractCRUD;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpecialtyController extends AbstractCRUD
{
    protected $entityClass = Specialty::class;
    /**
     * @Route("/specialty", name="specialty")
     */
    public function index(Request $request)
    {
        $specialty = new Specialty;

        $form = $this->createForm(SpecialtyType::class, $specialty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $specialty = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($specialty);
            $entityManager->flush();

            $this->addFlash('success', 'Categoria cadastrada com sucesso!');
        }

        return $this->render('specialty/index.html.twig', [
            'form' => $form->createView(),
            'items' => $this->getFieldNames()
        ]);
    }

    public function setEntityClass($name)
    {
        $this->entityClass = $name;
    }
}
