<x-layout title="Nova Série">

    <form action="{{ route('series.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row mb-3">
        <div class="col-8">
            <label for="name" class="form-label">Nome:</label>
            <input type="text" 
                autofocus
                id="name" 
                name="name" 
                class="form-control"
                value="{{ old('name') }}">
        </div>

        <div class="col-2">
            <label for="seasonsQty" class="form-label">N° temporadas:</label>
            <input type="text" 
                id="seasonsQty" 
                name="seasonsQty" 
                class="form-control"
                value="{{ old('seasonsQty') }}">
        </div>

        <div class="col-2">
            <label for="episodesPerSeason" class="form-label">Eps / temp:</label>
            <input type="text" 
                id="episodesPerSeason" 
                name="episodesPerSeason" 
                class="form-control"
                value="{{ old('episodesPerSeason') }}">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <label for="cover" class="form-label">Capa</label>
            <input type="file" id="cover" name="cover" class="form-control" accept="image/*">
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary">Adicionar</button>
</form>
</x-layout>