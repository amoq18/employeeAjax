<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;

class EmployeesController extends Controller
{
    public function index()
    {
        return view('employees.index');
    }

    /*
        AJAX request
    */
    public function getEmployees()
    {
        $search = request()->search;

        if($search == ''){
            $employees = Employee::orderby('name','asc')->select('id','name','email')->limit(5)->get();
         }else{
            $employees = Employee::orderby('name','asc')->select('id','name','email')->where('name', 'like', '%' .$search . '%')->limit(5)->get();
         }

         $response = array();
         foreach($employees as $employee){
            $response[] = array(
                 "id"=>$employee->id,
                 "text"=>$employee->name,
                 "text"=>$employee->email
            );
         }

         echo json_encode($response);
         exit;
        return 0;
    }
}
