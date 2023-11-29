<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;
use File;
use Faker;

class TasksController extends Controller
{
    public function index(){
        return view('user.home');
    }
    public function delete(request $request){
        $data = [
            'status' => false,
            'task_id' => null,
        ];
        $task = Tasks::where('user_id',auth()->user()->id)->find($request->task_id);
        if ($task) {
            $task = Tasks::find($request->task_id);
            if ($task->file != null) {
                File::delete(public_path("image/" . $task->file));
            }
            $task->delete();
            $data['status'] = true;
            $data['task_id'] = $request->task_id;
            return response()->json($data);
        }
        return response()->json($data);
    }
    public function show(request $request){
        if ($request->task_id == null) {
            return redirect('home');
        }
        $task = Tasks::where('user_id',auth()->user()->id)->find($request->task_id);
        if ($task) {
            $task = Tasks::find($request->task_id);
            return view('user.task.tasks',compact('task'));
        }
        return redirect('home');
    }
    public function create(){
        return view('user.task.create');
    }
    public function store(request $request){
        $request->validate([
            'name' => 'required',
            'file' => 'image|mimes:jpg,jpeg,png',
        ], [
            'name.required' => 'Judul harus Diisi',
            'file.image' => 'File harus berupa gambar',
            'file.mimes' => 'gambar harus berformat jpg/jpeg/png',
        ]);
        
        $filename = null;
        if ($request->file) {
            $filename = date('dmYHis') . "." . $request->file->extension();
            $request->file->move(public_path('image'), $filename);
        }

        $task = Tasks::create([
            'user_id'=>auth()->user()->id,
            'name'=>$request->name,
            'description'=>$request->description,
            'file'=>$filename,
        ]);

        return redirect('user/task?task_id='.$task->id);
    }
    public function edit(request $request){
        $request->validate([
            'name' => 'required',
            'file' => 'image|mimes:jpg,jpeg,png',
        ], [
            'name.required' => 'Judul harus Diisi',
            'file.image' => 'File harus berupa gambar',
            'file.mimes' => 'gambar harus berformat jpg/jpeg/png',
        ]);

        $task = Tasks::find($request->id);
        
        $filename = $task->file;
        if ($request->file) {
            $filename = date('dmYHis') . "." . $request->file->extension();
            $request->file->move(public_path('image'), $filename);
            File::delete(public_path("image/" . $task->file));
        }

        $task->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'file'=>$filename,
        ]);

        return redirect('user/task?task_id='.$task->id);
    }
    public function get(request $request){
        $data = Tasks::find($request->task_id);
        return response()->json($data);
    }
    public function update($id){
        $data = Tasks::find($id);
        return view('user.task.update',compact('data'));
    }
    public function status(request $request){
        $task = Tasks::find($request->task_id);
        $status = null;
        if ($task->status == 'Selesai') {
            $status = 'Belum Selesai';
        }else{
            $status = 'Selesai';
        }
        $task->update([
            'status'=>$status
        ]);
        return response()->json($task);
    }
}
