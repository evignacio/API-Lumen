<?php
 
namespace App\Http\Controllers;
 
use App\Lista;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
class ListaController extends Controller{

    public function index(){

        return response(Lista::all());
    }

    public function store(Request $request){
        $this->validate($request, [
            'nome' => 'required|min:2'
        ]);
        $request->json()->all();
        $lista = new Lista();
        $lista->nome = $request['nome'];
        try{
            $lista->save();
            return response(['201']);
        }
        catch(Exception $e) {
            return response(['400']);
        }
    }

    public function update(Request $request, $id){
      
    }  
    public function delet($id){
   
    }
  
}
?>