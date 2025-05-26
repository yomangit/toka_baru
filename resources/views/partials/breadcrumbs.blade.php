@unless ($breadcrumbs->isEmpty())
<div class="breadcrumbs font-semibold font-serif">

    <ul class="m-0 text-[10px]">
        @foreach ($breadcrumbs as $breadcrumb)

            @if (!is_null($breadcrumb->url) && !$loop->last)
                <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
            @else
                <li class="font-bold text-[#40A2E3] breadcrumb-item active">{{ $breadcrumb->title }}</li>
            @endif
        @endforeach
    </ul>
</div>
@endunless