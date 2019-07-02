<?php

namespace App\Controller;

use App\Entity\Specialty;
use App\Form\SpecialtyType;
use App\Traits\CrudGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SpecialtyController extends AbstractController
{
    use CrudGenerator;

    /**
     * @Route("/specialty", name="specialty")
     */
    public function index(Request $request, TranslatorInterface $transalator)
    {
        $object = $this->getEntityClass();
        $object = new $object;

        $form = $this->createForm($this->getFormClass(), $object);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $object = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($object);
            $entityManager->flush();

            $this->addFlash('success', $transalator->trans($this->getEntityName()) . ' cadastrada(o) com sucesso!');
        }

        return $this->render($this->getEntityName() . '/index.html.twig', [
            'form' => $form->createView(),
            'fieldNames' => $this->getFieldNames(),
            'items' => $this->getData()
        ]);
    }
}
