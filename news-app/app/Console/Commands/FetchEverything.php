<?php

namespace App\Console\Commands;

//use App\News\NewsAPIService;
use Illuminate\Console\Command;
use jcobhams\NewsApi\NewsApiException;

use App\Http\Controllers\NewsAPIController;

class FetchEverything extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-everything {keyword} {query?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch news from everything (not only top ones). Possible first parameters:
    habrTop,
    habrSearch query,
    (variants with dash are possible\'-\')
    and otherwise search query';
    private NewsAPIController $newsAPIController;
    private PrintArticlesDataCLI $printArticlesDataCLI;

    public function __construct(){
        parent::__construct();
        $this->newsAPIController = new NewsAPIController();
        $this->printArticlesDataCLI = new PrintArticlesDataCLI();
    }

    private function printArticlesData($headlines): void
    {
        $this->printArticlesDataCLI->printArticlesData($headlines);
    }
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $keyword = $this->argument('keyword');
        try {
            switch (strtolower($keyword)){
                case "habrtop":
                case "habr-top":
                    $this->printArticlesDataCLI->printArticlesData(
                        $this->newsAPIController->getTopHabrTen()
                    ); break;
                case "habrsearch":
                case "habr-search":
                    $query = $this->argument('query');
                    $this->printArticlesDataCLI->printArticlesData(
                        $this->newsAPIController->getHabrSearch($query)
                    ); break;
                default:
                    $query = $this->argument('query');
                    $this->printArticlesDataCLI->printArticlesData(
                        $this->newsAPIController->getEverythingQuery($query)
                    ); break;
            }
        } catch (NewsApiException $e) {
            $this->error("API error");
        }
    }
}
