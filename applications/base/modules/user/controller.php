<?php

class UserController extends SZ_Breeder
{
    public function __construct()
    {
        parent::__construct();
        $this->import->library("Session");
        $this->import->model("UserModel");
        $this->import->model("PinModel");
    }

    public function _mapping($method)
    {
        $user = $this->userModel->find("id, name", array("name" => $method));
        if ( $user )
        {
            $this->view->assign("title", $user->name . ":pins");
            return $this->run($user);
        }
        return Signal::finished;
    }

    protected function run($user)
    {
        $tag        = $this->request->get("t");
        $offset     = $this->request->get("p");
        $pins       = $this->pinModel->getRecentPins($user->id, $tag, 20, $offset);
        $tags       = $this->pinModel->getRecentTags($user->id);
        $auth       = $this->session->getFlash("oauth_error");
        $subscribed = $this->session->getFlash("user_subscribed");

        $this->view->assign("subscribed", NULL);
        if ( $this->userModel->isLoggedIn() )
        {
            $id     = $this->userModel->getUserID();
            $self   = $this->userModel->getUserByID($id);
            $emails = $this->userModel->getUserEmails($id, TRUE);
            $this->view->assign("user",   $self);
            $this->view->assign("emails", $emails);
            if ( $user->id != $self->id )
            {
                $this->view->assign("followed",   $this->userModel->isUserFollowed($user->id));
                $this->view->assign("subscribed", $this->userModel->isUserSubscribed($user->id, $tag));
            }
        }

        // pagination settings
        $link = "u:{$user->name}";
        if ( $tag )
        {
            $link .= "?t={$tag}";
        }

        $Pagination = Seezoo::$Importer->library("Paginate");
        $Pagination->configure(array(
            'total'               => $this->pinModel->getTotalPins($user->id),
            'base_link'           => page_link($link),
            'per_page'            => 20,
            'query_string'        => "p",
            'first'               => '&laquo;First',
            'last'                => 'Last&raquo;',
            'next'                => 'Next&nbsp;&gt;',
            'prev'                => '&lt;&nbsp;Prev',
            'link_separator'      => '',
            'links_wrapper_start' => '<div class="lap-paginate">',
            'links_wrapper_end'   => '</div>',
            'auto_assign'         => TRUE
        ));

        $this->view->assign("token",             $this->session->generateToken("user_token", TRUE));
        $this->view->assign("tag",               $tag);
        $this->view->assign("pins",              $pins);
        $this->view->assign("tags",              $tags);
        $this->view->assign("targetUser",        $user);
        $this->view->assign("auth_result",       $auth);
        $this->view->assign("subscribe_result",  $subscribed);
        $this->view->assign("overlay",           TRUE);
        $this->view->assign("modals",            array("user/subscribe_modal"));

        $this->session->save();

        return $this->view->set("user/index");
    }

    public function pins()
    {
        $userID = $this->userModel->getUserID();
        $pins   = $this->pinModel->getRecentPins($userID);
        $tags   = $this->pinModel->getRecentTags($userID);

        $this->view->assign("pins", $pins);
        $this->view->assign("tags", $tags);
    }

    public function subscribe_post()
    {
        $userID  = $this->request->post("userId");
        $emailID = $this->request->post("emailId");
        $tag     = $this->request->post("tag");
        var_dump($userID);
        exit;
        $user    = $this->userModel->getUserByID($userID);
        $token   = $this->request->post("token");

        if ( ! $user )
        {
            return Signal::finished;
        }
        $path = ( $tag ) ? "u:{$user->name}?t={$tag}" : "u:{$user->name}";

        if ( $this->session->checkToken("user_token", $token, TRUE) )
        {
            if ( $this->userModel->subscribeUser($userID, $emailID, $tag) )
            {
                $this->session->setFlash("user_subscribed", 1);
            }
        }

        return $this->response->redirect($path);
    }
}

