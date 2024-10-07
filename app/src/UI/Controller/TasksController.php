<?php

namespace UI\Controller;

use Application\Controller\AbstractController;
use Application\Query\ShowAllTasksQuery;

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
        
        $task = Task::findByTitle($title);

        if($task) {

            $files = glob('uploads/files/'.$task->id.'_*');

            return $this->render('tasks/show', ['task' => $task, 'files' => $files, 'status_options' => TaskStatus::cases()]);
        }

        return '404 not found';
    }

    public function update($vars): never
    {

        if(!empty($_POST['_method']) && $_POST['_method'] === 'PUT') {

            $task_id = htmlspecialchars($vars['task'], ENT_QUOTES, 'UTF-8');
    
            $task = Task::find(intval($task_id));

            if($task) {

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

                $task->title        = $title;
                $task->description  = $description;
                $task->completeDate = $complete_date;
                $task->status       = $status;
            
                if (isset($_FILES['files'])) {
                
                    $tasksAttachFilesApplicationService = new TasksAttachedFilesService;

                    $tasksAttachFilesApplicationService->attachFiles($task, $_FILES['files']);
                }

                $task->update();
            }
        }

        header('Location: /tasks/'.$task['title']);
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

        $task = new Task($title, $description, $complete_date, $status);
        
        $task->save();

        if (isset($_FILES['files'])) {

            $tasksAttachFilesApplicationService = new TasksAttachedFilesService;

            $tasksAttachFilesApplicationService->attachFiles($task, $_FILES['files']);
        }

        header('Location: /tasks');
        exit();
    }
}