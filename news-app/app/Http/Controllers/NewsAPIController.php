<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use jcobhams\NewsApi\NewsApi;
use jcobhams\NewsApi\NewsApiException;
use Carbon\Carbon;

class NewsAPIController extends Controller
{
    protected $newsProviderInstance;

    const TECH_DOMAINS = ["habr.com","news.ycombinator.com", "spectrum.ieee.org", "wired.com", "technologyreview.com"];

    public function __construct()
    {
        $this->newsProviderInstance = new NewsApi(config('app.newsapi_key'));
    }

    /**
     * @throws NewsApiException
     */
    public function getTopHeadlinesQuery(string $query){
        return $this->newsProviderInstance->getTopHeadlines(q: $query, page_size: 100);
    }

    /**
     * @throws NewsApiException
     */
    public function getEverythingQuery(string $query, $domains = null){
        return $this->newsProviderInstance->getEverything(q: $query, domains:$domains, page_size: 100);
    }

    /*
    enum DataStepsBack {
       case Year;
       case Month;
       case Week;
       case Day;
    }
    */

    /**
     * @throws NewsApiException
     */
    public function getTimeBackNews($date, string $stepBack, int $numberBack){
        $searchDate =  Carbon::parse($date, 'Europe/Moscow');
        $returnWarning = "We're really sorry, but our API supports only a month back search!";
        if ($numberBack <= 0) {
            $searchDate = $searchDate->format('Y-m-d');
        }
        elseif (($stepBack === 'month' && $numberBack) > 1 || ($stepBack === 'day' && $numberBack) > 30) {
            $searchDate = $searchDate->modify('-1 month');
        }
        else{
            $searchDate = match ($stepBack) {
                //"year" => $searchDate->modify(-$numberBack .'year')->format('Y-m-d'),
                "month" => $searchDate->modify(-$numberBack .'month')->format('Y-m-d'),
                "week" => $searchDate->modify(-7*$numberBack .'days')->format('Y-m-d'),
                default => $searchDate->modify(-$numberBack .'day')->format('Y-m-d'),
            };
        }
        try{
            // It's a wierd way, but I need to warn the user, the answer is JSON anyway
            // json_encode([$returnWarning, $this->newsProviderInstance->getEverything(domains: implode(', ', NewsAPIController::TECH_DOMAINS),
            //                from:$searchDate, to:$searchDate, page_size: 100)]);
            return $this->newsProviderInstance->getEverything(domains: implode(', ', NewsAPIController::TECH_DOMAINS),
                           from:$searchDate, to:$searchDate, page_size: 100);
        }
        catch (NewsApiException $e){
            return json_encode($e);
        }
    }

    /**
     * @throws NewsApiException
     */
    public function getTodayTopNews(){
        return $this->newsProviderInstance->getTopHeadLines(category: "technology", page_size: 1);
    }

    /**
     * @throws NewsApiException
     */
    public function getTopHabrTen(){
        return $this->newsProviderInstance->getEverything(domains: "habr.com",
            sort_by: "popularity",
            page_size: 10);
    }

    /**
     * @throws NewsApiException
     */
    public function getHabrSearch(string $query){
        return $this->newsProviderInstance->getEverything(q:$query, domains: "habr.com",
            page_size: 100);
    }

    /**
     * @throws NewsApiException
     */
    public function getAndQueries(string $query1, string $query2){
        $query1_articles = $this->newsProviderInstance->getEverything(q:$query1, page_size: 100);
        $query2_articles = $this->newsProviderInstance->getEverything(q:$query2, page_size: 100);
    }

    /**
     * @throws NewsApiException
     */
    public function getNotQueries(string $query1, string $query2){
        $query1_articles = $this->newsProviderInstance->getEverything(q:$query1, page_size: 100);
        $query2_articles = $this->newsProviderInstance->getEverything(q:$query2, page_size: 100);
    }

    /**
     * @throws NewsApiException
     */
    public function getAuthorsNewsEverything(string $query, string $author){
        $query_articles = $this->newsProviderInstance->getEverything(q:$query, page_size: 100);
        // Search by $article->author in articles
    }

    /**
     * @throws NewsApiException
     */
    public function getAuthorsNewsTopHeadlines(string $query, string $author){
        $query_articles = $this->newsProviderInstance->getTopHeadLines(q:$query, page_size: 100);
        // Search by $article->author in articles
    }
}
