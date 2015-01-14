<?php

class UserController extends SZ_Breeder
{
    public function __construct()
    {
        parent::__construct();
        $this->import->model("PinModel");
        $this->import->model("UserModel");
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
        $pins = $this->pinModel->getRecentPins($user->id);
        $tags = $this->pinModel->getRecentTags($user->id);

        $this->view->assign("pins", $pins);
        $this->view->assign("tags", $tags);
        $this->view->assign("targetUser", $user);

        return $this->view->set("user/index");
    }

    public function pins()
    {
        $userID = $this->userModel->getUserID();
        $pins = $this->pinModel->getRecentPins($userID);
        $tags = $this->pinModel->getRecentTags($userID);

        $this->view->assign("pins", $pins);
        $this->view->assign("tags", $tags);
    }

}

