@include('layouts.partials.htmlhead')

<div id="content" style="position: relative;background-color: #ebf4ef; background-image: url('img/descarga.png');background-repeat: no-repeat; background-size: 100% 100%;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                        
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                                {{ __('click here to request another') }}
                            </button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.partials.scripts')
