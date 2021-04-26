<?php
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\Contact;

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

    public function contact(Request $request, Response $response)
    {
        $contact = new Contact();
        if ( $request->isPost() ) {
            $contact->loadData($request->getBody());
            if ($contact->validate()) {
                $response->redirect('/');
                return;
            }
        }
        return $this->render('contact', [
            'model' => $contact
        ]);
    }
}