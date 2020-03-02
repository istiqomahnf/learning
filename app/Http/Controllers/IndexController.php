<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Grade;
use Validator;
use Auth;
use Yajra\Datatables\Datatables;

class IndexController extends Controller
{
    public function index()
    {
    	$grade = Grade::orderBy('grade', 'ASC')->get();
        return view('index',['grade' => $grade]);
    }

    public function add()
    {
        $grade = Grade::orderBy('grade', 'ASC')->get();
    	return view('add',['grade' => $grade]);
    }

    public function allstudent()
    {
        $data   = "Data All Student";
        return response()->json($data, 200);
    }

    public function view_student(){
        try{
            $student = Student::with('grade')->get();
            // return response()->json(['result' => $student], 200);
            return Datatables::of($student)
                        ->addColumn('action', function(Student $student){
                            return '<button class="btn btn-warning btn-sm" onclick="edit('.$student->id.')">Edit</button> | 
                                    <button class="btn btn-danger btn-sm" onclick="delete_id('.$student->id.')">Delete</button>';
                        })
                        ->make(true);
        }catch(JWTException $e){
            return response()->json(['fail' => $student], 401);
        }
    }

    public function view(Request $req)
    {
    	// $student 		= Student::all();
        
        $student = Student::select('students.id','name', 'address','age','grade')
                    ->leftjoin('grade', function($join){
                        $join->on('grade.id','=','students.grade_id');
                    })->get(); 
    	$out = 	[ 
    			  'result'	=> $student
    			];
    	if ($req->header('Authorization')) 
        {
            return response()->json($out, 200);
        }
    }

    public function create(Request $req)
    {

        $validator =  Validator::make($req->all(),[
            'name'      => 'required|min:5|max:100',
            'address'   => 'required',
            'age'       => 'required|numeric',
            'grade'     => 'required'
        ]);
        if ($validator->passes()) 
        {
            Student::create([
                'name'      => $req->name,
                'address'   => $req->address,
                'age'       => $req->age,
                'grade_id'  => $req->grade
            ]);
            $respon = "success";    
            return response()->json($respon, 200);    
        }else{
            return response()->json(['error'=>$validator->errors()->all()]);
        }
    }

    public function getEdit(Request $req)
    {
    	$id 		= $req->id;
    	$student 	= Student::find($id);
    	return response()->json($student, 200);
    }

    public function update(Request $req)
    {
    	$id 		= $req->id;
    	$name 		= $req->name;
    	$address 	= $req->address;
    	$age 		= $req->age;
        $grade      = $req->grade;

    	$student 			= Student::find($id);
    	$student->name 		= $name;
    	$student->address 	= $address;
    	$student->age 		= $age;
        $student->grade_id  = $grade;
    	
    	return response()->json($student->save(), 200);

    }
    public function delete($id)
    {
    	$student = Student::find($id);
    	return response()->json($student->delete(), 200);
    }
}
