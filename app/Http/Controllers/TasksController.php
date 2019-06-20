<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::orderBy('due_date', 'asc')->paginate(5);

        return view('tasks.index')->with('tasks', $tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        
        // Validate the data
        $this->validate($request, [
            'name' => 'required|string|max:255|min:3',
            'description' => 'required|string|max:1000|min:10',
            'due_date' => 'required|date',
        ]);

        // Create New task
        $task = new Task;

        // Assign the Task data form our request
        $task->name = $request->name;
        $task->description = $request->description;
        $task->due_date = $request->due_date;

        // Save the task
        $task->save();

        // Flash Session Message with Success
        Session::flash('success', 'Created Task Successfully');

        // Return A Redirect
        return redirect()->route('task.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Search the task with the ID
        // Reutrn a view (show.blade.php)
        // Pass with the return the variable that contains the specific task
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        $task->dueDateFormatting = false;

        return view('tasks.edit')->withTask($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the data
        $this->validate($request, [
            'name' => 'required|string|max:255|min:3',
            'description' => 'required|string|max:1000|min:10',
            'due_date' => 'required|date',
        ]);

        // Find the related task
        $task = Task::find($id);

        // Assign the Task data form our request
        $task->name = $request->name;
        $task->description = $request->description;
        $task->due_date = $request->due_date;

        // Save the task
        $task->save();

        // Flash Session Message with Success
        Session::flash('success', 'Save The Task Successfully');

        // Return A Redirect
        return redirect()->route('task.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Finding the specific task by the ID
        $task = Task::find($id);

        //Deleting the task
        $task->delete();

        //Flashing a session message
        Session::flash('success', 'Delete The Task Successfully');

        //Returning a redirect back to the index
        return redirect()->route('task.index');
    }
}
