<?php

class SessionController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {

    }

    public function successAction()
    {

    }

    public function loginAction()
    {

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = Users::findFirstByUsername($username);
        if ($user) {
            if ($this->security->checkToken() && $this->security->checkHash($password, $user->password)) {
                $this->session->set('auth-identity', array(
                    'id' => $user->id,
                    'username' => $user->username
                    ));
                return $this->dispatcher->forward(array(
                    "controller" => "session",
                    "action" => "success"
                    ));
            } else {
                return $this->dispatcher->forward(array(
                    "controller" => "session",
                    "action" => "failed"
                    ));
            }
        } else {
            return $this->dispatcher->forward(array(
                "controller" => "session",
                "action" => "not-found"
                ));
        }

    }

    public function logoutAction()
    {
        $this->session->remove('auth-identity');
        return $this->dispatcher->forward(array(
            "controller" => "session",
            "action" => "index"
            ));
    }

}