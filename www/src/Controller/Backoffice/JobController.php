<?php

namespace App\Controller\Backoffice;


use App\Entity\Job\Job;
use App\Entity\Job\Techniques;
use \App\Form\Backoffice\Job\JobEditType;
use App\Form\Backoffice\Job\TechniquesEditType;
use App\Repository\Job\JobRepository;
use App\Repository\Job\techniquesRepository;
use App\Utils\Various\ReturnMsgsUtils;


class JobController extends BackofficeController
{
    public function listJob(JobRepository $jobRepository)
    {
        $jobs = $jobRepository->findAll();

        // rendu template
        return $this->render('backoffice/job/listJob.html.twig', array(
            'jobs' => $jobs
        ));
    }

    public function editJob($id, JobRepository $jobRepository)
    {

        $job = null;
        // charge ou nouveau user
        if ($id) {
            $job = $jobRepository->find($id);
        }

        if (!$job ) {
            $job  = new Job();
        } else {
            $job->setMediaPaths($this->tools->fileUtils->getMediaPaths($job));
        }

        // formulaire
        $form = $this->createForm(JobEditType::class, $job);
        $form->handleRequest($this->tools->requestStack->getCurrentRequest());

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                // si fichier
                if ($form->get('mediaFile')->getData()) {
                    $file = $form->get('mediaFile')->getData();

                    // chemins
                    $job->setMediaPaths($this->tools->fileUtils->getMediaPaths($job));

                    // nom du fichier
                    $job->setMedia($this->tools->fileUtils->getUniqueFileName(
                        array(
                            'path'          => $job->getMediaPaths()['folder'],
                            'file'          => $file
                        )
                    ));

                    // ecriture image
                    $this->tools->fileUtils->writeMedia($job, $file);
                }


                // sauvegarde
                $this->getDoctrine()->getManager()->persist($job);
                // Le slug
                $job->setSlug($this->tools->toolString->getSlug($job->getTitle().'-'.$job->getId()));
                $this->getDoctrine()->getManager()->flush();

                // message
                $this->addFlash(
                    ReturnMsgsUtils::CLASS_SUCCESS,
                    ReturnMsgsUtils::SAVE_SUCCESS
                );

                // redirection
                return $this->redirectToRoute('backoffice/job/edit', array('id' => $job->getId()));
            } else {
                // message
                $this->addFlash(
                    ReturnMsgsUtils::CLASS_ERROR,
                    ReturnMsgsUtils::SAVE_ERROR
                );
            }
        }

        // rendu template
        return $this->render('backoffice/job/editJob.html.twig', array(
            'form'          => $form->createView(),
            'job'     => $job
        ));
    }

    public function deleteJob($id, JobRepository $jobRepository)
    {
        $job = $jobRepository->find($id);

        if ($job != null) {
            $this->getDoctrine()->getManager()->remove($job);
            $this->getDoctrine()->getManager()->flush();

            // message
            $this->addFlash(
                ReturnMsgsUtils::CLASS_SUCCESS,
                ReturnMsgsUtils::DELETE_SUCCESS
            );
        } else {
            $this->addFlash(
                ReturnMsgsUtils::CLASS_ERROR,
                ReturnMsgsUtils::DELETE_ERROR
            );
        }
        return $this->redirectToRoute('backoffice/jobs');
    }

    public function listTechnique(techniquesRepository $techniquesRepository)
    {
        $techniques = $techniquesRepository->findAll();

        foreach ($techniques as $technique) {
            $technique->setLogoPaths($this->tools->fileUtils->getLogoPaths($technique));
        }

        // rendu template
        return $this->render('backoffice/job/techniques/listTechnique.html.twig', array(
            'techniques' => $techniques
        ));
    }


    public function editTechnique($id, techniquesRepository $techniquesRepository)
    {

        $technique = null;
        // charge ou nouveau user
        if ($id) {
            $technique = $techniquesRepository->find($id);
            $technique->setLogoPaths($this->tools->fileUtils->getLogoPaths($technique));
        }
        if (!$technique ) {
            $technique  = new Techniques();
        }

        // formulaire
        $form = $this->createForm(TechniquesEditType::class, $technique);
        $form->handleRequest($this->tools->requestStack->getCurrentRequest());

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                // si Logo
                if ($form->get('logoFile')->getData()) {
                    $file = $form->get('logoFile')->getData();

                    // chemins
                    $technique->setLogoPaths($this->tools->fileUtils->getLogoPaths($technique));

                    // nom du fichier
                    $technique->setLogo($this->tools->fileUtils->getUniqueFileName(
                        array(
                            'path'          => $technique->getLogoPaths()['folder'],
                            'file'          => $file
                        )
                    ));

                    // ecriture image
                    $this->tools->fileUtils->writeLogo($technique, $file);
                }

                // sauvegarde
                $this->getDoctrine()->getManager()->persist($technique);
                $this->getDoctrine()->getManager()->flush();

                // message
                $this->addFlash(
                    ReturnMsgsUtils::CLASS_SUCCESS,
                    ReturnMsgsUtils::SAVE_SUCCESS
                );

                // redirection
                return $this->redirectToRoute('backoffice/technique/edit', array('id' => $technique->getId()));
            } else {
                // message
                $this->addFlash(
                    ReturnMsgsUtils::CLASS_ERROR,
                    ReturnMsgsUtils::SAVE_ERROR
                );
            }
        }

        // rendu template
        return $this->render('backoffice/job/techniques/editTechnique.html.twig', array(
            'form'          => $form->createView(),
            'technique'     => $technique
        ));
    }
    public function deleteTechnique($id, techniquesRepository $techniquesRepository)
    {
        $techniques = $techniquesRepository->find($id);

        if ($techniques != null) {
            $this->getDoctrine()->getManager()->remove($techniques);
            $this->getDoctrine()->getManager()->flush();

            // message
            $this->addFlash(
                ReturnMsgsUtils::CLASS_SUCCESS,
                ReturnMsgsUtils::DELETE_SUCCESS
            );
        } else {
            $this->addFlash(
                ReturnMsgsUtils::CLASS_ERROR,
                ReturnMsgsUtils::DELETE_ERROR
            );
        }
        return $this->redirectToRoute('backoffice/techniques');
    }
}
