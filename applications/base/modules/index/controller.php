<?php

class IndexController extends SZ_Breeder
{
    public function __construct()
    {
        parent::__construct();

        $this->import->model("UserModel");
        $this->import->library("Session");

        $this->view->assign("title", "Like A Pinboard");
    }

    public function index()
    {
        $id   = $this->userModel->getUserID();;
        $user = $this->userModel->getUserByID($id);
        $auth = $this->session->keepFlash("oauth_error");

        return $this->response->redirect("u:{$user->name}");
    }
}

