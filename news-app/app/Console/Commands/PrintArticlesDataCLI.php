<?php

namespace App\Console\Commands;

class PrintArticlesDataCLI
{
    public function printArticlesData($headlines): void
    {
        if (!empty($headlines)) {
            foreach ($headlines->articles as $article) {
                print("Title: " . $article->title ."\n");
                print("Author: " . $article->author ."\n");
                print("Url: " . $article->url ."\n");
                print("Description: " . $article->description ."\n");
                print("---------\n");
                print("Content: " . $article->content ."\n");
                print("Source: " . $article->source->name ."\n");
                print("\n\n");
            }
        } else {
            // Red color line
            echo("\033[0;31m" . "The app has found no news =(" . "\033[0m" . PHP_EOL);
        }
    }
}
