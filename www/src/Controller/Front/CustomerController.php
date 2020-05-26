<?php

namespace App\Controller\Front;
use App\Repository\Customer\CustomerRepository;
use App\Repository\Customer\TrustedCustomerRepository;
use App\Repository\Customer\ExpertiseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CustomerController extends FrontController
{

    /* Permet d'afficher les customers sur la home */

    public function readCustomerHome(CustomerRepository $customerRepository)
    {
        $customers = $customerRepository->findBy(
            array(),
            array(
                'position' => 'ASC'
            )
        );

        foreach ($customers as $customer) {
            foreach ($customer->getCustomerMedias() as $customerMedia) {
                $customerMedia->setMediaPaths($this->tools->fileUtils->getMediaPaths($customerMedia));
            }
        }

        // rendu template
        return $this->render('front/customer/home_customers.html.twig', array(
            'customers' => $customers,
        ));
    }

    /* Permet d'afficher les customers de confiance sur la home */

    public function readTrustedCustomer(TrustedCustomerRepository $trustedCustomerRepository)
    {
        $trustedCustomers = $trustedCustomerRepository->findAll();

        foreach ($trustedCustomers as $trustedCustomer) {
            $trustedCustomer->setLogoPaths($this->tools->fileUtils->getLogoPaths($trustedCustomer));
        }

        // rendu template
        return $this->render('front/customer/trustedCustomers.html.twig', array(
            'trustedCustomers' => $trustedCustomers
        ));
    }

    /* Permet d'afficher les customers et les expertises sur la page réalisation */

    public function readRealisation(CustomerRepository $customerRepository, ExpertiseRepository $expertiseRepository, Request $request)
    {

        $customers = $customerRepository->findBy(
            array(),
            array(
                'position'   => 'ASC'
            )
        );
        $expertises = $expertiseRepository->findAll();


        foreach ($customers as $customer) {

            $customer->setLogoPaths($this->tools->fileUtils->getLogoPaths($customer));

            foreach ($customer->getCustomerMedias() as $customerMedia) {
                $customerMedia->setMediaPaths($this->tools->fileUtils->getMediaPaths($customerMedia));
            }
        }

        $breadcrumb = $this->breadcrumb->add(
            'Réalisations',
            $this->generateUrl('front/realisations')
        );


        // rendu template
        return $this->render('front/customer/realisation.html.twig', array(
            'customers' => $customers,
            'expertises' => $expertises,
            'breadcrumb' => $breadcrumb,
        ));
    }

    /* Permet d'afficher les customers sur la page Customer details */

    public function readCustomerDetails($slug, CustomerRepository $customerRepository)
    {
        $customer = $customerRepository->findOneBy(['slug'=>$slug]);

        $customer->setLogoPaths($this->tools->fileUtils->getLogoPaths($customer));


        foreach ($customer->getCustomerMedias() as $customerMedia) {
            $customerMedia->setMediaPaths($this->tools->fileUtils->getMediaPaths($customerMedia));
        }

        $breadcrumb = $this->breadcrumb->add(
            'Cas client',
            $this->generateUrl('front/customers-details', ['slug'=>$slug])
        );

        // rendu template
        return $this->render('front/customer/customer_details.html.twig', array(
            'customer' => $customer,
            'breadcrumb' => $breadcrumb,
        ));
    }

    public function filtreExpertiseAjax(Request $request, CustomerRepository $customerRepository, EntityManagerInterface $entityManager){

        // On récupère les ids sur lesquels on a cliqué

        $idExpertise = $request->request->get('id');


        // On récupère tout nos customers

        $customers = $customerRepository->findAll();


        // On créer un premier tableau dans lequel on place chaque customer

        foreach ($customers as $k => $customer) {
            $arrayCustomers[$k] = $customer;
        }

        // Pour chaque customer du tableau on boucle sur les expertises et on récupère le résultat dans un nouveau tableau expertises


        foreach ($arrayCustomers as $key => $c) {
            $arrayCustomer[$key]['customer'] = $c;

            $c->setLogoPaths($this->tools->fileUtils->getLogoPaths($c));

           $media = $c->getCustomerMedias();
            foreach ($media as $customerMedia) {
                $arrayCustomer[$key]['customerMedias'][$customerMedia->getId()] = $customerMedia->setMediaPaths($this->tools->fileUtils->getMediaPaths($customerMedia));
            }

            foreach ($c->getExpertise() as $expertise) {
                $arrayCustomer[$key]['expertises'][$expertise->getId()] = $expertise->getName();
            }
        }

        // On vérifie si les tableau expertise de chaque customer contient bien les ids récupérer au clic

        foreach ($arrayCustomer as $c => $custo) {
            foreach($custo['expertises'] as $id_expertise => $ex) {
                if ($idExpertise) {
                    if (in_array((string)$id_expertise, $idExpertise)) {
                        $customersFilter[$c] = $custo;
                    }
                }else{
                    $customersFilter[$c] = $custo;
                }
            }
        }
        // On récupère uniquement les champs dont on a besoin pour chaque customer

        $count = 0;

        foreach ($customersFilter as $k => $cust){
            $array[$count]['id'] = $cust['customer']->getId();
            $array[$count]['slug'] = $this->generateUrl('front/customers-details', ['slug' => $cust['customer']->getSlug()]);
            $array[$count]['name'] = $cust['customer']->getName();
            $array[$count]['projectName'] = $cust['customer']->getProjectName();
            $array[$count]['descriptif'] = $cust['customer']->getDescriptif();
            $array[$count]['logo'] = $cust['customer']->getLogo();
            $array[$count]['logoPaths'] = $cust['customer']->getLogoPaths();
            $array[$count]['url'] = $cust['customer']->getWebUrl();
            $array[$count]['casClient'] = $cust['customer']->getCasClient();
            foreach ($cust['customer']->getExpertise() as $ki => $item) {
                $array[$count]['expertises'][$ki]['id'] = $item->getId();
                $array[$count]['expertises'][$ki]['name'] = $item->getName();
            }
            $array[$count]['active'] = $cust['customer']->getActive();
            foreach ($cust['customer']->getCustomerMedias() as $key => $item) {
                $array[$count]['medias'][$key]['path'] = $item->getMediaPaths();
                $array[$count]['medias'][$key]['position'] = $item->getPosition();
            }
            $count++;
        }

        return new JsonResponse(['error'=>false, 'customers'=>$array]);
    }
}
