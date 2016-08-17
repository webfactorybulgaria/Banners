@if (!empty($banners))
    <ul class="small-block-grid-2 productBanners">
        @foreach($banners as $banner)
            <li>
                <div class="bannerImage">
                    @if(!empty($banner->title))
                        <h2>{{ $banner->title }}</h2>
                    @endif
                    {{ $banner->summary }}
                    <a href="{{ $banner->link }}" target="_self">
                        <img alt="" src="{{ $banner->image }}" border="0" width="205" height="250">
                    </a>
                </div>
                {!! $banner->body !!}
            </li>
        @endforeach
    </ul>
@endif