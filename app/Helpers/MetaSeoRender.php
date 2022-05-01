<?php

namespace App\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;

class MetaSeoRender
{
    private $options = [];
    private $domain = '';
    private $metaTitle;
    private $metaKeyword;
    private $metaDescription;
    private $image = '/images/share.jpeg';
    private $widthImage = '1200';
    private $heightImage = '630';
    private $metaRobots;
    private $suffix;
    private $favicon;

    public static function setMetaSeo($options = [])
    {
        $self = new self();
        $self->options = $options;
        $self->setMetaTitle();
        $self->setMetaKeyword();
        $self->setMetaDescription();
        $self->setImage();
        $self->setMetaRobots();
        $self->setSuffix();
        $self->setFavicon();

        return $self;
    }

    private function setMetaTitle()
    {
        $this->metaTitle = Arr::get($this->options, 'meta_title', '') . $this->suffix;
    }

    private function setMetaKeyword()
    {
        $this->metaKeyword = Arr::get($this->options, 'meta_keyword', '');
    }

    private function setMetaDescription()
    {
        $this->metaDescription = Arr::get($this->options, 'meta_description', '');
    }

    private function setImage()
    {
        $this->image = Arr::get($this->options, 'image', $this->image);
        $this->image = asset($this->image);
    }

    private function setMetaRobots()
    {
        if (app()->environment('production') && !str_contains(request()->getHost(), 'dev')) {
            $this->metaRobots = $this->options['meta_robots'] ?? 'NOINDEX, NOFOLLOW';
        } else {
            $this->metaRobots = 'NOINDEX, NOFOLLOW';
        }
    }

    private function setSuffix()
    {
        $this->suffix = Arr::get($this->options, 'suffix', '');
    }

    private function setFavicon()
    {
        $this->favicon = 'favicon.ico';
    }

    public function renderMetaSeo()
    {
        $meta = '<meta http-equiv="content-language" content="vi-vn" />';
        $meta .= '<title>' . $this->metaTitle . '</title>';
        if ($this->metaKeyword) {
            $meta .= '<meta name="description" content="' . $this->metaDescription . '"/>';
        }
        if ($this->metaKeyword) {
            $meta .= '<meta name="keywords" content="' . $this->metaKeyword . '"/>';
        }
        $meta .= '<meta name="ROBOTS" content="' . $this->metaRobots . '">';
        $meta .= '<meta name="csrf-token" content="' . csrf_token() . '">';
        $meta .= '<meta name="”google”" content="”nositelinkssearchbox”" />';
        $meta .= '<meta name="author" content="Steerlink">';
        $meta .= '<meta name="copyright" content="Copyright © 2021 by ' . $this->domain . '">';

        $meta .= '<meta property="og:site_name" content="' . $this->domain . '">';
        $meta .= '<meta property="og:title" content="' . $this->metaTitle . '">';
        $meta .= '<meta property="og:description" content="' . $this->metaDescription . '">';
        $meta .= '<meta property="og:type" content="website">';
        $meta .= '<meta property="og:locale" content="vi_VN" />';
        $meta .= '<meta property="og:url" content="' . Request::url() . '" />';

        $meta .= '<meta property="og:image" content="' . $this->image . '"/>';
        $meta .= '<meta property="og:image:type" content="image/jpg">';
        $meta .= '<meta property="og:image:width" content="' . $this->widthImage . '">';
        $meta .= '<meta property="og:image:height" content="' . $this->heightImage . '">';

        if (Request::query()) {
            $meta .= '<link rel="canonical" href="' . Request::url() . '" />';
        }
        $meta .= '<link rel="SHORTCUT ICON" href="' . asset($this->favicon) . '">';

        return $meta;
    }
}

