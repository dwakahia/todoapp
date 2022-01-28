<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function getTasks(){
        $tasks = Task::where('user_id', auth()->id())->get();

        return $tasks;
    }
    public function store(TaskRequest $taskRequest)
    {
        $data = $taskRequest->safe()->only(['name', 'description']);
        $data['user_id'] = auth()->id();

        Task::create($data);

        return redirect()->back()->with('success', 'Task stored successfully');

    }

    public function edit(Task $task)
    {

        return redirect()->back()->with('task', $task);
    }


    public function update(TaskRequest $taskRequest, Task $task)
    {
        $data = $taskRequest->safe()->only(['name', 'description']);
        $data['user_id'] = auth()->id();
        $task->update($data);

        return redirect()->back()->with('success', 'Task updated successfully');
    }


    public function delete(Task $task)
    {
        $task->delete();
        return redirect()->back()->with('success', 'Task deleted successfully');
    }
}
