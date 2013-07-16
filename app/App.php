<?php
/**
 * Video Portfolio
 */

class App extends Silex\Application
{
    function __construct(array $params = array())
    {
        parent::__construct($params);
        $this->register(new Config);
    }
}