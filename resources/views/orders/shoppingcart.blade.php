@extends('layouts.app')

@section('title', 'Carrito compra')

@section('content')

<h2><i class="fas fa-clipboard-list"></i> Carrito de Compra</h2>

<?php if (count($requests)): ?>

<table class="table table-striped table-bordered table-sm">
    <thead>
        <tr>
            <th>Referencia</th>
            <th>Datos Cliente</th>
            <th>Email</th>
            <th>Nombre Producto</th>
            <th>Valor</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($requests as $request)
        <tr>
            <td>{{ $request->id }}</td>
            <td>{{ $request->customer_name }}</td>
            <td>{{ $request->customer_email }}</td>
            <td>{{ $request->product->descriptions }}</td>
            <td>{{ number_format($request->amount, 2) }}</td>
            <td>
                <a onclick="{{ 'crearTransaccion('.$request->id.')' }}" class="btn btn-primary btn-sm">
                    PAGAR
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<?php else: ?>
<div class="alert alert-warning alert-light">
    <h4 class="alert-heading"><span class="glyphicon glyphicon-exclamation-sign"></span> Sin transacciones</h4>
    <p>Parece que aún no hay ordenes registradas.</p>
</div>
<?php endif; ?>

@endsection('content')

@section('js')
<script type="text/javascript">
    function crearTransaccion(id) {
        $.ajax({
            type: "get",
            url: "/crearTransaccion/" + id,
            success: function (response) {
                $('#md-request').modal();
                $(".modal-body").html(response);
            }
        });
    }

</script>
@endsection
