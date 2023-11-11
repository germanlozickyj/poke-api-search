<?php

use App\Services\PokemonApiService;
use Illuminate\Support\Facades\Http;

it('obtiene pokémons por nombre parcial', function () {
    $pokemonApiService = new PokemonApiService();

    $result = $pokemonApiService->getPokemons('pika');

    expect($result[0]['name'])->toBe('pikachu');
    
    expect(Http::get($result[0]['front'])->status())->toBe(200);
    expect(Http::get($result[0]['back'])->status())->toBe(200);
});

it('maneja la API no disponible correctamente', function () {
    Http::fake(['*' => Http::response([], 500)]);

    $pokemonApiService = new PokemonApiService();

    $result = $pokemonApiService->getPokemons('pikachu');

    expect($result)->toBe([]);
});

it('maneja la ausencia de resultados correctamente', function () {
    Http::fake(['*' => Http::response(['results' => []], 200)]);

    $pokemonApiService = new PokemonApiService();

    $result = $pokemonApiService->getPokemons('charizard');

    expect($result)->toBe([]);
});

test('maneja respuestas individuales incorrectas correctamente', function () {
    //Mocking
    Http::fake([
        config('app.api_endpoint'). "/pokemon?limit=1000000" => Http::response(['results' => [
            [
                'name' => 'pikachu',
                'url' => 'https://pokeapi.co/api/v2/pokemon/25/'
            ],
            [
                'name' => 'bulbasaur', 
                'url' => 'https://pokeapi.co/api/v2/pokemon/1/'
            ]
        ]
    ], 200),
        'https://pokeapi.co/api/v2/pokemon/25/' => Http::response([], 500),
        'https://pokeapi.co/api/v2/pokemon/1/' => Http::response([
            'name' => 'bulbasaur', 
            'sprites' => [
                'front_default' => 'bulbasaur-front.jpg',
                'back_default' => 'bulbasaur-back.jpg'
            ]], 200),
    ]);

    $pokemonApiService = new PokemonApiService();

    $result = $pokemonApiService->getPokemons('bulbasaur');

    expect($result)->toBe([[
            'name' => 'bulbasaur',
            'front' => 'bulbasaur-front.jpg', 
            'back' => 'bulbasaur-back.jpg'
        ]
    ]);
});
