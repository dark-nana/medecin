<?php

namespace App\Controller;
use App\Entity\Medecin;
use App\Entity\Service;
use App\Entity\Specialite;
use App\Form\MedecinType;
use App\Repository\MedecinRepository;
use App\Repository\ServiceRepository;
use App\Repository\SpecialiteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    
    /**
     * @Route("/admin", name="admin")
     */
    public function index(MedecinRepository $prend )
    {
        $Medecin=$prend->findAll();
        return $this->render('admin/index.html.twig', [
            'Mede' =>  $Medecin,
        ]);
    }
    /**
     * @Route("/admin/add",name="medecin_add")
     * @Route("/admin/edit/{id}",name="medecin_edit")
     */
    public function addMedecin(Medecin $Medecin = null,Request $request,MedecinRepository $prend)
    {
        
        if(!$Medecin)
        {
            $Medecin= new Medecin();
        }
       
        $form=$this->createForm(MedecinType::Class,$Medecin);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($Medecin);
            $entitymanager->flush();//envoie vers la bdd
            return $this->redirectToRoute('admin',[
                'id'=>$Medecin->getId(),
                
            ]);
        }
        $Medecin = $prend->findOneBy([],['id'=>'desc']);
        $fr=$Medecin->getMatricule(); 
        $fr1=$Medecin->getId();
       for($i=1;$i >= $fr;$i++)
       {
            if(($i == $fr) && ($fr1>$fr) )
            {
                $fr=$fr+00001;
                break;
            }
       
        }                                                                                                         
        
        return $this->render('admin/medecin.html.twig',[
            'formmedecin'=>$form->createView(),
            'edit'=>$Medecin->getId(), 
            'matric'=>$fr  
        ]);
    }
    /**
     * @Route("/admin/delete/{id}", name="medecin_delete")
     */
    public function deleteMedecin( $id ,MedecinRepository $prend  )
    {
        $Medecin = $prend->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($Medecin);
        $entityManager->flush();
        return $this->redirectToRoute('admin/index.html.twig',[
            'Medecin'=>$Medecin
            ]);
    }
}