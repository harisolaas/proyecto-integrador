@extends('_dashboard')

@section('title', 'Business Dashboard')

@section('h1')
    ecoTicket Business
@endsection

@section('sidebar')
    <ul class="nav nav-sidebar">
        <li><a href="/seller/home">Vista previa </a></li>
        <li><a href="/seller/home/new-ticket">Nuevo Ticket </a></li>
        <li class="active"><a href="#">Todos mis Tickets </a></li>
        <li><a href="/seller/home/products">Productos </a></li>
        <li><a href="/seller/home/promotions">Promociones </a></li>
    </ul>
@endsection

@section('panels')
    <div>
        <div class="container-fluid">

            <div class="row heading">
                <div class="col-xs-3">
                    <strong>Fecha</strong>
                </div>
                <div class="col-xs-4">
                    <strong>Usuario</strong>
                </div>
                <div class="col-xs-3">
                    <strong>Monto total</strong>
                </div>
                <div class="col-xs-2">
                    <strong></strong>
                </div>
            </div>

            <div class="panel-group" id="accordion">

                @forelse ($transactions as $key => $transaction)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">{{$transaction->created_at->format('d-m-Y')}}</div>
                                <div class="col-xs-4">{{$transaction->user->id}}</div>
                                <div class="col-xs-3">$ {{$transaction->total_amount}}</div>
                                <div class="col-xs-2"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#details{{$key}}">Detalles</a></div>
                            </div>
                        </div>
                        <div id="details{{$key}}" class="panel-collapse collapse transaction-details">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-8 col-xs-offset-2">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Imagen</th>
                                                    <th>Producto</th>
                                                    <th>Precio</th>
                                                    <th>Marca</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($transaction->products as $id => $product)
                                                    <tr>
                                                        <td><img class="img-xs img-rounded" src="{{asset('img/'.$product->productImage->name)}}" alt="product-image"></td>
                                                        <td>{{$product->name}}</td>
                                                        <td>{{$product->price}}</td>
                                                        <td>{{$product->brand->name}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            <div class="col-xs-6 flex-center">
                                                <a class="btn btn-primary" target='blank' href="/download/{{ $transaction->id }}">Descargar</a>
                                            </div>
                                            <div class="col-xs-6 flex-center">
                                                <a class="btn btn-primary" target='blank' href="/print/{{ $transaction->id }}">Imprimir</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="row">
                        <p class="alert alert-info">No hay transacciones aún!</p>
                    </div>
                @endforelse
                {{$transactions->links()}}

            </div>
        </div>
    </div>

@endsection
