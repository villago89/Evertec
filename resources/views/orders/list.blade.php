@extends('layouts.app')

@section('title', 'Lista de Pagos')

@section('content')

<h2><i class="fas fa-clipboard-list"></i> Últimos pagos realizados</h2>

<?php if (count($requests)): ?>

    <table class="table table-striped table-bordered table-sm">
        <thead>
            <tr>
                <th>Fecha y hora</th>
                <th>Referencia</th>
                <th>Autorización/CUS</th>
                <th>Estado</th>
                <th>Valor</th>
                <th>Estado</th>
                <th>Detalle</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $request)
                <tr>
                    <td>{{ $request->created_at }}</td>
                    <td>{{ $request->id }}</td>
                    <td>{{ $request->customer_name }}</td>
                    <td>{{ $request->customer_email }}</td>
                    <td>{{ number_format($request->amount, 2) }}</td>
                    <td>{{ $request->status }}</td>
                    <td>
                        <a href="{{ url('/confirmacion') .'/'. $request->id }}" class="btn btn-primary btn-sm">
                            Ver confirmación
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

<?php else: ?>
    <div class="alert alert-warning alert-light">
        <h4 class="alert-heading"><span class="glyphicon glyphicon-exclamation-sign"></span> Sin transacciones</h4>
        <p>Parece que aún no hay transacciones registradas.</p>
    </div>
<?php endif; ?>

@endsection('content')