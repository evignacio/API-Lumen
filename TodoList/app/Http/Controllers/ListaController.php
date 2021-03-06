<?php
 
namespace App\Http\Controllers;
 
use App\Lista;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

 
class ListaController extends Controller{

    public function index()
    {

        try{
            $data =  Lista::all();
            return response(array(['status' => 'sucess', 'code' => 200, 'data' => $data]));
        } catch (QueryException $e) {
            return response(array(['status' => 'error', 'code' => 503]));
        }
    }

    public function store(Request $request)
    {

        $result = $this->validate($request, 
            ['nome' => 'required|max:20'],
            ['nome.required' => ['status' => 'error', 'code' => 400, 'message' => 'The nome field is required.', 'data' => null ]]
        );
        $request = $request->json()->all();
        try{
            $lista = new Lista();
            $lista->nome = $request['nome'];
            $lista->save();
            $newList = Lista::all()->sortByDesc('created_at')->first();
            return response(array(['status' => 'sucess', 'code' => 201, 'data' => $newList]));
        }
        catch(QueryException $e) {
            return response(array(['status' => 'error', 'code' => 503, 'data' => null]));
        }
    }

    public function destroy($id)
    {
        try{
            if(Lista::find($id)) {
                Lista::where('id', $id)->delete();
                return array(['status' => 'sucess', 'code' => 200]);
            }
            return array(['status' => 'sucess', 'message' => 'List not found.', 'code' => 404]);
        } catch (QueryException $e) {
            $error = explode(':',$e->getMessage());
            if($error[0] === 'SQLSTATE[23000]') {
                return array(['status' => 'error', 'message' => 'You need exclude the tasks linked with this list before.', 'code' => 409]);
            }
            return array(['status' => 'error', 'code' => 500]);
        }
    }
  
}
