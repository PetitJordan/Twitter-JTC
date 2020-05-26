<?php

namespace App\Controller\Front;

use App\Entity\Contact\Contact;
use App\Form\Front\CandidatureEditType;
use App\Repository\Job\JobRepository;
use App\Utils\Mail\Mailer;
use App\Utils\Various\ReturnMsgsUtils;

class JobController extends FrontController
{
    public function listJob(JobRepository $jobRepository)
    {
        $breadcrumb = $this->breadcrumb->add(
            'Rejoignez-nous',
            $this->generateUrl('front/rejoignez-nous')
        );
        $jobs = $jobRepository->findBy(
            array(
                'active' => 1
            ),
            array(
                'createdAt' => 'DESC'
            )
        );

        $contact  = new Contact();
        // formulaire
        $form = $this->createForm(CandidatureEditType::class, $contact);
        $form->handleRequest($this->tools->requestStack->getCurrentRequest());

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $contact->setJob(null);
                // si fichier
                if ($form->get('mediaFile')->getData()) {
                    $file = $form->get('mediaFile')->getData();

                    // chemins
                    $contact->setMediaPaths($this->tools->fileUtils->getMediaPaths($contact));

                    // nom du fichier
                    $contact->setMedia($this->tools->fileUtils->getUniqueFileName(
                        array(
                            'path' => $contact->getMediaPaths()['folder'],
                            'file' => $file
                        )
                    ));

                    // ecriture image
                    $this->tools->fileUtils->writeMedia($contact, $file);
                }

                // sauvegarde
                $this->getDoctrine()->getManager()->persist($contact);
                $this->getDoctrine()->getManager()->flush();

                // envoi du mail
                $params = array();
                $params['job'] = $contact;
                $job = $contact->getJob();
                if ($job){
                    $params['jobId'] = $job->getTitle().'-'.$job->getSlug();
                } else {
                    $params['jobId'] = null;
                }
                $this->tools->mailer->send(
                    Mailer::JOB,
                    Mailer::CONTACT_EMAIL,
                    $params,
                    array(
                        'reply-to'      => $contact->getEmail()
                    )
                );
                // message
                $this->addFlash(
                    ReturnMsgsUtils::CLASS_SUCCESS,
                    ReturnMsgsUtils::SAVE_SUCCESS
                );

            } else {
                // message
                $this->addFlash(
                    ReturnMsgsUtils::CLASS_ERROR,
                    ReturnMsgsUtils::SAVE_ERROR
                );
            }
        }
        // rendu template
        return $this->render('front/job/job.html.twig', array(
            'jobs' => $jobs,
            'breadcrumb'     => $breadcrumb,
            'form' => $form->createView()
        ));
    }

    public function readJobDetails($id, JobRepository $jobRepository)
    {
        $job = $jobRepository->find($id);

        foreach ($job->getTechniques() as $technique) {
            $technique->setLogoPaths($this->tools->fileUtils->getLogoPaths($technique));
        }

        $job->setMediaPaths($this->tools->fileUtils->getMediaPaths($job));


        $breadcrumb = $this->breadcrumb->add(
            'Détails de l\'offre',
            $this->generateUrl('front/offer-details')
        );

        $contact  = new Contact();
        // formulaire
        $form = $this->createForm(CandidatureEditType::class, $contact);
        $form->handleRequest($this->tools->requestStack->getCurrentRequest());

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $contact->setJob($job);
                // si fichier
                if ($form->get('mediaFile')->getData()) {
                    $file = $form->get('mediaFile')->getData();

                    // chemins
                    $contact->setMediaPaths($this->tools->fileUtils->getMediaPaths($contact));

                    // nom du fichier
                    $contact->setMedia($this->tools->fileUtils->getUniqueFileName(
                        array(
                            'path' => $contact->getMediaPaths()['folder'],
                            'file' => $file
                        )
                    ));

                    // ecriture image
                    $this->tools->fileUtils->writeMedia($contact, $file);
                }
                // sauvegarde
                $this->getDoctrine()->getManager()->persist($contact);
                $this->getDoctrine()->getManager()->flush();

                // envoi du mail
                $params = array();
                $params['job'] = $contact;
                $job = $contact->getJob();
                if ($job){
                    $params['jobId'] = $job->getTitle().'-'.$job->getSlug();
                } else {
                    $params['jobId'] = null;
                }
                $this->tools->mailer->send(
                    Mailer::JOB,
                    Mailer::CONTACT_EMAIL,
                    $params,
                    array(
                        'reply-to'      => $contact->getEmail()
                    )
                );
                // message
                $this->addFlash(
                    ReturnMsgsUtils::CLASS_SUCCESS,
                    ReturnMsgsUtils::SAVE_SUCCESS
                );

            } else {
                // message
                $this->addFlash(
                    ReturnMsgsUtils::CLASS_ERROR,
                    ReturnMsgsUtils::SAVE_ERROR
                );
            }
        }
        // rendu template
        return $this->render('front/job/offer_detail.html.twig', array(
            'job' => $job,
            'breadcrumb' => $breadcrumb,
            'form'  => $form->createView()
        ));
    }
}
