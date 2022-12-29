@extends('layouts.app')

 @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Aplikasi Hotel') }}</div>


                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Kamu akan login') }}
                    {{__('AYO ')}} <a href="admin/dashboard">Aplikasi</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


