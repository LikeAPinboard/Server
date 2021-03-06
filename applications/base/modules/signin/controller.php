<?php

class SigninController extends SZ_Breeder
{
    public function __construct()
    {
        parent::__construct();

        $this->import->library("oauth");
        $this->import->library("session");
        $this->import->model("UserModel");
        $this->import->library("Validation");

        $this->view->assign("title", "Sign in");
    }

    public function index()
    {
        if ( $this->userModel->isLoggedIn() )
        {
            return $this->response->redirect("index");
        }

        $token = $this->session->generateToken("signin_token", TRUE);
        $this->view->assign("signin_token", $token);
    }

    public function facebook()
    {
        $this->oauth->service("facebook", array(
            "application_id"     => $this->env->getConfig("facebook_application_id"),
            "application_secret" => $this->env->getConfig("facebook_application_secret"),
            "callback_url"       => page_link("signin/facebook_callback")
        ));

        if ( $this->oauth->auth2() )
        {
            return $this->response->redirect("index");
        }

        return Signal::failed;
    }

    public function facebook_callback()
    {
        $this->oauth->service("facebook", array(
            "application_id"     => $this->env->getConfig("facebook_application_id"),
            "application_secret" => $this->env->getConfig("facebook_application_secret"),
            "callback_url"       => page_link("signin/facebook_callback")
        ));

        // Authnticate failed
        if ( ! $this->oauth->auth2() )
        {
            $this->session->setFlash('oauth_error', 1);
            return $this->response->redirect("index");
        }

        // Get authorized user
        $user = $this->oauth->getUser();
        if ( ! $user )
        {
            $this->session->setFlash('oauth_error', 1);
            return $this->response->redirect("index");
        }

        $token = $this->oauth->get("access_token");
        $id    = $user->id;
        $name  = ( isset($user->username) ) ? $user->username : $user->name;

        $userID = $this->userModel->registerWithFacebook($id, $name, $token);
        if ( $userID )
        {
            $this->session->setFlash('oauth_error', 0);
            $this->session->set("login_id", $userID);
            return $this->response->redirect("index");
        }

        return Signal::failed;
    }

    public function github()
    {
        $this->oauth->service("github", array(
            "client_id"          => $this->env->getConfig("github_client_id"),
            "application_secret" => $this->env->getConfig("github_application_secret"),
            "callback_url"       => page_link("signin/github_callback")
        ));

        if ( $this->oauth->auth2() )
        {
            return $this->response->redirect("index");
        }

        return Signal::failed;
    }

    public function github_callback()
    {
        $this->oauth->service("github", array(
            "client_id"          => $this->env->getConfig("github_client_id"),
            "application_secret" => $this->env->getConfig("github_application_secret"),
            "callback_url"       => page_link("signin/github_callback")
        ));

        // Authnticate failed
        if ( ! $this->oauth->auth2() )
        {
            $this->session->setFlash('oauth_error', 1);
            return $this->response->redirect("index");
        }

        // Get authorized user
        $user = $this->oauth->getUser();
        if ( ! $user )
        {
            $this->session->setFlash('oauth_error', 1);
            return $this->response->redirect("index");
        }

        $token = $this->oauth->get("access_token");
        $id    = $user->id;
        $name  = $user->login;

        $userID = $this->userModel->registerWithGithub($id, $name, $token);
        if ( $userID )
        {
            $this->session->setFlash('oauth_error', 0);
            $this->session->set("login_id", $userID);
            return $this->response->redirect("index");
        }

        return Signal::failed;
    }

    public function twitter()
    {
        $this->oauth->service("twitter", array(
            "consumer_key"    => $this->env->getConfig("twitter_consumer_key"),
            "consumer_secret" => $this->env->getConfig("twitter_consumer_secret"),
            "callback_url"    => page_link("signin/twitter_callback")
        ));

        if ( $this->oauth->auth() )
        {
            $this->_twitterLogin();
            return $this->response->redirect("index");
        }

        return Signal::failed;
    }

    public function twitter_callback()
    {
        $this->oauth->service("twitter", array(
            "consumer_key"    => $this->env->getConfig("twitter_consumer_key"),
            "consumer_secret" => $this->env->getConfig("twitter_consumer_secret"),
            "callback_url"    => page_link("signin/twitter_callback")
        ));

        if ( ! $this->oauth->auth() )
        {
            $this->session->setFlash('oauth_error', 1);
            return $this->response->redirect("index");
        }

        // Get authorized user
        $user = $this->oauth->getUser();
        if ( ! $user )
        {
            $this->session->setFlash('oauth_error', 1);
            return $this->response->redirect("index");
        }

        $token  = $this->oauth->get("oauth_token");
        $id     = $user->id;
        $name   = $user->screen_name;

        $userID = $this->userModel->registerWithTwitter($id, $name, $token);
        if ( $userID > 0 )
        {
            $this->session->setFlash('oauth_error', 0);
            $this->session->set("login_id", $userID);
            return $this->response->redirect("index");
        }

        return Signal::failed;
    }

    public function account()
    {
        $account = new stdClass;
        $account->email    = $this->request->post("email");
        $account->password = $this->request->post("password");

        $this->validation->delimiter("<p class=\"lap-notification error\">", "</p>");
        $this->validation->importRulesXML($this->app->path . "data/validation/signin.xml");

        $token = $this->request->post("signin_token");
        if ( ! $this->session->checkToken("signin_token", $token, TRUE) )
        {
            return $this->response->redirect("signin");
        }

        if ( ! $this->validation->run($account) )
        {
            $token = $this->session->generateToken("signin_token", TRUE);
            $this->view->assign("signin_token", $token);
            return $this->view->set("signin/index");
        }

        $user = $this->userModel->loginWithAccount($account);
        if ( ! $user )
        {
            $token = $this->session->generateToken("signin_token", TRUE);
            $this->view->assign("signin_token", $token);
            $this->view->assign("signin_error", 1);
            return $this->view->set("signin/index");
        }

        $this->session->set("login_id", $user->id);
        return $this->response->redirect("/");
    }

}
