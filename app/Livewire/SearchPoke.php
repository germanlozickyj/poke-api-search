<?php

namespace App\Livewire;

use App\Services\PokemonApiService;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\WithPagination;

class SearchPoke extends Component
{   
    use WithPagination;

    #[Rule('required', message: 'El nombre del Pokémon debe tener al menos 2 caracteres')]
    public $name;

    protected $paginationTheme = 'tailwind';

    protected $listeners = ['startSearch', 'stopSearch'];

    public $loading = false;

    public function mount()
    {
        $this->name = session('search_poke_name', '');
    }

    public function updatedName()
    {
        $this->validate();

        session(['search_poke_name' => $this->name]);
    }

    public function render()
    {
        $pokemons = $this->name ? $this->searchPokemon() : [];

        return view('components.search', [
                    'data' => $pokemons,
                ])
                ->extends('layouts.app')
                ->section('content');
    }

    public function searchPokemon()
    {
        $api_service = new PokemonApiService();
        $data = $api_service->getPokemons($this->name);

        if(empty($data)) {
            $this->addError('name', 'No se encontraron pokémones');
        }

        return $this->paginate($data);
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function startSearch()
    {
        $this->loading = true;

        $this->resetPage();
    }

    public function paginationView()
    {
        return 'vendor.livewire.tailwind';
    }

    public function stopSearch()
    {
        $this->loading = false;
    }

}
