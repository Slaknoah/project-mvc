<?php
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\Contact;
use app\models\Task;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['editTask']));
    }

    public function home(Request $request)
    {
        $requestBody = $request->getBody();
        $orderBy = [];
        if ( isset( $requestBody['order_by'] ) ) {
            $orderBy = [
                $requestBody['order_by'],
                $requestBody['order_dir'] ?? 'asc'
            ];
        }
        try {

            $tasks = Task::paginate([], $orderBy);
        } catch (NotFoundException $e) {
            throw new NotFoundException();
        }

        $params = [
            'tasks' => $tasks
        ];
        return $this->render('home', $params);
    }

    public function addTask(Request $request, Response $response)
    {
        $task = new Task();

        if ( $request->isPost() ) {
            $task->loadData($request->getBody());
            if ($task->validate() && $task->save()) {
                $response->redirect('/');
                return;
            }
        }
        return $this->render('add-task', [
            'model' => $task
        ]);
    }

    public function editTask(Request $request, Response $response)
    {
        $requestBody = $request->getBody();

        if( !isset( $requestBody['task_id'] ) ) throw new NotFoundException();

        $task = Task::findOne(['id' => $requestBody['task_id']]);

        if (!$task) throw new NotFoundException();

        if ( $request->isPost() ) {
            $task->loadData($request->getBody());
            if ($task->validate() && $task->update()) {
                $response->redirect('/');
                return;
            }
        }

        return $this->render('edit-task', [
            'model' => $task
        ]);
    }
}