<?php

namespace guayaquil\views\login;

use guayaquil\modules\User;
use guayaquil\View;
use RuntimeException;


class LoginHtml extends View
{
    public function Display($tpl = 'login', $view = 'view')
    {
        $view = $this->input->getString('view');
        switch ($view) {
            case 'login':
                $this->login();
                break;
            case 'logout':
                $user = $this->input->formData()['user'];
                $url  = parse_url($user['backurl']);
                parse_str($url['query'], $backurlParams);

                User::logout();
                $this->redirect($user['backurl']);
                break;
        }
    }

    public function login()
    {
        $user = $this->input->formData()['user'];

        if (!$user) {
            return;
        }

        $login = trim($user['login'] ?? '');
        $key   = $user['password'];

        $url = parse_url($user['backurl']);

        if (!empty($url['query'])) {
            parse_str($url['query'], $backurlParams);
        }

        $errorMessage = '';

        try {
            User::login($login, $key);
        } catch (RuntimeException $e) {
            $errorMessage = $e->getMessage();
        }

        $urlParams = [];

        if ($errorMessage) {
            $urlParams['errorMessage'] = $errorMessage;
        }

        if (User::getUser()->isLoggedIn()) {
            $urlParams['auth'] = 'true';
        } else {
            $urlParams['auth'] = 'false';
        }

        $paramString = http_build_query($urlParams);
        $this->redirect($user['backurl'] . $paramString ? '?' . $paramString : '');
    }
}