@extends('master')

@section('app-mid')
<div class="app-main">
    @include('tiles.actions')
    <ul>
        @foreach($documents as $document)
            <li>
                @if($userRole == 'student' && auth()->user()->hasRole('student'))
                    <a href="{{ Storage::url($document->document) }}" target="_blank">{{ $document->intitule_document }}</a>
                @elseif($userRole == 'teacher' && auth()->user()->hasRole('teacher'))
                    <a href="{{ Storage::url($document->document) }}" target="_blank">{{ $document->intitule_document }}</a>
                @endif
            </li>
        @endforeach
    </ul>
</div>
@endsection
