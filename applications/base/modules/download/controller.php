<?php

class DownloadController extends SZ_Breeder
{
    public function __construct()
    {
        parent::__construct();
        $this->import->library("Session");
        $this->import->model("UserModel");
    }

    public function index()
    {
        return $this->response->redirect("index");
    }

    public function rc()
    {
        $id   = $this->session->get("login_id");
        $user = $this->userModel->getUserByID($id);

        $rcFile  = "{\n";
        $rcFile .= "  \"url\":\"" . $this->env->getConfig("lap_api_server") . "\",\n";
        $rcFile .= "  \"token\":\"" . $user->token . "\"\n";
        $rcFile .= "}";

        return $this->response->download($rcFile, "user.laprc", TRUE);
    }

    public function extension()
    {
        return $this->response->download(SZPATH . "products/LikeAPinboard.crx", "LikeAPinboard.crx");
    }

    public function workflow()
    {
        return $this->response->download(SZPATH . "products/LikeAPinboard.alfredworkflow", "LikeAPinboard.alfredworkflow");
    }
}


