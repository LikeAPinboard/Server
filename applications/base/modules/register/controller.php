<?php

class RegisterController extends SZ_Breeder
{
    public function __construct()
    {
        parent::__construct();
        $this->import->library("Session");
        $this->import->library("Validation");

        $this->view->assign("title", "Register");
    }

    /**
     * Register index page
     *
     * @public
     */
    public function index()
    {
        if ( ! $this->_checkActivateCache() )
        {
            return $this->response->redirect("signin");
        }

        $this->validation->delimiter("<p class=\"lap-notification error\">", "</p>");
        $this->validation->importRulesXML($this->app->path . "data/validation/register.xml");
    }

    /**
     * Register index page ( POST handler )
     *
     * @public
     */
    public function index_post()
    {
        if ( ! $this->_checkActivateCache() )
        {
            return $this->response->redirect("signin");
        }

        $this->validation->delimiter("<p class=\"lap-notification error\">", "</p>");
        $this->validation->importRulesXML($this->app->path . "data/validation/register.xml");

        $this->validation->run();
    }

    /**
     * Register confirm
     *
     * @public
     */
    public function confirm()
    {
        if ( ! $this->_checkActivateCache() )
        {
            return $this->response->redirect("signin");
        }

        $this->validation->delimiter("<p class=\"lap-notification error\">", "</p>");
        $this->validation->importRulesXML($this->app->path . "data/validation/register.xml");

        if ( ! $this->validation->run() )
        {
            return $this->view->set("register/index");
        }
    }

    /**
     * Register execute
     *
     * @public
     */
    public function regist()
    {
        if ( ! $this->_checkActivateCache() )
        {
            return $this->response->redirect("signin");
        }

        $this->validation->delimiter("<p class=\"lap-input-error\">", "</p>");
        $this->validation->importRulesXML($this->app->path . "data/validation/register.xml");

        if ( ! $this->validation->run() )
        {
            return $this->response->redirect("signin");
        }

        return $this->_doRegist();
    }

    /**
     * Do register process
     *
     * @protected
     * @return mixed
     */
    protected function _doRegist()
    {
        $UserModel = Seezoo::$Importer->model("UserModel");
        $user = array(
            "name"     => $this->validation->value("name"),
            "password" => $this->validation->value("password")
        );
        $activationCode = $this->session->getFlash("activation_signed_code");

        $userID = $UserModel->registerManualAccount($user, $activationCode);
        if ( ! $userID )
        {
            return $this->view->set("register/error");
        }

        $ActivationModel = Seezoo::$Importer->model("ActivationModel");
        $activate        = $ActivationModel->getByCode($activationCode);

        $MailModel = Seezoo::$Importer->model("MailModel");
        $MailModel->sendActivationSuccessMail($user["name"], $activate->email);

        $this->session->set("login_id", $userID);
        $this->session->setFlash("oauth_error", 2);

        return $this->response->redirect("/");
    }

    /**
     * Check signed activation session exists
     *
     * @protected
     * @return bool
     */
    protected function _checkActivateCache()
    {
        $code = $this->session->getFlash("activation_signed_code");
        if ( ! $code )
        {
            return FALSE;
        }

        $ActivationModel = Seezoo::$Importer->model("ActivationModel");
        $activate        = $ActivationModel->getByCode($code);
        if ( ! $activate )
        {
            return FALSE;
        }

        $this->session->keepFlash("activation_signed_code");

        $token = $this->session->generateToken("register_token", TRUE);
        $this->view->assign("register_token", $token);
        $this->view->assign("activate",       $activate);

        return TRUE;
    }
}

