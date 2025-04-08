<?php

namespace App\Http\Controllers;

use App\News\NewsAPIService;
use Illuminate\Http\Request;

class NewsApiController extends Controller
{
    private $newsAPIService;

    public function __construct(NewsAPIService $newsAPIService){
        $this->newsAPIService = $newsAPIService;
    }

}
