@if(isset($errors))
    @if(count($errors) > 0)
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            @foreach($errors->all() as $error)
                <strong>{{ $error }}</strong>
                @if(count($errors) > 1)
                    <br>
                @endif
            @endforeach
        </div>
    @endif
@endif