<?php

class ActivateController extends SZ_Breeder
{
    public function __construct()
    {
        parent::__construct();
        $this->import->model("UserModel");
        $this->import->model("ActivationModel");
        $this->import->library("Validation");
    }

    public function post_index()
    {
        $data = new stdClass;
        $data->email = $this->request->post("email");

        // Validate post data
        $this->validation->field("email")->setRules("required|valid_email|max_length[255]");
        if ( ! $this->validation->run($data) )
        {
            return $this->view->set("signin/index");
        }

        // Create activation code
        $activationCode = $this->activationModel->generateActivationCode($data->email);

        // Send mail
        if ( $this->mailModel->sendActivationMail($data->email, $activationCode) === FALSE )
        {
            $this->view->assign("sendMailError", 1);
            return $this->view->set("signin/index");
        }
    }

    public function verify()
    {
        $data = new stdClass;
        $data->code = $this->request->get("code");

        $this->validation->field("code")->setRules("required")->setRules($this->activationModel);
        if ( ! $this->validation->run($data) )
        {
            return $this->view->set("activate/error");
        }

        // Do activation
        $code   = $this->validation->value("code");
        $status = $this->activationModel->activate($code);
        switch ( $result )
        {
            case ActivationModel::SUCCESS:
                return $this->response->redirect("/");

            case ActivationModel::NEED_REGISTER:
                return $this->response->redirect("registration?code=" . $code);

            default:
                return $this->view->set("activate/activate_error");
        }
    }

}

