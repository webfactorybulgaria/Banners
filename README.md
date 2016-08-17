# Banners

## Frontend
Render a list of banners on the frontend like this:
{!! Banners::render('bannerplace-slug') !!}

The default view is banners::public._banners but you can override this per bannerplace by creating a view banners::public._banners-<bannerplace-slug>

This module is part of [Admintool4](https://github.com/webfactorybulgaria/Base), a multilingual CMS based on Laravel 5.
