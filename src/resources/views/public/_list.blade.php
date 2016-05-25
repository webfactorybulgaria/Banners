<ul class="list-banners">
    @foreach ($items as $banner)
    @include('banners::public._list-item')
    @endforeach
</ul>
