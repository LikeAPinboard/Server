<?php

class ResignationController extends SZ_Breeder
{
    public function __construct()
    {
        parent::__construct();
        $this->import->library("Session");
        $this->view->assign("title", "Resignation completed");
    }

    public function index()
    {
        if ( ! $this->session->getFlash("user_removed") )
        {
            return $this->response->redirect("/");
        }
    }
}
