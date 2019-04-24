<?php
 
namespace App\Http\Controllers;
 
use App\Tarefa;
use App\Lista;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
 
class TarefaController extends Controller{

    public function getTarefaById($id) 
    {
       
        try{
            $lista = Lista::find($id);
            if(isset($lista['nome'])) {
                $tarefas = Tarefa::all()->where('t_lista_id', $id);
                if(isset($tarefas[0]['nome'])) {
                    return response(array(['status' => 'sucess', 'code' => 200, 'data' => $tarefas]));
                }
                return response(array(['status' => 'sucess', 'code' => 200, 'data' => 'This list has no tasks']));
            }
            return response(array(['status' => 'error', 'message' => 'list not found', 'code' =>  404]));
        } catch(QueryException $e) {

            return response(array(['status' => 'error', 'code' => 503]));
        }
    }
    

    public function store(Request $request)
    {
        $result = $this->validate($request,

            ['nome' => 'required|max:22'],
            ['idListaTarefa' => 'required'],
            ['nome.required' => ['status' => 'error', 'code' => 400, 'message' => 'The nome field is required.', 'data' => null ]],
            ['idListaTarefa.required' => ['status' => 'error', 'code' => 400, 'message' => 'The idListaTarefa field is required.', 'data' => null ]]
        ); 
        try{
            $request = $request->json()->all();
            $lista =  Lista::find($request['idListaTarefa']);
            if(isset($lista['nome'])) {
                $tarefa = new Tarefa();
                $tarefa->nome = $request['nome'];
                $tarefa->t_lista_id = $request['idListaTarefa'];
                $tarefa->concluido = false;
                $tarefa->save();
                $data = Tarefa::all()->sortBydesc('created_at')->first();
                return response(array(['status' => 'sucess', 'code' => 201, 'data' => $data]));
            }
            return response(array(['status' => 'error', 'message' => 'list not found', 'code' =>  404]));

        } catch (QueryException $e) {
            return response(array(['status' => 'error', 'code' => 503]));
        }  
    }

    public function destroy($id)
    {
        try{
            $tarefa = Tarefa::find($id);
            if(isset($tarefa['nome'])) {
                Tarefa::where('id', $id)->delete();
                return response(array(['status' => 'sucess', 'code' => 200]));
            }
            return response(array(['status' => 'error', 'message' => 'Task not found', 'code' =>  404]));
        } catch(QueryException $e) {
            return response(array(['status' => 'error', 'code' => 503]));
        }
    }

    public function finishTask($id) 
    {
        try{
            $tarefa = Tarefa::find($id);
            if(isset($tarefa['nome'])) {
                if($tarefa['concluido'] == 0) {
                    Tarefa::where('id', $id)->update(['concluido' => true]);
                    return response(array(['status' => 'sucess', 'code' => 200, 'data' => 'Task completed']));
                }
                Tarefa::where('id', $id)->update(['concluido' => false]);
                return response(array(['status' => 'sucess', 'code' => 200, 'data' => 'Task unchecked']));
            }
            return response(array(['status' => 'error', 'message' => 'Task not found', 'code' =>  404]));
        } catch(QueryException $e) {
            return response(array(['status' => 'error', 'code' => 503]));
        }
    }

    public function moveTarefa()
    {
        ///
    }
  
}
