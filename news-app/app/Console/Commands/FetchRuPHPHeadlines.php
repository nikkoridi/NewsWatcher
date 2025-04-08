<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\News\NewsAPIService;

class FetchRuPHPHeadlines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-ru-p-h-p-headlines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch PHP news headlines (Ru)';

    private $newsAPIService;

    public function __construct(NewsAPIService $newsAPIService){
        parent::__construct();
        $this->newsAPIService = $newsAPIService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = $this->newsAPIService->getRuTopHeadlines('php');
        if ($data->articles){
            foreach ($data->articles as $article){
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
}
