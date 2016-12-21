<?php

class Core 
{
    public function run()
    {
        $currentController = "homeController";
        $currentAction = "index";
        $params = array();
        //$url = 'nada';
        if (isset($_SERVER['REDIRECT_URL'])) 
        {
            $url = $_SERVER['REDIRECT_URL'];
            $url = explode("/", $url);
            array_shift($url);
            $currentController = $url[0]."Controller";
            array_shift($url);
            if (isset($url[0])) 
            {
                $currentAction = $url[0];
                array_shift($url);
            }
            if (count($url) > 0) 
            {
                $params = $url;
            }
        }
        $c = new $currentController();
        call_user_func_array(array($c, $currentAction), $params);
    }
}