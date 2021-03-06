@extends('layouts.app')

@section('title', 'Lista de Pagos')

@section('content')

<h2><i class="fas fa-clipboard-list"></i> Últimos pagos/ordenes realizados</h2>

<?php if (count($requests)): ?>

    <table class="table table-striped table-bordered table-sm">
        <thead>
            <tr>
                <th>Fecha y hora</th>
                <th>Referencia</th>
                <th>Nombre Cliente</th>
                <th>Email</th>
                <th>Valor</th>
                <th>Mensaje</th>
                <th>Estado</th>
                <th>Acción</th>
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
                    <td>{{ $request->payment_message }}</td>
                    <td>{{ $request->getStatusDetail() }}</td>
                    <td class="text-center">
                        @if($request->status == 'REJECTED')
                            <a onclick="{{'crearTransaccion('.$request->id.')'}}" class="btn btn-primary btn-sm text-white">
                                Pagar 
                            </a>
                        @else
                            <a href="{{ url('/confirmacion') .'/'. $request->id }}" class="btn btn-primary btn-sm text-white">
                                Ver confirmación
                            </a>
                        @endif
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