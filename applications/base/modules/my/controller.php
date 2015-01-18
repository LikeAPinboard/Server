<?php

class MyController extends SZ_Breeder
{
    public function __construct()
    {
        parent::__construct();

        $this->import->model("UserModel");
        $this->import->library("Session");

        $id   = $this->userModel->getUserID();
        $user = $this->userModel->getUserByID($id);
        $this->view->assign("user",  $user);
        $this->view->assign("title", "MyPage");
    }

    public function index()
    {
        $auth = $this->session->getFlash("oauth_error");

        $this->view->assign("auth_result", $auth);
    }

    public function tools()
    {
    }

    public function socials()
    {
    }

    public function account()
    {
        $emails = $this->userModel->getUserEmails($this->userModel->getUserID());
        $this->view->assign("emails", $emails);
        $this->view->assign("overlay", TRUE);
        $this->view->assign("modals", array("my/account_modal"));

        $this->view->assign("account_token", $this->session->generateToken("account_token", TRUE));
    }

}

