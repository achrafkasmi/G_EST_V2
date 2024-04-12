@extends('master')
@section("app-mid")

<div class="app-main">
    @include('tiles.actions')

    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search...">
    </div>

    <div class="document-list" id="data-container">
        @foreach ($documents as $document)
            @if(auth()->user()->hasRole('student') && $document->type_document == 'student')
                <div class="card">
                    <h3>{{ $document->intitule_document }}</h3>
                    <a href="{{ Storage::url($document->document) }}" target="_blank" class="view-document btn">View Document</a>
                </div>
            @elseif (auth()->user()->hasRole('teacher') && $document->type_document == 'teacher')
                <div class="card">
                    <h3>{{ $document->intitule_document }}</h3>
                    <a href="{{ Storage::url($document->document) }}" target="_blank" class="view-document btn">View Document</a>
                </div>
            @endif
        @endforeach
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var $searchInput = $('#searchInput');
        var $cards = $('.card');

        function filterItems() {
            var searchText = $searchInput.val().toLowerCase();

            $cards.each(function() {
                var titleText = $(this).find('h3').text().toLowerCase();
                if (titleText.includes(searchText)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        $searchInput.on('keyup', function () {
            filterItems();
        });
    });
</script>

@endsection

<style>

   

</style>


