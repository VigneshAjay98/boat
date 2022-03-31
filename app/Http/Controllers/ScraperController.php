<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;


class ScraperController extends Controller
{
    public function index()
    {
        $url = 'https://app.pricedigests.com/search?category=Boat%20Trailers&classification=Boats';
        $client = new Client();
        $crawler = $client->request('GET', $url);


        // $client  = new Client(HttpClient::create(['timeout' => 60]));
        // $crawler = $client->request('GET', $url);
        

        //Get the job title
    $titles =    $crawler->filter('h3.SearchResultItem-title')->each(function ($node) {
            print_r($node);
});

        dd( $titles);

    }
}
