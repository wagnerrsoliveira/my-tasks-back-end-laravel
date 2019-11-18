<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Task;

class TaskController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $tasks = Task::where('user_id',1)->get();

        return $this->showAll($tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->json()->all(),
        [
            'name' => 'required|max:255',
            'description' => 'max:255'
        ]
    );
                      
        if($validator->fails()){            
            $errors = $validator->errors();
            return $this->errorResponse($errors,422);
        }else{
            $task = Auth::user()->tasks()->create($request->all());
            
            
        $user = Auth::user();
        $tasks = Task::where('user_id',1)->get();

        return $this->showAll($tasks);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::where('user_id',1)->findOrFail($id);

        return $this->showOne($task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $validator = Validator::make($request->json()->all(),
        [
            'name' => 'max:255',
            'description' => 'max:255',
            'status'=>'integer|between:0,3'
        ]
    );
                      
        if($validator->fails()){            
            $errors = $validator->errors();
            return $this->errorResponse($errors,422);
        }else{
            $task = Task::where('user_id',1)->findOrFail($id);
            $task->fill($request->all());
            $task->save();
            
        $user = Auth::user();
        $tasks = Task::where('user_id',1)->get();

        return $this->showAll($tasks);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::where('user_id',1)->findOrFail($id);
        $task->delete();

        $user = Auth::user();
        $tasks = Task::where('user_id',1)->get();

        return $this->showAll($tasks);
    }
}
