<x-layout title="Editar Série '{!! $serie->name !!}'">
    <a class="btn btn-dark" href="{{ route('series.index') }}">
        << Voltar</a>
    <x-series.form :action="route('series.update', $serie->id)" :name="$serie->name" :update="true"/>
</x-layout>