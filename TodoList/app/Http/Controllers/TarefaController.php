<?php
 
namespace App\Http\Controllers;
 
use App\Tarefa;
use App\Lista;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
 
class TarefaController extends Controller{

    public function getTarefaById($id) {
       
        try{
            $lista = Lista::find($id);
            if(isset($lista['nome'])) {
                $tarefas = Tarefa::all()->where('t_lista_id', $id);
                if(isset($tarefas[0]['nome'])) {
                    return response(array(['status' => 'sucess', 'code' => 200, 'data' => $tarefas]));
                }
                return response(array(['status' => 'sucess', 'code' => 200, 'data' => 'dont have tarefas vinculas a esta lista']));
            }
            return response(array(['status' => 'error', 'message' => 'lista not found', 'code' =>  404]));
        } catch(QueryException $e) {

            return response(array(['status' => 'error', 'code' => 503]));
        }
    }
    
    public function getTarefaByNomeLista() {

    }

    public function store(Request $request){

        
    }

    public function update(Request $request, $id){
      
    }  
    public function delet($id){
   
    }
  
}
