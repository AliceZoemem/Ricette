{{--@extends('master')--}}
{{--@section('title','Registrazione - Il mio frigo')--}}
{{--@section('content')--}}

@extends('master')
@section('title','Registrazione - Il mio frigo')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Registrati</div>

                    <div class="panel-body" >
                        <form class="form-horizontal" method="POST" action="register">


                            <div class="form-group">
                                {{--<label for="name" class="col-md-4 control-label">Nome</label>--}}

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" placeholder="Nome" required>
                                           {{--value="{{ old('name') }}" required autofocus>--}}

                                    {{--@if ($errors->has('name'))--}}
                                        {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('name') }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@endif--}}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6">
                                    <input id="email" type="text" class="form-control" name="email" placeholder="Email" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                                </div>
                            </div>

                            <div class="form-group">
                                {{--<label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>--}}
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Conferma Password" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Registrati
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
