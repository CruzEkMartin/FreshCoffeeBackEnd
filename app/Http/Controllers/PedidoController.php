<?php

namespace App\Http\Controllers;

use App\Http\Resources\PedidoCollection;
use Carbon\Carbon;
use App\Models\Pedido;
use App\Models\PedidoProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return new PedidoCollection(Pedido::with('user')->with('productos')->where('estado', 0)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //almacenar un pedido
        $pedido = new Pedido;
        $pedido->user_id = Auth::user()->id;
        //se lee el total enviado desde el front end
        $pedido->total = $request->total;
        //guardamos el pedido
        $pedido->save();

        //obtener el id del pedido insertado
        $id = $pedido->id;

        //obtener los productos desde el front end
        $productos = $request->productos;

        //formatear un arreglo
        $pedido_producto = [];

        foreach($productos as $producto){

            $pedido_producto[] = [
                'pedido_id' => $id, //id del pedido insertado
                'producto_id' => $producto['id'], //id del producto que se envía desde el front end
                'cantidad' => $producto['cantidad'], //cantidad del producto que se envía desde el front end
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        //almacenar en la bd, insertando el arreglo
        PedidoProducto::insert($pedido_producto);

        return [
            'message' => 'Pedido realizado correctamente, estará listo en unos minutos'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
        $pedido->estado = 1;
        $pedido->save();

        return [
            'pedido' => $pedido
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
