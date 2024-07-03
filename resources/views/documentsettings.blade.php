@extends('master')
@section("app-mid")
<title>paramettres document</title>
<div class="app-main">
    @include('tiles.actions')
    <a href="{{ route('documents.index') }}">
        <img src="{{ asset('left-arrow.svg') }}" alt="Left Arrow" width="40px" height="40px" style="fill: grey;">
    </a>

    <ul class="conversion-rate-list">
        @foreach($documents as $document)
            <li class="list-item">
                <h2 class="platform">{{ $document->intitule_document }}</h2>
                <dl class="ad">
                    <dt class="name">Type</dt>
                    <dd class="value">{{ $document->type_document }}</dd>
                    <dt class="name">Document</dt>
                    <dd class="value">
                        <a href="{{ Storage::url($document->document) }}" target="_blank">View PDF</a>
                    </dd>
                    <dt class="name">Created At</dt>
                    <dd class="value">{{ $document->created_at->format('Y-m-d H:i:s') }}</dd>
                </dl>
            </li>
        @endforeach
    </ul>

    <div class="wrap">
        <table class="conversion-rate-table">
            <thead class="table__head">
                <tr class="table__headers">
                    <th class="header" scope="col">Intitule</th>
                    <th class="header" scope="col">Type</th>
                    <th class="header" scope="col">Document</th>
                    <th class="header" scope="col">Created At</th>
                </tr>
            </thead>
            <tbody class="table__content">
                @foreach($documents as $document)
                    <tr class="table__row">
                        <td class="row__cell">{{ $document->intitule_document }}</td>
                        <td class="row__cell">{{ $document->type_document }}</td>
                        <td class="row__cell">
                            <a href="{{ Storage::url($document->document) }}" target="_blank">View PDF</a>
                        </td>
                        <td class="row__cell">{{ $document->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
@import url("https://fonts.googleapis.com/css2?family=Lato&family=Open+Sans:wght@500;700&display=swap");

* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}

:root {
  font-size: 62.5%;
  --title-font: "Open Sans";
  --data-font: "Lato";
  --dark-background: #121212;
  --dark-secondary-background: #1e1e1e;
  --dark-text: #e0e0e0;
  --dark-border: #333;
  --blue: rgb(51, 131, 255);
  --white: #fff;
}

.page-title {
  margin: 15px 0;
  padding: 0 0.5em;
  font-family: var(--title-font);
  font-weight: 700;
  font-size: clamp(2.6rem, 4vw, 3.2rem);
  text-align: center;
  color: var(--dark-text);
}

.conversion-rate-list {
  width: 80%;
  margin: 25px auto;
  text-align: center;
  list-style: none;
}

.list-item {
  padding-bottom: 2.5em;
  border-radius: 6px;
  box-shadow: 1px 1px 16px var(--dark-border);
  background-color: var(--dark-secondary-background);
  overflow: hidden;
}

.platform {
  background: var(--blue);
  color: var(--white);
  font-family: var(--title-font);
  font-size: 2.4rem;
  font-weight: 500;
  line-height: 2;
}

.name {
  font-family: var(--title-font);
  font-size: 2.4rem;
  font-weight: 500;
  line-height: 2;
}

.value {
  line-height: 1.5;
  font-family: var(--data-font);
  font-size: 2rem;
  color: var(--dark-text);
}

.conversion-rate-table {
  flex-basis: min(80%, 900px);
  display: none;
  padding-bottom: 1em;
  background-color: var(--dark-background);
  border-radius: 6px;
  border-collapse: collapse;
  box-shadow: 1px 1px 16px var(--dark-border);
  overflow: hidden;
}

.table__headers {
  background-color: var(--blue);
}

.header {
  padding: 0.25em 0;
  font-family: var(--title-font);
  font-size: 2.4rem;
  font-weight: 500;
  color: var(--white);
}

.table__row:nth-child(odd) {
  background-color: var(--dark-secondary-background);
}

.table__row:nth-child(even) {
  background-color: var(--dark-background);
}

.row__cell {
  padding: 0.25em 0;
  font-family: var(--data-font);
  font-size: 2rem;
  text-align: center;
  color: var(--dark-text);
}

.row__cell + .row__cell,
.header + .header {
  border-left: 1px solid var(--dark-border);
}

@media (min-width: 600px) {
  .conversion-rate-list {
    display: none;
  }

  .conversion-rate-table {
    display: table;
  }

  .wrap {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 80vh;
  }
}
</style>
@endsection
