  
@section('title', 'Page error')

@section('content')

<div class="alert alert-danger" role="alert">
    <strong>
        <i class="fas fa-exclamation-triangle"></i>
    </strong> &nbsp;{{ $message }}
</div>

@endsection('content')
