<ol class="breadcrumb">
    @foreach($breadcrumbs as $breadcrumb)
        <li>
            <a href="{{ $breadcrumb->url }}">
                {{ $breadcrumb->title }}
            </a>
        </li>
    @endforeach
</ol>