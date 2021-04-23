@extends('layouts.app')

@section('title', 'Confirmación del pago')

@section('content')

<h2><i class="far fa-credit-card"></i> Confirmación del pago</h2>

<table class="table table-striped table-bordered table-sm">
    <thead>
        <tr>
            <th>Label</th>
            <th>Información</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>Razón social</th>
            <td><strong>RAZON SOCIAL COMERCIO</strong></td>
        </tr>
        <tr>
            <th>NIT</th>
            <td><strong>NIT COMERCIO</strong></td>
        </tr>
        <tr>
            <th>Fecha y hora</th>
            <td><?= $order->payment_date ?></td>
        </tr>
        <tr>
            <th>Estado</th>
            <td><?= $order->payment_message ?></td>
        </tr>
        <tr>
            <th>Motivo</th>
            <td><?= $order->payment_reason ?> - <?= $order->payment_message ?></td>
        </tr>
        <tr>
            <th>Valor</th>
            <td>
                <?= "COP ".number_format($order->amount, 2) ?>
            </td>
        </tr>
        <tr>
            <th>IVA</th>
            <td>-</td>
        </tr>
        <tr>
            <th>Autorización / CUS</th>
            <td><?= $order->payment_authorization ?></td>
        </tr>
        <tr>
            <th>Referencia</th>
            <td><?= $order->payment_reference ?></td>
        </tr>
        <tr>
            <th>Descripción</th>
            <td><?= 'COMPRA No.'.$order->id?></td>
        </tr>
        <tr>
            <th>Dirección IP</th>
            <td><?= $order->ipAddress ?></td>
        </tr>
        <tr>
            <th>Cliente</th>
            <td><?= $order->customer_name ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= $order->customer_email ?></td>
        </tr>
    </tbody>
</table>

<?php if ($order->payment_status == 'APPROVED'): ?>

<a href="<?= url('/') ?>" class="btn btn-success">
    <i class="fas fa-undo-alt"></i> Volver al inicio
</a>

<?php elseif ($order->payment_status == 'PENDING'): ?>

En este momento su orden de compra #<?= $order->id ?> presenta
un proceso de pago cuya transacción se encuentra PENDIENTE de recibir
confirmación por parte de su entidad financiera, por favor espere unos minutos y vuelva
a consultar más tarde para verificar si su pago fue confirmado de forma exitosa. Si
desea mayor información sobre el estado actual de su operación puede comunicarse a
nuestras líneas de atención al cliente <strong>TELEFONO CONTACTO</strong> o enviar un correo
electrónico a <strong>EMAIL</strong> y preguntar por el estado de la transacción:
#<?= $order->payment_authorization ?>***.

<?php elseif ($order->status == 'REJECTED'): ?>
<a onclick="<?= "crearTransaccion($order->id)" ?>" class="btn btn-success">
    <i class="fas fa-undo-alt"></i> Reintentar Pago
</a>

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
