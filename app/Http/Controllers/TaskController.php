<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Notifications\TaskCompleted;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function getTasks()
    {
        $tasks = Task::where('user_id', auth()->id())->paginate(6);

        return $tasks;
    }

    public function searchTask(Request $request)
    {
        $searchQuery = $request->searchtxt;
        $tasks = Task::where([
            ['user_id', '=', auth()->id(),],
            ['name', 'LIKE', '%' . $searchQuery . '%',],
        ])->paginate(6);

        return view('home', compact('tasks'));
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

    public function markAsChecked(Request $request, Task $task)
    {

        $task->update([
            'status' => $request->has('status') ? 1 : 0
        ]);

        auth()->user()->notify(new TaskCompleted($task));



        return redirect()->back()->with('success', 'Task marked as completed');
    }


    public function delete(Task $task)
    {
        $task->delete();
        return redirect()->back()->with('success', 'Task deleted successfully');
    }
}
