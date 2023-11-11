<div class="flex justify-center mt-10 w-[70vw] px-10 gap-5 flex-col text-white">
    <h1 class="font-bold text-3xl">POKEMON FINDER</h1>

    {{-- SEARCH --}}
    <div class="w-full grid grid-cols-1">
        <div class="flex flex-row items-start">
            <div class="w-full flex flex-row">
                <input type="text" wire:model.lazy="name" class="block p-2.5 w-[500px] z-20 text-sm text-gray-900 bg-gray-50 rounded-l-lg border-l-gray-50 border-l-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-l-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="Ingrese el nombre a buscar" required>
                <button wire:click="startSearch" type="submit" class="p-2.5 text-sm font-medium text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover-bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </div>
        </div>

        <div class="mt-5">
            @error('name') <span class="text-red-500">{{ $message }}</span> @enderror 
        </div>
    </div>

    {{-- Loading --}}

    <div wire:loading wire:target="startSearch" role="status">
        <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
        </svg>
        <span class="sr-only">Loading...</span>
    </div>

    {{-- LIST SEARCH --}}
    <div class="mb-5">
        @if($data)
            @foreach ($data as $item)
                <h2 class="font-bold text-xl">{{ $item['name'] }}</h2>
                <div class="grid grid-cols-2 gap-2 mb-5">
                    <div class="w-full md:w-1/2 lg:w-[280px]">
                        <img class="border border-blue-500 rounded-md w-full h-72 object-cover object-center" src="{{ $item['front'] }}" alt="{{ $item['name'] }}">
                    </div>
                    <div class="w-full md:w-1/2 lg:w-[280px]">
                        <img class="border border-blue-500 rounded-md w-full h-72 object-cover object-center" src="{{ $item['back'] }}" alt="{{ $item['name'] }}">
                    </div>
                </div>
            @endforeach
            
            @if($data->total() > 5)
                <div class="my-10">
                    {{ $data->links() }}
                </div>
            @endif
        @endif
    </div>


</div>


