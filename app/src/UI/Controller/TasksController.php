<?php

namespace UI\Controller;

use Application\Command\StoreTaskCommand;
use Application\Controller\AbstractController;
use Application\Query\ShowAllTasksQuery;

use Application\Query\ShowTaskQuery;
use Application\Command\UpdateTaskCommand;
use Domain\Model\Entity\Task;
use Domain\Model\ValueObject\TaskStatus;
use Infrastructure\Service\TasksAttachedFilesService;

class TasksController extends AbstractController
{

    public function index(): string 
    {

        $filterPropIdx = filter_input(INPUT_GET, 'filter', FILTER_VALIDATE_INT);
        
        $filter         = $filterPropIdx ? ['status' => TaskStatus::from($filterPropIdx)] : null;
        $selectedFilter = $filterPropIdx ? TaskStatus::from($filterPropIdx) : null;
        
        $query = new ShowAllTasksQuery(filter: $filter);

        $tasks = $this->tasksApplicationService->showAllTasks($query);

        return $this->render('tasks/index', data: ['tasks' => $tasks, 'selected_option' => $selectedFilter, 'status_options' => TaskStatus::cases()]);
    }

    public function show($vars): string
    {

        $title = htmlspecialchars($vars['task'], ENT_QUOTES, 'UTF-8');
        
        $query = new ShowTaskQuery($title);
        
        [$task, $files] = $this->tasksApplicationService->showTask($query);

        if(is_null($task)) {

            return '404 not found';
        }

        return $this->render('tasks/show', ['task' => $task, 'files' => $files, 'status_options' => TaskStatus::cases()]);
    }

    public function update($vars): never
    {

        if(!empty($_POST['_method']) && $_POST['_method'] === 'PUT') {

            $task_id = htmlspecialchars($vars['task'], ENT_QUOTES, 'UTF-8');
    
            $args = [
                'title'         => FILTER_UNSAFE_RAW,
                'description'   => FILTER_UNSAFE_RAW,
                'status'        => FILTER_VALIDATE_INT,
                'complete_date' => FILTER_UNSAFE_RAW,
            ];
    
            $input = filter_input_array(INPUT_POST, $args);
    
            $title          = htmlspecialchars($input['title'], ENT_QUOTES, 'UTF-8');
            $description    = htmlspecialchars($input['description'], ENT_QUOTES, 'UTF-8');
            $complete_date  = \DateTime::createFromFormat('Y-m-d', datetime: $input['complete_date']);
            $status         = TaskStatus::from($input['status']);

            $command = new UpdateTaskCommand(intval($task_id), $title, $description, $complete_date, $status);

            $title = $this->tasksApplicationService->updateTask($command);
        }

        if(empty($title)) {

            //TO-DO: resend to task not found page
        } else {

            header('Location: /tasks/'.$title);
        }

        exit();
    }

    public function create(): string
    {
        
        return $this->render(name: 'tasks/create', data: ['status_options' => TaskStatus::cases()]);
    }

    public function store(): never
    {

        $args = [
            'title'         => FILTER_UNSAFE_RAW,
            'description'   => FILTER_UNSAFE_RAW,
            'status'        => FILTER_VALIDATE_INT,
            'complete_date' => FILTER_UNSAFE_RAW,
        ];

        $input = filter_input_array(INPUT_POST, $args);

        $title          = htmlspecialchars($input['title'], ENT_QUOTES, 'UTF-8');
        $description    = htmlspecialchars($input['description'], ENT_QUOTES, 'UTF-8');
        $complete_date  = \DateTime::createFromFormat('Y-m-d', datetime: $input['complete_date']);
        $status         = TaskStatus::from($input['status']);

        $command = new StoreTaskCommand($title, $description, $complete_date, $status);

        $this->tasksApplicationService->storeTask($command);

        header('Location: /tasks');
        exit();
    }
}