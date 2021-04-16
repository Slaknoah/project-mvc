<?php
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{
    public function home()
    {
        $params = [
            'name'  => 'MVCProject'
        ];
        return $this->render('home', $params);
    }

    public function contact()
    {
        return $this->render('contact');
    }

    public function handleContact( Request $request )
    {
        $body = $request->getBody();

        return 'handing data submitted';
    }
}