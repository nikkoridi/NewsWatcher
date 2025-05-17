<?php

namespace App\Console\Commands;

use App\Http\Controllers\NewsAPIController;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Illuminate\Console\Command;
use jcobhams\NewsApi\NewsApiException;

use Elastic\Elasticsearch\ClientBuilder;

class ElasticSearchLoadData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:elastic-search-load-data {query}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    private NewsAPIController $newsAPIController;
    private $elasticsearch;

    public function __construct(){
        parent::__construct();
        $this->newsAPIController = new NewsAPIController();
        $this->elasticsearch = ClientBuilder::create()
            ->setHosts(['9200:9200'])
            ->build();
    }


    /**
     * @throws NewsApiException
     */
    public function handle(): void
    {
        $query = $this->argument('query');
         // $data = json_decode($this->newsAPIController->getEverythingQuery($query), true);
        $data = $this->newsAPIController->getEverythingQuery($query);
        $this->line($query);
        //$this->line(strval($data));
        foreach ($data->articles as $article) {
            $this->line($article->title);
            $transformedData = [
                'title' => $article->title,
                'author' => $article->author,
                'url' => $article->url,
                'description' => $article->description,
                'content-part' => substr($article->content, 0, 170), // Shorten content to 170 symbols
                'publishedAt' => $article->publishedAt,
                    'source-id' => $article->source->id,
                    'source-name' => $article->source->name
            ];

            $params = [
                'index' => 'articles', //?
                'type' => '_doc',
                'body' => $transformedData,
            ];
            try {
                $this->elasticsearch->index($params);
                $this->line("ok");
            } catch (ClientResponseException $e) {
                $this->line("Client response error");
            } catch (MissingParameterException $e) {
                $this->line("Missing parameter response error");
            } catch (ServerResponseException $e) {
                $this->line("Server response error");
            }
        }
    }
}
