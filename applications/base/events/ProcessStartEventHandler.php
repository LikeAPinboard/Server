<?php

class ProcessStartEventHandler
{
    private $whiteListSegment = array(
        "signin",
        "activate",
        "register"
    );

    public function userRouting()
    {
        $segment = Seezoo::getRequest()->segment(1);
        if ( preg_match("/\Au:(.+)\Z/", $segment, $match) )
        {
            $buffer = Application::fork(SZ_MODE_MVC, "user/{$match[1]}");
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
