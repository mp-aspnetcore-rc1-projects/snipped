<?php

namespace Mparaiso\Video\Service;

interface IVideoProvider
{

    function getIdFromUrl($url);


    function getTitleFromUrl($url);


    function getDescriptionFromUrl($url);


    function getThumbnailUrlFromUrl($url);


}