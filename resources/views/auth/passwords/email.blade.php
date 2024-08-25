@include('layouts.partials.htmlhead')
{{-- @include('layouts.partials.header1') --}}

<div style="background-image: url('/img/fondo_bienvenida.jpg');background-repeat: no-repeat; background-size: 100% 100%; background-position: left top; width: 100%; height:100%; object-fit: cover;">

    <div style="background-color: #10241670;">
        {{-- 102416de footer --}}
        <!-- HEADER -->
        @include('layouts.partials.header1')
        <!-- end HEADER -->

    </div>
    <div class="container" style=" height:90vh;">
        
        <br><br><br>
        <div style="padding: 0.7rem">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header" style="background-color: #f2eded9c;">
                            <img class="img-fluid" src="{{ asset('img/logoHeader.png') }}" alt="" style="display: flex;margin: auto;">
                        </div>
                        <div class="card-header">{{ __('Reset Password') }}</div>
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
        
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
        
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
        
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-success">
                                            {{ __('Send Password Reset Link') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- footer -->
@include('layouts.partials.footerLogout')
   
<!-- start scripts -->
@include('layouts.partials.scripts')
<!-- end scripts -->
