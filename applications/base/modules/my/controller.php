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

        $this->view->assign("email_error",    $this->session->getFlash("email_error"));
        $this->view->assign("username_error", $this->session->getFlash("username_error"));
        $this->view->assign("delete_error",   $this->session->getFlash("delete_error"));
        $this->view->assign("password_error", $this->session->getFlash("password_error"));
        $this->view->assign("token_error",    $this->session->getFlash("token_error"));

        $this->view->assign("account_token", $this->session->generateToken("account_token", TRUE));
    }

    protected function checkToken($name)
    {
        $token = $this->request->post($name);
        return $this->session->checkToken($name, $token, TRUE);
    }

    public function change_username_post()
    {
        if ( ! $this->checkToken("account_token") )
        {
            $this->session->setFlash("token_error", 1);
            return $this->response->redirect("my/account");
        }

        $post = new stdClass;
        $post->username = $this->request->post("username");

        $Validation = Seezoo::$Importer->library("Validation");
        $Validation->delimiter("", "");
        $Validation->field("username", "UserName")->setRules("required|max_length[255]");

        if ( ! $Validation->run($post) )
        {
            $this->session->setFlash("username_error", $Validation->error("username"));
            return $this->response->redirect("my/account");
        }

        if ( ! $this->userModel->updateUserName($post->username) )
        {
            $this->session->setFlash("username_error", 2);
            return $this->response->redirect("my/account");
        }

        $this->session->setFlash("username_error", 0);
        return $this->response->redirect("my/account");
    }

    public function delete_account_post()
    {
        if ( ! $this->checkToken("account_token") )
        {
            $this->session->setFlash("token_error", 1);
            return $this->response->redirect("my/account");
        }

        $id   = $this->userModel->getUserID();
        $user = $this->userModel->getUserByID($id);
        if ( ! $this->userModel->deleteAccountData() )
        {
            $this->session->setFlash("delete_error", 1);
            return $this->response->redirect("my/account");
        }

        if ( ! empty($user->email) )
        {
            $MailModel = Seezoo::$Importer->model("MailModel");
            $Mail->sendResignationMail($user->email);
        }
        $this->userModel->logout();
        $this->session->remove("facebook");
        $this->session->remove("github");
        $this->session->remove("twitter");
        $this->session->setFlash("user_removed", 1);

        return $this->response->redirect("resignation");
    }

    public function email()
    {
        if ( ! $this->checkToken("account_token") )
        {
            $this->session->setFlash("token_error", 1);
            return $this->response->redirect("my/account");
        }

        $post = new stdClass;
        $post->email = $this->request->post("email");

        $Validation = Seezoo::$Importer->library("Validation");
        $Validation->delimiter("", "");
        $Validation->field("email", "Email")->setRules("required|valid_email|max_length[255]");

        if ( ! $Validation->run($post) )
        {
            $this->session->setFlash("email_error", $Validation->error("email"));
            return $this->response->redirect("my/account");
        }

        $userID          = $this->userModel->getUserID();
        $ActivationModel = Seezoo::$Importer->model("ActivationModel");
        $MailModel       = Seezoo::$Importer->model("MailModel");

        // Create activation code
        $activationCode = $ActivationModel->generateActivationCode($post->email, $userID);
        if ( $activationCode === ActivationModel::EXISTS )
        {
            $this->session->setFlash("email_error", "Your email is already exists.");
            return $this->response->redirect("my/account");
        }

        // Send mail
        if ( $MailModel->sendActivationMail($data->email, $activationCode) === FALSE )
        {
            $this->session->setFlash("email_error", 0);
            return $this->response->redirect("my/account");
        }

        $this->session->setFlash("email_error", "Mail send error, sorry.");
        return $this->response->redirect("my/account");
    }

    public function password_post()
    {
        if ( ! $this->checkToken("account_token") )
        {
            $this->session->setFlash("token_error", 1);
            return $this->response->redirect("my/account");
        }

        $password = $this->request->post("password");
        $state    = ( $this->userModel->updatePassword($password) ) ? 0 : 1;

        $this->session->setFlash("password_error", $state);
        return $this->response->redirect("my/account");
    }

}

