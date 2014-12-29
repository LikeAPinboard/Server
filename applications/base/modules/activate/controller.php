<?php

class ActivateController extends SZ_Breeder
{
    public function __construct()
    {
        parent::__construct();
        $this->import->model("UserModel");
        $this->import->model("ActivationModel");
        $this->import->library("Session");
        $this->import->library("Validation");
    }

    public function verify()
    {
        $data = new stdClass;
        $data->code = $this->request->get("code");

        $this->validation->field("code", "")->setRules("required")->setRules($this->activationModel);
        if ( ! $this->validation->run($data) )
        {
            return $this->view->set("activate/error");
        }

        // Do activation
        $code   = $this->validation->value("code");
        $status = $this->activationModel->activate($code);
        switch ( $status )
        {
            case ActivationModel::SUCCESS:
                return $this->response->redirect("/");

            case ActivationModel::NEED_REGISTER:
                $this->session->setFlash("activation_signed_code", $code);
                return $this->response->redirect("register");

            case ActivationModel::ALREADY:
                return $this->view->set("activate/already");

            default:
                return $this->view->set("activate/error");
        }
    }

}

