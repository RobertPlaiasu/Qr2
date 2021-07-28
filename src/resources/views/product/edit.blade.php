<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
        <script src="https://kit.fontawesome.com/0dfb644902.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="bg-gray-100 w-screen h-screen flex justify-center items-center flex-col">
        @if ( count($errors) > 0)
            @foreach ($errors->all() as $item)
                <h1>{{ $item }}</h1>
            @endforeach
        @endif
            <form action="{{ '/products/' . $product->id }}" method="POST" enctype="multipart/form-data" class="max-w-xl m-4 p-10 bg-white rounded shadow-xl overflow-x-auto">
                @csrf
                @method('PATCH')
                <p class="text-gray-800 font-bold">
                    Editare preparat
                </p>
                <div class="mt-3">
                    <label class="block text-sm text-gray-00" for="name">Nume</label>
                    <input class="w-full py-3 px-4 pr-8 text-gray-700 bg-gray-200 rounded" name="name" type="text" required="" value="{{ old('name') ?? $product->name }}" placeholder="Nume preparat" aria-label="Name">
                </div>
                <div class="mt-3">
                    <label class="block text-sm text-gray-00" for="price">Pret</label>
                    <input class="w-full py-3 px-4 pr-8 text-gray-700 bg-gray-200 rounded" name="price" type="number" step="0.01" value="{{ old('price') ?? $product->price }}" required=""  placeholder="Pretul dorit">
                </div>
                <div class="mt-3">
                    <label class="block text-sm text-gray-00" for="weight">Gramaj</label>
                    <input class="w-full py-3 px-4 pr-8 text-gray-700 bg-gray-200 rounded" name="weight" type="number" required="" value="{{ old('weight') ?? $product->weight }}" placeholder="" aria-label="Name">
                </div>
                <div class="mt-3">
                    <label class="block text-sm text-gray-00" for="ingredients">Incrediente</label>
                    <input class="w-full py-3 px-4 pr-8 text-gray-700 bg-gray-200 rounded" name="ingredients" type="text" value="{{ old('ingredients') ?? $product->ingredients }}" placeholder="oua, lapte..." aria-label="Name">
                </div>
                <div class="mt-3">
                    <label class="block text-sm text-gray-00" for="name">Poza</label>
                    <input class="w-full py-3 px-4 pr-8 text-gray-700 bg-gray-200 rounded" name="picture" type="file">
                </div>

                <div class="mt-3">
                    <label class="block text-sm text-gray-00" for="name">Categorie</label>
                    <select name="category_id" class="w-full py-3 px-4 pr-8 text-gray-700 bg-gray-200 rounded">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            @if ($category->id === $product->category->id)
                                selected
                            @endif
                        >{{ $category->name }}</option>
                    @endforeach
                </select>
                </div>

                <input class="bg-green-800 hover:bg-green-600 text-white font-bold py-2 px-4 border border-gr8eb-700 rounded mt-8" type="submit" value="Adaugă">
            </form>
        </div>
    </body>
</html>
