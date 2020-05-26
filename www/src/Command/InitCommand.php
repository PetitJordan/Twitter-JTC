<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 04/06/2019
 * Time: 11:40
 */

namespace App\Command;

use App\Entity\Addressing\Address;
use App\Entity\Addressing\Country;
use App\Entity\Catalog\Category;
use App\Entity\Catalog\IntervalValidity;
use App\Entity\Catalog\Product;
use App\Entity\Catalog\ProductCountryPrice;
use App\Entity\Catalog\ProductDeclination;
use App\Entity\Catalog\Tax;
use App\Entity\Recipient\Recipient;
use App\Entity\Recipient\RecipientSubject;
use App\Entity\User\Optin;
use App\Entity\User\UserGroup;
use App\Entity\User\User;
use App\Entity\Various\Status;
use App\Utils\Tools;
use App\Utils\Various\Constant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class InitCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:init';
    protected $entityManager;
    protected $passwordEncoder;
    protected $tools;

    protected $input;
    protected $output;

    protected $defaultUser;
    protected $defaultPassword;


    public function __construct(?string $name = null, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder, Tools $tools)
    {
        parent::__construct($name);
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->tools = $tools;
    }

    protected function configure()
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        // install
        $this->install();

        // yarn
        $this->yarn();

        // users
        $this->createUsers();

        // status
        $this->createStatuses();

        // fosjsrouting
        $this->fosjsrouting();

        // countries import
	    $this->importCountries();

        // recap
        $this->summary();

    }

    public function install()
    {
        $this->output->writeln([
            '',
            '--------------------------------------',
            ' Base create',
            '--------------------------------------',
            '',
        ]);
        exec('php bin/console doctrine:database:create');
        exec('php bin/console d:s:u --force');
    }

    public function yarn()
    {
        $this->output->writeln([
            '',
            '--------------------------------------',
            ' YARN Compile',
            '--------------------------------------',
            '',
        ]);
        exec('yarn encore dev');
    }

    public function createUsers()
    {
        $this->output->writeln([
            '',
            '--------------------------------------',
            'Admin Creator',
            '--------------------------------------',
            '',
        ]);

        $user = new User();
        $user->setGender(Constant::GENDER_MR);
        $user->setFirstname('Contact');
        $user->setLastname('Atafoto');
        $user->setEmail('contact@atafotostudio.com');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'contact'));
        $user->setIdStatus(Constant::STATUS_VALIDATE);
        $user->setBirthdate(new \DateTime('1981-10-06'));
        $user->addRole(Constant::ROLE_SUPER_ADMIN);

        $this->output->writeln('User '.$user->getEmail().' created');

        $optin = new Optin();
        $optin->setUser($user);
        $optin->setEmail($user->getEmail());
        $optin->setActive(1);
        $this->entityManager->persist($optin);

        $this->entityManager->persist($user);

        $this->entityManager->flush();

        $this->defaultUser = $user;
        $this->defaultPassword = 'contact';
    }


    public function createStatuses()
    {
        $this->output->writeln([
            '',
            '--------------------------------------',
            ' Create statuses',
            '--------------------------------------',
            '',
        ]);
        $statuses = array('Validé', 'Brouillon', 'En attente de validation', 'Refusé', 'Annulé');

        foreach ($statuses as $key => $value) {
            $status = new Status();
            $status->setName($value);
            $this->entityManager->persist($status);
        }

        $this->entityManager->flush();
    }

    public function fosjsrouting()
    {
        $this->output->writeln([
            '',
            '--------------------------------------',
            ' Rends les routes accessibles via JS',
            '--------------------------------------',
            '',
        ]);
        exec('php bin/console fos:js-routing:dump --format=json --target=public/js/fos_js_routes.json');
    }

    public function importCountries()
    {
	    $this->output->writeln([
		    '',
		    '--------------------------------------',
		    ' Importation des pays',
		    '--------------------------------------',
		    '',
	    ]);
    	exec('php bin/console doctrine:database:import src/Command/countries.sql');
    }

    public function summary()
    {
        $this->output->writeln([
            '',
            '--------------------------------------',
            'You can now log with :',
            $this->defaultUser->getEmail(),
            $this->defaultPassword,
            '--------------------------------------',
            '
           (_)            
  ___ _ __  _  ___  _   _ 
 / _ \ \'_ \| |/ _ \| | | |
|  __/ | | | | (_) | |_| |
 \___|_| |_| |\___/ \__, |
          _/ |       __/ |
         |__/       |___/             
            ',


            '',
        ]);
    }

}

