<?php
namespace App\Blog\Helpers;
use Config;

class ViewHelpers
{
    public static function cdn( $filepath )
    {
        if (Config::get('app.url_static'))
        {
            return Config::get('app.url_static') . $filepath;
        }
        else
        {
            return Config::get('app.url') . $filepath;
        }
    }

    public static function getCdnDomain()
    {
        return Config::get('app.url_static') ?: Config::get('app.url');
    }

    public static function getDomain()
    {
        return Config::get('app.url');
    }

    public static function getUserStaticDomain()
    {
        return Config::get('app.user_static') ?: Config::get('app.url');
    }

    public static function lang($text)
    {
        return str_replace('global.', '', trans('global.'.$text));
    }
    public static function getClipImageUrl($url){
        $index = strripos($url,'.');
        return substr($url, 0, $index) . '-clip' . substr($url, $index, strlen($url) - $index);
    }

}

