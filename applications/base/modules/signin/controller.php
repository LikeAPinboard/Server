<?php

class SigninController extends SZ_Breeder
{

    const SOCIAL_TYPE_GITHUB   = "github";
    const SOCIAL_TYPE_TWITTER  = "twitter";
    const SOCIAL_TYPE_FACEBOOK = "facebook";

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
            return $this->response->redirect("/");
        }

        $token = $this->session->generateToken("signin_token", TRUE);
        $this->view->assign("signin_token", $token);
    }

    public function facebook()
    {
        $this->oauth->service(self::SOCIAL_TYPE_FACEBOOK, array(
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
        $this->oauth->service(self::SOCIAL_TYPE_FACEBOOK, array(
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

        $token  = $this->oauth->get("access_token");
        $id     = $user->id;
        $name   = ( isset($user->username) ) ? $user->username : $user->name;
        $image  = ( isset($user->image) ) ? $user->image : "";
        $userID = $this->userModel->registerWithFacebook($id, $name, $token, $image);

        return $this->registerResult($userID, self::SOCIAL_TYPE_FACEBOOK, $token, $id, $name);
    }

    public function github()
    {
        $this->oauth->service(self::SOCIAL_TYPE_GITHUB, array(
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
        $this->oauth->service(self::SOCIAL_TYPE_GITHUB, array(
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

        $token  = $this->oauth->get("access_token");
        $id     = $user->id;
        $name   = $user->login;
        $image  = ( isset($user->avatar_url) ) ? $user->avatar_url : "";
        $userID = $this->userModel->registerWithGithub($id, $name, $token, $image);

        return $this->registerResult($userID, self::SOCIAL_TYPE_GITHUB, $token, $id, $name);
    }

    public function twitter()
    {
        $this->oauth->service(self::SOCIAL_TYPE_TWITTER, array(
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
        $this->oauth->service(self::SOCIAL_TYPE_TWITTER, array(
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
        $image  = ( isset($user->profile_image_url) ) ? $user->profile_image_url : "";
        $userID = $this->userModel->registerWithTwitter($id, $name, $token, $image);

        return $this->registerResult($userID, self::SOCIAL_TYPE_TWITTER, $token, $id, $name);
    }

    protected function registerResult($userID, $type, $token, $id, $name)
    {
        if ( $userID > 0 )
        {
            $this->session->setFlash('oauth_error', 0);
            $this->session->set("login_id", $userID);
            return $this->response->redirect("index");
        }
        else if ( $userID === -1 )
        {
            $this->session->setFlash("user_duplicate", 1);
            $this->session->setFlash("oauth_token",    $token);
            $this->session->setFlash("social_id",      $id);
            $this->session->setFlash("social_name",    $name);
            $this->session->setFlash("social_type",    $type);

            return $this->response->redirect("signin/duplicate");
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

    public function duplicate()
    {
        if ( ! $this->session->getFlash("user_duplicate") )
        {
            return $this->response->redirect("signin");
        }

        $this->session->keepFlash("user_duplicate");
        $this->session->keepFlash("oauth_token");
        $this->session->keepFlash("social_id");
        $this->session->keepFlash("social_name");
        $this->session->keepFlash("social_type");

        $token = $this->session->getFlash("oauth_token");
        $id    = $this->session->getFlash("social_id");
        $name  = $this->session->getFlash("social_name");
        $type  = $this->session->getFlash("social_type");

        $this->view->assign("oauth_token", $token);
        $this->view->assign("social_id",   $id);
        $this->view->assign("social_name", $name);
        $this->view->assign("social_type", $type);

        $this->view->assign("overlay", TRUE);
        $this->view->assign("modals", array("signin/username_modal"));
    }

    // @POST
    public function change_username_post()
    {
        $token  = $this->request->post("oauth_token");
        $id     = $this->request->post("social_id");
        $name   = $this->request->post("username");
        $type   = $this->request->post("social_type");

        switch ( $type )
        {
            case self::SOCIAL_TYPE_TWITTER:
                $userID = $this->userModel->registerWithTwitter($id, $name, $token);
                break;
            case self::SOCIAL_TYPE_GITHUB:
                $userID = $this->userModel->registerWithGithub($id, $name, $token);
                break;
            case self::SOCIAL_TYPE_FACEBOOK:
                $userID = $this->userModel->registerWithFacebook($id, $name, $token);
                break;
            default:
                return $this->response->redirect("signin");
        }

        if ( $userID > 0 )
        {
            $this->session->setFlash('oauth_error', 0);
            $this->session->set("login_id", $userID);
            return $this->response->redirect("index");
        }
        else if ( $userID === -1 )
        {
            $this->session->setFlash("user_duplicate", 1);
            $this->session->setFlash("oauth_token",    $token);
            $this->session->setFlash("social_id",      $id);
            $this->session->setFlash("social_name",    $name);
            $this->session->setFlash("social_type",    $type);

            return $this->response->redirect("signin/duplicate");
        }

        return Signal::failed;
    }
}
