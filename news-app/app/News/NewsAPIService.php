<?php

namespace App\News;

use jcobhams\NewsApi\NewsApi;

use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class NewsAPIService{
    protected $newsProviderInstance;
    public function __construct()
    {
        $this->newsProviderInstance = new NewsApi(config('app.newsapi_key'));
    }

    private function printArticlesData($headlines): void{
        $style = new SymfonyStyle($output->getInput(), $output);
        if (!empty($headlines)){
            foreach ($headlines->articles as $article){
                line("Title: " . $article->title);
                line("Author: " . $article->author);
                line("Url: " . $article->url);
                line("Description: " . $article->description);
                line("---------");
                line("Content: " . $article->content);
                line("Source: " . $article->source->name);
                //$this->line("" . $article['']);
                info("=======");
            }
        } else {
            error("The app has found no news =(");
        }
    }

    public function getTopHeadlinesQuery(string $query){
        return $this->newsProviderInstance->getTopHeadlines(q: $query);
        //$this->printArticlesData($data);
    }

}
