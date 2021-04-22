@extends('layouts.app')

@section('title', 'Carrito compra')

@section('content')

<h2><i class="fas fa-clipboard-list"></i> Carrito de Compra</h2>

<?php if (count($requests)): ?>

<table class="table table-striped table-bordered table-sm">
    <thead>
        <tr>
            <th>Referencia</th>
            <th>Nombre Producto</th>
            <th>Valor</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($requests as $request)
        <tr>
            <td>{{ $request->id }}</td>
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

<div class="modal" tabindex="-1" role="dialog" id="md-request">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Términos de la plataforma</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    onclick="clearInterval(redirectionInterval);">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="
                    $('#timer').show();
                    $('#timer-desc').show();
                    var num = 5;
                    redirectionInterval = setInterval(function(){
                        if (num == 0)
                            $('#timer').text('...');
                        else
                            $('#timer').text(num.toString());
                        num--;
                        if (num < 0)
                            clearInterval(redirectionInterval);
                    }, 1000);
                    setTimeout(function(){
                        window.location = $('#timer-desc').attr('data-ref');
                    }, num * 1000);
                ">Aceptar</button>
            </div>
        </div>
    </div>
</div>


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
