<?php

namespace App\News;

use jcobhams\NewsApi\NewsApi;

use Illuminate\Support\Facades\Config;

class NewsAPIService{
    protected $newsProviderInstance;
    public function __construct()  
    {
        $this->newsProviderInstance = new NewsApi(config('app.newsapi_key'));
    }

    public function getRuTopHeadlines($q){
        return $this->newsProviderInstance->getTopHeadlines(
            q: $q
        );
    }
}
