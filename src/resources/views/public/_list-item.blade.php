<li>
    <a href="{{ route($lang.'.banners.slug', $banner->slug) }}" title="{{ $banner->title }}">
        {!! $banner->title !!}
        {!! $banner->present()->thumb(null, 200) !!}
    </a>
</li>
