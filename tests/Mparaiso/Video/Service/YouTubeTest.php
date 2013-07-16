<?php

namespace Mparaiso\Video\Service;

use \Silex\WebTestCase;
use \Symfony\Component\HttpKernel\HttpKernel;

class YouTubeServiceTest extends WebTestCase
{
    /**
     * @var Youtube
     */
    protected $_service;

    /**
     * Creates the application.
     *
     * @return HttpKernel
     */
    public function createApplication()
    {
        $app = \Bootstrap::getApp();
        $this->_service = $app["video.service.youtube"];
        return $app;

    }

    function urlProvider()
    {
        return array(
            array(
                "http://youtu.be/CebChwpIPa8",
                "CebChwpIPa8"
            ),
            array(
                "http://www.youtube.com/watch?v=CebChwpIPa8",
                "CebChwpIPa8"
            ),
            array(
                "http://www.youtube.com/watch?v=FbSO3tQFA0s",
                "FbSO3tQFA0s"
            )
        );
    }

    /**
     * @dataProvider urlProvider
     * @param $urls
     */
    function testGetIdFromUrl($url, $id)
    {
        $result = $this->_service->getIdFromUrl($url);
        $this->assertEquals($id, $result);
    }

    /**
     * @dataProvider urlProvider
     * @param $url
     */
    function testGetThumbnailUrlFromUrl($url, $id)
    {
        //$id = $this->_service->getIdFromUrl($url);
        $expected = "https://i1.ytimg.com/vi/$id/mqdefault.jpg";
        $actual = $this->_service->getThumbnailUrlFromUrl($url);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider urlProvider
     * @param $url
     */
    function testIsYoutubeUrl($url)
    {
        $this->assertTrue(YouTube::isYoutubeUrl($url));
    }
}
