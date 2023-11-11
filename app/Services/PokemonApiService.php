<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PokemonApiService {

    public function getPokemons(string $name): array
    {
        $endpoint = config('app.api_endpoint'). "/pokemon?limit=1000000";
        $response = Http::get($endpoint);

        if($response->status() != 200) {
            return [];
        }

        $pokemones = json_decode($response->body(), true)['results'];

        $filter = array_filter($pokemones, function ($poke) use($name) {
            return stripos($poke['name'], $name) !== false;
        });

        if (count($filter) == 0) {
            return [];
        }

        $urls = array_map(function($item) {
            return $item['url'];
        }, $filter);

        $responses = Http::pool(function ($httpClient) use ($urls) {
            foreach ($urls as $url) {
                $httpClient->get($url);
            }
        });
        
        $data = array_map(function($response) {
            if ($response->successful()) {
                $response_data = json_decode($response->body(), true);
                return [
                    'name' => $response_data['name'],
                    'front' => $response_data['sprites']['front_default'],
                    'back' => $response_data['sprites']['back_default']
                ];
            }
        }, $responses);

        if (count($data) == 0) {
            return [];
        }        

        return $data;
    }

} 