<?php
 
namespace App\Http\Controllers;
 
use App\Tarefa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
class TarefaController extends Controller{

    public function index(){

        return response(Tarefa::all());
    }

    public function store(Request $request){

        
    }

    public function update(Request $request, $id){
      
    }  
    public function delet($id){
   
    }
  
}
?>