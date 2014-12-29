<?php

class SigninAjax extends SZ_Breeder
{
    public function __construct()
    {
        parent::__construct();
        $this->import->library("Validation");
    }

    /**
     * POST /signin/index handler
     *
     * @pubic
     * @return Response
     */
    public function index_post()
    {
        $data = new stdClass;
        $data->email = $this->request->post("email");

        // Validate post data
        $this->validation->delimiter("", "");
        $this->validation->field("email", "Email")->setRules("required|valid_email|max_length[255]");
        if ( ! $this->validation->run($data) )
        {
            return $this->_sendJson(400, $this->validation->error("email"));
        }

        $ActivationModel = Seezoo::$Importer->model("ActivationModel");
        $MailModel       = Seezoo::$Importer->model("MailModel");

        // Create activation code
        $activationCode = $ActivationModel->generateActivationCode($data->email);
        if ( $activationCode === ActivationModel::EXISTS )
        {
            return $this->_sendJson(400, "Inputed email is already exists.");
        }

        // Send mail
        if ( ! $MailModel->sendActivationMail($data->email, $activationCode) === FALSE )
        {
            return $this->_sendJson(400, "Sorry, our mail server has a problem.");
        }

        return $this->_sendJson(200, "Activation mail sended. Check your mail and do activate");
    }

    /**
     * Make JSON Response
     *
     * @protected
     * @param int $code
     * @param string $message
     * @return Response
     */
    protected function _sendJson($code, $message)
    {
        $resp          = new stdClass;
        $resp->code    = $code;
        $resp->message = $message;

        return $this->response->setJsonBody($resp);
    }
}
