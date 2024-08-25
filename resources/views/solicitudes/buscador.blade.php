
<form method="GET" action="{{route('solicitud_buscar')}}">
    @csrf

    <div class="form-group"> 
        <div class="input-group">
            <input type="text" class="form-control" name="searchText" placeholder="Buscar..." value="<?php $searchText ?>" style="border-radius: 0.35rem">
            <span class="input-group-btn" style="margin-left: 20px;">
                <button type="submit" class="btn btn-success">BUSCAR</button>
            </span>

        </div>
        
    </div>

</form>
<!-- form -->