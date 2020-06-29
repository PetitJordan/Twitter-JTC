<?php


namespace App\Command;


use App\Repository\Keyword\RequestRepository;
use App\Service\TwitterService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateTrendsCommand extends Command
{
    protected static $defaultName = 'app:update-trends';

    private $twitterService;
    private $requestRepository;

    public function __construct(TwitterService $twitterService, RequestRepository $requestRepository)
    {
        $this->twitterService = $twitterService;
        $this->requestRepository = $requestRepository;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $trendings = $this->twitterService->getTrendsPlace();
        $trendingsWithVolume = array();
        foreach ($trendings['0']->trends as $trend){
            if (isset($trend->tweet_volume)){
                $trendingsWithVolume[$trend->name] = $trend->tweet_volume;
                $this->requestRepository->createTrend($trend->name, $trend->tweet_volume);
            }
        }

        $io->success("Command Completed Successfully!");
        return;
    }
}