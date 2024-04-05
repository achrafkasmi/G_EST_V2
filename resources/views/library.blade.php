@extends('master')
@section("app-mid")


<div class="app-main">
    @include('tiles.actions')
    <div class="search-sort-container">
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Search...">
        </div>
        <div class="sorting-container">
            <select id="sorting" style="color: grey;">
                <option value="date_desc" selected>Newest First</option>
                <option value="date_asc">Oldest First</option>
                <option value="initiation">Rapport d'initiation</option>
                <option value="technique">Rapport technique</option>
                <option value="PFE">Rapport PFE</option>
            </select>
        </div>
        <div class="items-per-page-container">
            <label for="itemsPerPage" style="color: grey; font-weight: bold; margin-right:8px;">Items Per Page:</label>
            <select id="itemsPerPage">
                <option value="6">6</option>
                <option value="12">12</option>
                <option value="120">120</option>
            </select>
        </div>
    </div>

    <div class="container" id="data-container">
        @foreach($dossierStages as $dossierStage)
        <a class="box" href="{{ Storage::url($dossierStage->rapport) }}" target="_blank" data-timestamp="{{ $dossierStage->created_at }}" data-type="{{ $dossierStage->type_dossier }}">
            <span class="box__image">
                <img src="{{ Storage::url($dossierStage->image_page_garde)}}" alt="">
            </span>
            <span class="box__title">{{$dossierStage->type_dossier}}-{{$dossierStage->titre_rapport}}</span>
        </a>
        @endforeach
    </div>

    <div class="pagination links" id="pagination-links"></div>
</div>



<style>
    /* Pagination links container styles */
    #pagination-links {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 50px;
        margin-top: 20px;
        padding: 10px;

        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Pagination link styles */
    .pagination-link {
        display: inline-block;
        margin: 0 5px;
        padding: 8px 12px;
        border-radius: 5px;
        background-color: #4caf50;
        color: #fff;
        text-decoration: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .pagination-link:hover {
        background-color: #388e3c;
    }

    /* Active pagination link styles */
    .pagination-link.active {
        background-color: #2e7d32;
    }


    /* sorting and search design*/
    /* .search-sort-container styles */
    .search-sort-container {
        display: flex;
    }

    /* .search-container, .sorting-container, .items-per-page-container styles */
    .search-container,
    .sorting-container,
    .items-per-page-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100px;
        margin-right: 10px;
        margin-left: 30px;
        /* Adjust spacing between containers */
    }

    /* #searchInput, #sorting, #itemsPerPage styles */
    #searchInput,
    #sorting,
    #itemsPerPage {
        --in-out-duration: 0.5s;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 20px;
        outline: none;
        background-color: #fff;
        transition: transform var(--in-out-duration);
    }

    /* .search-container:hover #searchInput, .sorting-container:hover #sorting, .items-per-page-container:hover #itemsPerPage styles */
    .search-container:hover #searchInput,
    .sorting-container:hover #sorting,
    .items-per-page-container:hover #itemsPerPage {
        transform: translate(4px) scale(1.1);
    }

    /* #searchInput:focus, #sorting:focus, #itemsPerPage:focus styles */
    #searchInput:focus,
    #sorting:focus,
    #itemsPerPage:focus {
        border-color: #2F88FF;
        box-shadow: 0 0 5px rgba(47, 136, 255, 0.5);
        background-color: #f2faff;
    }

    /* #searchInput::placeholder, #sorting::placeholder, #itemsPerPage::placeholder styles */
    #searchInput::placeholder,
    #sorting::placeholder,
    #itemsPerPage::placeholder {
        color: #999;
        transition: color 0.3s ease;
    }

    /* #searchInput:focus::placeholder, #sorting:focus::placeholder, #itemsPerPage:focus::placeholder styles */
    #searchInput:focus::placeholder,
    #sorting:focus::placeholder,
    #itemsPerPage:focus::placeholder {
        animation: shake 0.3s ease forwards;
    }

    /* @keyframes shake styles */
    @keyframes shake {
        0% {
            transform: translateX(-2px);
        }

        50% {
            transform: translateX(2px);
        }

        100% {
            transform: translateX(-2px);
        }
    }

    /* lib design*/
    *,
    *::after,
    *::before {
        box-sizing: border-box;
    }

    body,
    html {
        height: 100%;
    }

    .container {
        align-items: top;
        margin-top: -15px;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(12rem, 1fr));
        justify-content: center;
        min-height: 100vh;
        width: 100%;
        gap: 2rem;
        padding: 2rem;
    }

    .box {
        --in-out-duration: 0.5s;
        height: fit-content;
        color: white;
        text-decoration: none;
        border-radius: 0.5rem;
        display: flex;
        flex-direction: column;
        outline: none;
        gap: 1rem;

        &:is(:hover, :focus) {

            & .box__image {
                scale: 1.05;

                &::after {
                    border-color: white;
                    animation-name: scale-in, pulse;
                    animation-duration: var(--in-out-duration), 2s;
                    animation-iteration-count: 1, infinite;
                    animation-delay: 0s, var(--in-out-duration);
                }

                &::before {
                    opacity: 1;
                }
            }
        }
    }

    .box__title {
        font-weight: bold;
    }

    .box__image {
        aspect-ratio: 264 / 352;
        display: flex;
        position: relative;
        transition: scale var(--in-out-duration);
        /* smooths out transition */
        scale: 1.01;
        width: 100%;

        &::before {
            content: "";
            display: block;
            inset: 0;
            background-image: var(--bg-image);
            position: absolute;
            filter: blur(1rem);
            opacity: 0;
            transition: opacity var(--in-out-duration);
            scale: 1.05;
        }

        &::after {
            content: "";
            display: block;
            inset: -0.5rem;
            border: 3px solid transparent;
            border-radius: 1rem;
            opacity: 0;
            position: absolute;

            animation-name: scale-out;
            animation-duration: var(--in-out-duration);
            animation-iteration-count: 1;
            animation-fill-mode: forwards;

            transition-property: border-color;
            transition-duration: var(--in-out-duration);
        }

        & img {
            box-shadow: 0 0 0.25rem rgba(0 0 0 / 25%);
            border-radius: 0.5rem;
            object-fit: cover;
            object-position: center;
            position: absolute;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(15px) saturate(3);
        }
    }

    @keyframes scale-in {
        from {
            scale: 1.1;
            opacity: 0;
        }

        to {
            scale: 1;
            opacity: 1;
        }
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0;
        }
    }

    @keyframes scale-out {
        from {
            scale: 1;
            opacity: 1;
        }

        to {
            scale: 1.1;
            opacity: 0;
        }
    }
</style>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var $dataContainer = $('#data-container');
        var $paginationLinks = $('#pagination-links');
        var $itemsPerPage = $('#itemsPerPage');
        var $searchInput = $('#searchInput');
        var $sorting = $('#sorting');
        var $boxes = $('.box');
        var currentPage = 1;

        function paginateItems(items, page, perPage) {
            var start = (page - 1) * perPage;
            var end = start + perPage;
            return items.slice(start, end);
        }

        function renderItems(items) {
            $dataContainer.empty().append(items);
        }

        function renderPaginationLinks(totalPages) {
            var paginationHtml = '';
            for (var i = 1; i <= totalPages; i++) {
                paginationHtml += '<button class="pagination-link' + (i === currentPage ? ' active' : '') + '" data-page="' + i + '">' + i + '</button>';
            }
            $paginationLinks.html(paginationHtml);
        }

        function updatePagination(filteredItems) {
            var perPage = parseInt($itemsPerPage.val());
            var totalFilteredItems = filteredItems.length;
            var totalPages = Math.ceil(totalFilteredItems / perPage);
            var paginatedItems = paginateItems(filteredItems, currentPage, perPage);
            renderItems(paginatedItems);
            renderPaginationLinks(totalPages);
        }

        function filterAndSortItems() {
            var searchText = $searchInput.val().toLowerCase();
            var sortType = $sorting.val();
            var sortedCategory = '';

            // Determine the sorted category
            switch (sortType) {
                case 'initiation':
                    sortedCategory = "Stage d'initiation";
                    break;
                case 'professionnel':
                    sortedCategory = "Stage professionnel";
                    break;
                case 'technique':
                    sortedCategory = "Stage technique";
                    break;
                case 'PFE':
                    sortedCategory = "PFE";
                    break;
                default:
                    sortedCategory = ''; // If sorting by date, no category filter
            }

            var filteredItems = $boxes.filter(function() {
                var titleText = $(this).find('.box__title').text().toLowerCase();
                var itemCategory = $(this).data('type');

                // Apply category filter if a category is sorted
                if (sortedCategory && itemCategory !== sortedCategory) {
                    return false;
                }

                return titleText.includes(searchText);
            });

            var sortedItems = filteredItems.sort(function(a, b) {
                var aValue, bValue;
                var aType = $(a).data('type');
                var bType = $(b).data('type');
                var aTimestamp = new Date($(a).data('timestamp'));
                var bTimestamp = new Date($(b).data('timestamp'));

                switch (sortType) {
                    case 'date_desc':
                        return bTimestamp - aTimestamp;
                    case 'date_asc':
                        return aTimestamp - bTimestamp;
                    case 'initiation':
                        aValue = aType === "Stage d'initiation" ? 1 : 0;
                        bValue = bType === "Stage d'initiation" ? 1 : 0;
                        break;
                    case 'professionnel':
                        aValue = aType === "Stage professionnel" ? 1 : 0;
                        bValue = bType === "Stage professionnel" ? 1 : 0;
                        break;
                    case 'technique':
                        aValue = aType === "Stage technique" ? 1 : 0;
                        bValue = bType === "Stage technique" ? 1 : 0;
                        break;
                    case 'PFE':
                        aValue = aType === "PFE" ? 1 : 0;
                        bValue = bType === "PFE" ? 1 : 0;
                        break;
                    default:
                        return bTimestamp - aTimestamp;
                }

                return bValue - aValue;
            });

            updatePagination(sortedItems);
        }

        // Initial pagination update
        filterAndSortItems();

        $searchInput.on('keyup', function() {
            filterAndSortItems();
        });

        $sorting.on('change', function() {
            filterAndSortItems();
        });

        $itemsPerPage.on('change', function() {
            currentPage = 1;
            filterAndSortItems();
        });

        $paginationLinks.on('click', '.pagination-link', function() {
            currentPage = parseInt($(this).data('page'));
            filterAndSortItems();
        });
    });

</script>
@endsection