<?php

namespace App\News;

use jcobhams\NewsApi\NewsApi;

use Illuminate\Support\Facades\Config;
use jcobhams\NewsApi\NewsApiException;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class NewsAPIService{
    protected $newsProviderInstance;
    public function __construct()
    {
        $this->newsProviderInstance = new NewsApi(config('app.newsapi_key'));
    }

    private function printArticlesData($headlines, OutputInterface $output): void{
        $style = new SymfonyStyle($output->getInput(), $output);
        if (!empty($headlines)){
            foreach ($headlines->articles as $article){
                $style->line("Title: " . $article->title);
                $style->line("Author: " . $article->author);
                $style->line("Url: " . $article->url);
                $style->line("Description: " . $article->description);
                $style->line("---------");
                $style->line("Content: " . $article->content);
                $style->line("Source: " . $article->source->name);
                //$this->line("" . $article['']);
                info("=======");
            }
        } else {
            error("The app has found no news =(");
        }
    }

    /**
     * @throws NewsApiException
     */
    public function getTopHeadlinesQuery(string $query){
        return $this->newsProviderInstance->getTopHeadlines(q: $query, page_size: 100);
        //$this->printArticlesData($data);
    }

    /**
     * @throws NewsApiException
     */
    public function getEverythingQuery(string $query, $domains = null){
        return $this->newsProviderInstance->getEverything(q: $query, domains:$domains, page_size: 100);
    }
}
