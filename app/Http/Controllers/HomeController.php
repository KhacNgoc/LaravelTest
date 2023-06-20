<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Notifications\AssignNotification;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Notification;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $tasks = Task::select('task.id', 'task.title', 'task.content', 'users.name', 'task.status')
            ->leftJoin('users', 'users.id', '=', 'task.assignment')
            ->get()
            ->toArray();
//        dd($tasks);
        $users = User::all();
        return view('home', compact('tasks', 'users'));
    }

    /**
     * View create task screen.
     *
     * @return Renderable
     */
    public function new(): Renderable
    {
        $users = User::all();
        return view('new', compact('users'));
    }

    /**
     * View edit task screen.
     *
     * @param $id_task
     * @return Renderable
     */
    public function edit($id_task): Renderable
    {
        $users = User::all();
        $task = Task::select('task.id', 'task.title', 'task.content', 'users.name', 'task.status', 'users.id as assignment')
            ->leftJoin('users', 'users.id', '=', 'task.assignment')
            ->where('task.id', $id_task)
            ->first();
        return view('edit', compact('users', 'task'));
    }

    /**
     * Task screen.
     *
     * @param $id_task
     * @param Request $reqs
     * @return \Illuminate\Foundation\Application|Application|Redirector|RedirectResponse
     */
    public function edit_complete($id_task, Request $reqs): Application|\Illuminate\Foundation\Application|RedirectResponse|Redirector
    {
        $request = $reqs->all();
        $task = Task::find($id_task);
        $task->title = $request['title'];
        $task->content = $request['content'];
        $task->assignment = $request['assignment'];
        $task->save();
        return redirect(route('home'));
    }

    /**
     * Import task into system.
     *
     * @param Request $req
     * @return Application|\Illuminate\Foundation\Application|RedirectResponse|Redirector
     */
    public function create(Request $req): Application|\Illuminate\Foundation\Application|RedirectResponse|Redirector
    {
        $request = $req->all();
        $task = new Task();
        $task->title = $request['title'];
        $task->content = $request['content'];
        $task->status = 'in progress';
        $task->assignment = $request['assignment'];
        if ($task->save()) {
            $user = User::find($request['assignment']);
            Notification::send($user, new AssignNotification($task, 'assign'));
        }
        return redirect(route('home'));
    }

    /**
     * Delete task into system.
     *
     * @param $id_task
     * @return Application|\Illuminate\Foundation\Application|RedirectResponse|Redirector
     */
    public function delete($id_task): Application|\Illuminate\Foundation\Application|RedirectResponse|Redirector
    {
        Task::find($id_task)->delete();
        return redirect(route('home'));
    }

    /**
     * Delete task into system.
     *
     * @param $id_task
     * @return Application|\Illuminate\Foundation\Application|RedirectResponse|Redirector
     */
    public function finish($id_task): Application|\Illuminate\Foundation\Application|RedirectResponse|Redirector
    {
        $task = Task::find($id_task);
        $task->status = 'completed';
        if ($task->save()) {
            $user = User::find($task->assignment);
            Notification::send($user, new AssignNotification($task, 'change'));
        }
        return redirect(route('home'));
    }
}
