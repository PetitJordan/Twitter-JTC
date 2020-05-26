<?php

namespace App\Controller\Backoffice;

use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerMedia;
use App\Entity\Customer\TrustedCustomer;
use App\Entity\Customer\Expertise;
use App\Form\Backoffice\Customer\CustomerEditType;
use App\Form\Backoffice\Customer\TrustedCustomerEditType;
use App\Form\Backoffice\Customer\ExpertiseEditType;
use App\Repository\Customer\CustomerRepository;
use App\Repository\Customer\TrustedCustomerRepository;
use App\Repository\Customer\ExpertiseRepository;
use App\Utils\Various\ReturnMsgsUtils;

class CustomerController extends BackofficeController
{
    public function listCustomer(CustomerRepository $customerRepository)
    {
        $customers = $customerRepository->findAll();

        foreach ($customers as $customer) {
            $customer->setLogoPaths($this->tools->fileUtils->getLogoPaths($customer));
        }

        return $this->render('backoffice/customer/listCustomer.html.twig', array(
            'customers' => $customers
        ));
    }

    public function editCustomer($id, CustomerRepository $customerRepository)
    {
        $customer = null;
        // charge ou nouveau user
        if ($id) {
            $customer = $customerRepository->find($id);
            $customer->setLogoPaths($this->tools->fileUtils->getLogoPaths($customer));
        }
        if (!$customer) {
            $customer = new Customer();
        } else {
            foreach ($customer->getCustomerMedias() as $customerMedia) {
                $customerMedia->setMediaPaths($this->tools->fileUtils->getMediaPaths($customerMedia));
            }
        }
        // formulaire
        $form = $this->createForm(CustomerEditType::class, $customer);
        $form->handleRequest($this->tools->requestStack->getCurrentRequest());
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $customer->setSlug($this->tools->toolString->getSlug($customer->getName()));

                // si Logo
                if ($form->get('logoFile')->getData()) {
                    $file = $form->get('logoFile')->getData();

                    // chemins
                    $customer->setLogoPaths($this->tools->fileUtils->getLogoPaths($customer));

                    // nom du fichier
                    $customer->setLogo($this->tools->fileUtils->getUniqueFileName(
                        array(
                            'path'          => $customer->getLogoPaths()['folder'],
                            'file'          => $file
                        )
                    ));

                    // ecriture image
                    $this->tools->fileUtils->writeLogo($customer, $file);
                }

                // si Media
                if ($form->get('customerMedias')->getData()) {
                    foreach ($form->get('customerMedias')->getData() as $customerMedia) {

                        /** @var CustomerMedia $customerMedia */

                        if ($customerMedia->getMediaFile()) {
                            $file = $customerMedia->getMediaFile();
                            if (!$file) {
                                continue;
                            }

                            // chemins
                            $customerMedia->setMediaPaths($this->tools->fileUtils->getMediaPaths($customerMedia));

                            // nom du fichier
                            $customerMedia->setMedia($this->tools->fileUtils->getUniqueFileName(
                                array(
                                    'path' => $customerMedia->getMediaPaths()['folder'],
                                    'file' => $file
                                )
                            ));
                            $customerMedia->setActive(1);
                            $customerMedia->setPosition(0);
                            // ecriture image
                            $this->tools->fileUtils->writeMedia($customerMedia, $file);
                        }
                    }
                }

                // sauvegarde
                $this->getDoctrine()->getManager()->persist($customer);
                $this->getDoctrine()->getManager()->flush();

                // message
                $this->addFlash(
                    ReturnMsgsUtils::CLASS_SUCCESS,
                    ReturnMsgsUtils::SAVE_SUCCESS
                );

                // redirection
                return $this->redirectToRoute('backoffice/customer/edit',
                    array('id' => $customer->getId()
                    )
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
        return $this->render('backoffice/customer/editCustomer.html.twig', array(
            'form' => $form->createView(),
            'customer' => $customer
        ));
    }

    public function deleteCustomer($id, CustomerRepository $customerRepository)
    {
        $customer = $customerRepository->find($id);

        if ($customer != null) {
            $this->getDoctrine()->getManager()->remove($customer);
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
        return $this->redirectToRoute('backoffice/customers');
    }




    /***********************   Controller des expertises qu'on retrouve pour chaque Customers   ***********************/



    public function listExpertise(ExpertiseRepository $expertiseRepository)
    {
        $expertises = $expertiseRepository->findAll();

        // rendu template
        return $this->render('backoffice/customer/expertise/listExpertise.html.twig', array(
            'expertises' => $expertises
        ));
    }

    public function editExpertise($id, ExpertiseRepository $expertiseRepository)
    {
        $expertise = null;
        // charge ou nouveau user
        if ((int)$id != 0) {
            $expertise = $expertiseRepository->find($id);
        }
        if (!$expertise ) {
            $expertise  = new Expertise();
        }

        // formulaire
        $form = $this->createForm(ExpertiseEditType::class, $expertise);
        $form->handleRequest($this->tools->requestStack->getCurrentRequest());

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                // sauvegarde
                $this->getDoctrine()->getManager()->persist($expertise);
                $this->getDoctrine()->getManager()->flush();

                // message
                $this->addFlash(
                    ReturnMsgsUtils::CLASS_SUCCESS,
                    ReturnMsgsUtils::SAVE_SUCCESS
                );

                // redirection
                return $this->redirectToRoute('backoffice/expertise/edit', array('id' => $expertise->getId()));
            } else {
                // message
                $this->addFlash(
                    ReturnMsgsUtils::CLASS_ERROR,
                    ReturnMsgsUtils::SAVE_ERROR
                );
            }
        }

        // rendu template
        return $this->render('backoffice/customer/expertise/editExpertise.html.twig', array(
            'form'          => $form->createView(),
            'expertise'     => $expertise
        ));
    }
    public function deleteExpertise($id, ExpertiseRepository $expertiseRepository)
    {
        $expertise = $expertiseRepository->find($id);

        if ($expertise != null) {
            $this->getDoctrine()->getManager()->remove($expertise);
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
        return $this->redirectToRoute('backoffice/expertises');
    }

    /***********************   Controller des customer de confiance qu'on retrouve sur la home   ***********************/

    public function listTrustedCustomer( TrustedCustomerRepository $trustedCustomerRepository)
    {
        $trustedCustomers = $trustedCustomerRepository->findAll();

        foreach ($trustedCustomers as $trustedCustomer) {
            $trustedCustomer->setLogoPaths($this->tools->fileUtils->getLogoPaths($trustedCustomer));
        }

        // rendu template
        return $this->render('backoffice/customer/trusted_customer/listTrustedCustomer.html.twig', array(
            'trustedCustomers' => $trustedCustomers
        ));
    }

    public function editTrustedCustomer($id, TrustedCustomerRepository $trustedCustomerRepository)
    {
        $trustedCustomer = null;
        // charge ou nouveau user
        if ($id) {
            $trustedCustomer = $trustedCustomerRepository->find($id);
        }
        if (!$trustedCustomer) {
            $trustedCustomer = new TrustedCustomer();
        }

        // formulaire
        $form = $this->createForm(TrustedCustomerEditType::class, $trustedCustomer);
        $form->handleRequest($this->tools->requestStack->getCurrentRequest());
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                // sauvegarde
                $this->getDoctrine()->getManager()->persist($trustedCustomer);
                $this->getDoctrine()->getManager()->flush();

                // message
                $this->addFlash(
                    ReturnMsgsUtils::CLASS_SUCCESS,
                    ReturnMsgsUtils::SAVE_SUCCESS
                );

                // redirection
                return $this->redirectToRoute('backoffice/trusted_customer/edit',
                    array('id' => $trustedCustomer->getId()
                    )
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
        return $this->render('backoffice/customer/trusted_customer/editTrustedCustomer.html.twig', array(
            'form' => $form->createView(),
            'trustedCustomer' => $trustedCustomer
        ));
    }

    public function deleteTrustedCustomer($id, TrustedCustomerRepository $trustedCustomerRepository)
    {
        $trustedCustomer = $trustedCustomerRepository->find($id);

        if ($trustedCustomer != null) {
            $this->getDoctrine()->getManager()->remove($trustedCustomer);
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
        return $this->redirectToRoute('backoffice/trusted_customers');
    }
}
