<?php

namespace App\Controller;

/**
 * Class ErrorController
 *
 * @package App\Controller
 */
class ErrorController extends Controller
{

    public function notFoundAction()
    {
        $this->render(['message' => 'Page not found'], 'error');
    }
}
