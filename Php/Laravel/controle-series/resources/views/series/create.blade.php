<x-layout title="Nova Série">
    <a class="btn btn-dark" href="{{ route('series.index') }}">
        << Voltar</a>
    <x-series.form :action="route('series.store')" :name="old('name')" :update="false"/>
</x-layout>