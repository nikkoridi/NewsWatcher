<?php

namespace App\Console\Commands;

use App\Http\Controllers\NewsAPIController;
use Illuminate\Console\Command;
use jcobhams\NewsApi\NewsApiException;

class TimeBack extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:time-back {date} {stepBack=\'day\'} {numberBack=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private NewsAPIController $newsAPIController;
    private PrintArticlesDataCLI $printArticlesDataCLI;

    public function __construct(){
        parent::__construct();
        $this->newsAPIController = new NewsAPIController();
        $this->printArticlesDataCLI = new PrintArticlesDataCLI();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $date = $this->argument('date');
            $stepBack = $this->argument('stepBack');
            $numberBack = $this->argument('numberBack');
            $this->printArticlesDataCLI->printArticlesData(
                $this->newsAPIController->getTimeBackNews($date, $stepBack, $numberBack)
            );
        } catch (NewsApiException $e) {
            $this->error("API error");
        }
    }
}
