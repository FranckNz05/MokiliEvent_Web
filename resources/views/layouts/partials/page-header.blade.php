<!-- Page Header Start -->
<div class="page-header py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                @if(isset($breadcrumbs))
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                            @foreach($breadcrumbs as $breadcrumb)
                                @if($loop->last)
                                    <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['text'] }}</li>
                                @else
                                    <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['text'] }}</a></li>
                                @endif
                            @endforeach
                        </ol>
                    </nav>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->
