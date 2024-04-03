<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Rit Boeken') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('calculate-distance') }}" method="POST">
                        @csrf
                        <label for="start">Start Adres:</label>
                        <input type="text" id="start" name="start" required class="mt-1 block w-full" style="color: black;"><br>
                        <label for="end">Eind Adres:</label>
                        <input type="text" id="end" name="end" required class="mt-1 block w-full" style="color: black;"><br><br>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Bereken Afstand
                        </button>
                    </form>
                    @if (session('result'))
                        <div class="mt-4">
                            <strong>Resultaat:</strong> {{ session('result') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="mt-4 text-red-500">
                            <strong>Fout:</strong> {{ $errors->first() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
