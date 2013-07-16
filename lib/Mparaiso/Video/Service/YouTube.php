<?php

namespace Mparaiso\Video\Service;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Doctrine\Common\Cache\CacheProvider;
use Symfony\Component\EventDispatcher\GenericEvent;

class YouTube implements IVideoProvider
{
    const SMALL = "default";
    const MEDIUM = "medium";
    const HIGH = "high";

    const REQUEST_ERROR = "youtube_http_request_error";

    const REQUEST_SUCCESS = "youtube_http_request_success";

    /**
     * @var array
     */
    protected $params = array(
        "host" => "https://www.googleapis.com/youtube/v3",
        "video_path" => "/videos",
        "snippet" => "snippet",
        "contentDetails" => "contentDetails",
        "statistics" => "statistics",
        "status" => "status",
    );

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var \Doctrine\Common\Cache\CacheProvider
     */
    protected $cacheProvider;

    static $valideYoutubeHosts = array("www.youtube.com", "youtu.be");

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected $eventDispatcher;

    function __construct($apikey, EventDispatcher $eventDispatcher = null, CacheProvider $cacheProvider = null)
    {
        $this->apiKey = $apikey;
        $this->eventDispatcher = $eventDispatcher;
        $this->cacheProvider = $cacheProvider;
    }

    static function isYoutubeUrl($url)
    {
        $predicate = false;
        $request = parse_url($url);
        if (isset($request["host"]) && in_array($request["host"], self::$valideYoutubeHosts)) {
            $predicate = true;
        }
        return $predicate;

    }

    function getIdFromUrl($url)
    {
        $request = parse_url($url);
        if (isset($request["query"])) {
            parse_str($request["query"], $params);
            return $params["v"];
        } elseif (isset($request["path"])) {
            return preg_filter("#^/#", "", $request["path"]);
        }

    }

    public function request($url)
    {
        //check if response is in cache
        if ($this->cacheProvider != null && $this->cacheProvider->contains($url)) {
            return $this->cacheProvider->fetch($url);
        } else {
            // @note @php executer une requete http
            // @note @php créer le querystring
            // @see http://php.net/manual/en/function.http-build-query.php
            $querystring = http_build_query(
                array(
                    'key' => $this->apiKey,
                    'id' => $this->getIdFromUrl($url),
                    'part' => $this->params["snippet"]
                )
            );
            // configure la requete

            $opts = array('http' => array(
                'method' => 'GET',
                'header' => "Content-type: application/x-www-form-urlencoded\r\n" .
                    "Accept: application/json;*/*\r\n",
            ));
            // crée le context
            // @see http://www.php.net/manual/en/context.http.php
            $context = stream_context_create($opts);
            // execute la requète
            $result = @file_get_contents($this->params["host"] . $this->params["video_path"] . "?" . $querystring, false, $context);
            if ($result) {
                $this->dispatch(self::REQUEST_SUCCESS, $result);
                $json = json_decode($result, true);
                // save response in cache.
                if ($this->cacheProvider != null) {
                    $this->cacheProvider->save($url, $json, 1000 * 60 * 60);
                }
                return $json;
            } else {
                $this->dispatch(self::REQUEST_ERROR, $http_response_header);
                return false;
            }
        }
    }


    public function getTitleFromUrl($url)
    {
        $datas = $this->request($url);
        if ($datas) {
            return $datas["items"][0]["snippet"]["title"];
        } else {
            return false;
        }
    }

    public function getDescriptionFromUrl($url)
    {
        $datas = $this->request($url);
        if ($datas) {
            return $datas["items"][0]["snippet"]["description"];
        } else {
            return false;
        }
    }

    public function getThumbnailUrlFromUrl($url, $size = self::MEDIUM)
    {
        $datas = $this->request($url);
        if ($datas) {
            return $datas["items"][0]["snippet"]["thumbnails"][$size]["url"];
        } else {
            return false;
        }
    }

    protected function dispatch($event, $data)
    {
        if ($this->eventDispatcher != null) {
            $this->eventDispatcher->dispatch($event, new GenericEvent($data, array("source" => $this)));
        }
    }
}
