<?php namespace Eleven59\VimeoConnector;

class VimeoConnector
{
    public static function connect()
    {
        $token = session('vimeo_token');
        if(empty($token)) {
            $token = self::getVimeoToken();
            session(['vimeo_token' => $token]);
        }
    }

    public static function getVimeoToken()
    {
        $key = env('VIMEO_KEY', false);
        $secret = env('VIMEO_SECRET', false);
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.vimeo.com/oauth/authorize/client',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{"grant_type": "client_credentials", "scope": "public"}',
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic ' . base64_encode("$key:$secret"),
                'Content-Type: application/json'
            ],
        ]);

        $response = json_decode(curl_exec($curl));
        curl_close($curl);

        if(!empty($response->access_token))
        {
            return $response->access_token;
        }
    }

    public static function getInfo($vimeoId)
    {
        self::connect();

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.vimeo.com/videos/' . $vimeoId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . session('vimeo_token')
            ],
        ]);

        $response = json_decode(curl_exec($curl));
        curl_close($curl);

        return $response;
    }

    public static function getStills($vimeoId)
    {
        $video = self::getInfo($vimeoId);
        if(!empty($video->pictures) && !empty($video->pictures->sizes))
        {
            return $video->pictures->sizes;
        }
        return [];
    }

    public static function getCover($vimeoId)
    {
        $cover = false;
        $video = self::getInfo($vimeoId);
        if(!empty($video) && !empty($video->pictures) && !empty($video->pictures->sizes))
        {
            list($w, $h) = [$video->width, $video->height];
            foreach ($video->pictures->sizes as $photo)
            {
                if($w == $photo->width && $h == $photo->height) {
                    $cover = $photo->link;
                }
            }
        }
        return $cover;
    }
}
