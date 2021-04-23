@extends('layouts.app')
@section('title', 'Formulario compra')
@section('content')
<h2><i class="fas fa-shopping-cart"></i> Formulario de compra</h2>

<div id="failureMessage"></div>

<form action="/crearOrder" id="frmPagos" method="post" data-role="ajax-request" data-title="Transacción" data-id="CREA_TRAN"
onsubmit="$('#md-request').modal()" data-response="#md-request .modal-body">

    @csrf

    <fieldset>
        <legend>Información del comprador</legend>
        <div class="form-group col-lg-12 col-sm-12">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" maxlength="80" required/>
        </div>
        <div class="form-group col-md-12">
            <label for="email">Correo electrónico</label>
            <input type="email" class="form-control" id="customer_email" name="customer_email" maxlength="120" required/>
        </div>
        <div class="form-group col-md-12">
            <label for="phone">Teléfono</label>
            <input type="text" class="form-control" id="customer_mobile" name="customer_mobile" maxlength="40"  required/>
        </div>
        <div class="form-group col-md-12">
            <label for="product_id">Producto</label>
            <select class="form-control" id="product_id" name = "product_id"  onchange="getPrice()" required>
                <option value="">Seleccion Producto</option>
                @foreach ($products as $item)
                    <option value={{$item->id}}>{{$item->descriptions}}</option>
                @endforeach
            </select>  
        </div>
        <div class="form-group col-md-12">
            <label for="amount">Monto</label>
            <input type="hidden" class="form-control" id="amount" name="amount" maxlength="40"  required/>
            <input type="text" class="form-control" id="amount_format" name="amount_format" maxlength="40" disabled required/>
        </div>
    </fieldset>
    <button type="submit" class="btn btn-primary col-md-12">Crear Orden</button>
</form>

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
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location = ('/orders')">Cancelar</button>
          <button type="button" class="btn btn-primary" onclick="window.location = ('/shoppingcart')">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('js')
<script type="text/javascript">
    function getPrice(){
        if($("#product_id").val() == ""){
            return;
        }
        $.ajax({
            type: "get",
            url: "/getPrice/"+$('#product_id').val(),
            success: function (response) {
                $("#amount").val(response.price);
                $("#amount_format").val(response.price_format);
            }
        });
    }
</script>
@endsection