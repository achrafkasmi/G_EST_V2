@extends('master')
@section("app-mid")


<div class="app-main">

<div>
    <ul>
        @foreach ($documents as $document)
            @if(auth()->user()->hasRole('student') && $document->type_document == 'student')
                <li>{{ $document->intitule_document }}</li>
                <a href="{{ Storage::url($document->document) }}" target="_blank">View Document</a>
            @elseif (auth()->user()->hasRole('teacher') && $document->type_document == 'teacher')
                <li>{{ $document->intitule_document }}</li>
                <a href="{{ Storage::url($document->document) }}" target="_blank">View Document</a>
            @endif
        @endforeach
    </ul>
</div>
</div>
@endsection
