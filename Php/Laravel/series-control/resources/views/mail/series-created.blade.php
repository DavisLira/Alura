@component('mail::message')
    
# {{ $seriesName }} foi criada.

A série {{ $seriesName }} com {{ $seasonsQty }} temporadas e {{ $episodesQty }} episódios por temporada foi criada.

Acesse aqui:
@component('mail::button', ['url' => route('seasons.index', $seriesId)])
    Ver série
@endcomponent

@endcomponent