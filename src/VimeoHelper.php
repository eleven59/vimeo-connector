<?php namespace Eleven59\VimeoConnector;

class VimeoHelper
{
    public static function getEmbedUrl($url)
    {
        return self::getEventEmbedUrl($url) ?: self::getVideoEmbedUrl($url);
    }

    public static function getVideoEmbedUrl($url)
    {
        $id = self::getVideoIdFromUrl($url);
        if (!empty ($id))
        {
            return "https://player.vimeo.com/video/{$id}";
        }

        return false;
    }

    public static function getEventEmbedUrl($url)
    {
        $id = self::getEventIdFromUrl($url);
        if (!empty ($id))
        {
            return "https://vimeo.com/event/{$id}/embed";
        }

        return false;
    }

    public static function getIdFromUrl($url)
    {
        return self::getEventIdFromUrl($url) ?: self::getVideoIdFromUrl($url);
    }

    public static function getVideoIdFromUrl($url)
    {
        $regs = [];
        $id = false;

        if (is_numeric($url))
        {
            return $url;
        }

        if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $url, $regs))
        {
            if(!empty($regs[3]))
            {
                $id = $regs[3];
            }
        }

        return $id;
    }

    public static function getEventIdFromUrl($url)
    {
        $regs = [];
        $id = false;

        if (is_numeric($url))
        {
            return $url;
        }

        if (preg_match ('/vimeo\.com\/event\/(\d+)/', $url, $regs))
        {
            if(!empty($regs[1]))
            {
                $id = $regs[1];
            }
        }

        return $id;
    }
}
