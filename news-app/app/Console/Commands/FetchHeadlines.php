<?php

namespace App\Console\Commands;

use App\Http\Controllers\NewsAPIController;
use Illuminate\Console\Command;

use App\News\NewsAPIService;
use jcobhams\NewsApi\NewsApiException;

class FetchHeadlines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-headlines {query}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch news headlines. Possible variants: query (will search given word)
    or todaytop|today-top (will show today top news)';

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
    public function handle()
    {
        $keyword = $this->argument('query');
        try {
            if (strtolower($keyword) === "todaytop" || strtolower($keyword) === "today-top")
                $this->printArticlesDataCLI->printArticlesData(
                    $this->newsAPIController->getTodayTopNews()
                );
            else
                $this->printArticlesDataCLI->printArticlesData(
                    $this->newsAPIController->getTopHeadlinesQuery($keyword)
                );
        }
        catch (NewsApiException $e) {
            $this->error("API error");
        }
    }
}
