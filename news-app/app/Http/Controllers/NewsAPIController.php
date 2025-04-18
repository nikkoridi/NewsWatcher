<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use jcobhams\NewsApi\NewsApi;

class NewsAPIController extends Controller
{
    protected $newsProviderInstance;

    private const TECH_DOMAINS = ["habr.com","news.ycombinator.com"];

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
        $searchDate = new \DateTime($date);
        switch ($stepBack) {
            case "year":
                $searchDate = $searchDate->modify("{-1*$numberBack} year")->format('Y-m-d');
                break;
            case "month":
                $searchDate = $searchDate->modify("{-1*$numberBack}  month")->format('Y-m-d');
                break;
            case "week":
                $searchDate = $searchDate->modify("{-7*$numberBack}  days")->format('Y-m-d');
                break;
            case "day":
                $searchDate = $searchDate->modify("{-1*$numberBack} day")->format('Y-m-d');
                break;
                break;
            default:
                $searchDate = $searchDate->modify("{-1*$numberBack} day")->format('Y-m-d');
        }
        return $this->newsProviderInstance->getEverything(domains: "habr.com, news.ycombinator.com",
            from:$searchDate, to:$searchDate, page_size: 100);
    }

    /**
     * @throws NewsApiException
     */
    public function getTodayTopNews(){
        //$searchDate = (new \DateTime())->format('Y-m-d');
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
