<?php

class ProcessStartEventHandler
{
    private $whiteListSegment = array(
        "signin",
        "activate",
        "register",
        "resignation"
    );

    public function userRouting()
    {
        $request = Seezoo::getRequest();
        $seg     = 1;
        $segment = $request->segment(1);
        if ( preg_match("/\Au:(.+)\Z/", $request->segment($seg), $match) )
        {
            $route = "user/{$match[1]}";
            while ( $tag = $request->segment(++$seg) )
            {
                if ( preg_match("/\At:(.+)\Z/", $tag, $m) )
                {
                    $route .= "/{$m[1]}";
                }
            }

            $buffer = Application::fork(SZ_MODE_MVC, $route);
            exit($buffer);
        }
    }

    public function checkLogin()
    {
        $session = Seezoo::$Importer->library("session");
        if ( ! $session->get("login_id") )
        {
            $segment = Seezoo::getRequest()->segment(1);
            if ( ! in_array($segment, $this->whiteListSegment) )
            {
                $buffer = Application::fork(SZ_MODE_MVC, "signin");
                exit($buffer);
            }
        }
    }
}
