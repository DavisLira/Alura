<x-layout title="Editar Série '{{ $serie->nome }}'">
    <a class="btn btn-dark" href="{{ route('series.index') }}">
        << Voltar</a>
    <x-series.form :action="route('series.update', $serie->id)" :nome="$serie->nome" />
</x-layout>