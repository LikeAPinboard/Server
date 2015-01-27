<?php

class SubscribeController extends SZ_Breeder
{
    public function __construct()
    {
        parent::__construct();
        $this->import->library("Session");
        $this->import->model("UserModel");
    }

    public function index_post()
    {
        $userID  = $this->request->post("userId");
        $emailID = $this->request->post("emailId");
        $cronID  = $this->request->post("cronId");
        $tag     = $this->request->post("tag");
        $user    = $this->userModel->getUserByID($userID);
        $token   = $this->request->post("token");

        if ( ! $user )
        {
            return Signal::finished;
        }
        $path = ( $tag ) ? "u:{$user->name}?t={$tag}" : "u:{$user->name}";

        if ( $this->session->checkToken("user_token", $token, TRUE) )
        {
            $subscribed = ( $this->userModel->subscribeUser($userID, $emailID, $cronID, $tag) ) ? 0 : 1;
            $this->session->setFlash("user_subscribed", $subscribed);
        }
        else
        {
            echo "Token Error";
            return Signal::finished;
        }

        return $this->response->redirect($path);
    }
}

