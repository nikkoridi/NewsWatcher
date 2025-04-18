<?php

namespace App\Console\Commands;

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
    protected $signature = 'app:fetch-headlines {keyword}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch news headlines';

    private $newsAPIService;

    public function __construct(NewsAPIService $newsAPIService){
        parent::__construct();
        $this->newsAPIService = $newsAPIService;
    }

    private function printArticlesData($headlines): void{
        if (!empty($headlines)){
            foreach ($headlines->articles as $article){
                $this->line("Title: " . $article->title);
                $this->line("Author: " . $article->author);
                $this->line("Url: " . $article->url);
                $this->line("Description: " . $article->description);
                $this->line("---------");
                $this->line("Content: " . $article->content);
                $this->line("Source: " . $article->source->name);
                //$this->line("" . $article['']);
                $this->info("=======");
            }
        } else {
            $this->error("The app has found no news =(");
        }
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $keyword = $this->argument('keyword');
        try {
            $this->printArticlesData($this->newsAPIService->getTopHeadlinesQuery($keyword));
        } catch (NewsApiException $e) {
            $this->error("API error");
        }
    }
}
