<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function index(){
        return view('get-ajax-data');
      }

      public function getData($id = 0){
        // get records from database

        if($id==0){
          $arr['data'] = User::orderBy('id', 'asc')->get();
        }else{
          $arr['data'] = User::where('id', $id)->first();
        }
        echo json_encode($arr);
        exit;
      }
}
