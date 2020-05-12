@extends('layouts.app')

@section('content')

<div class="container" class="hold-transition login-page">
    <div class="row justify-content-center">
        <div class="col-md-6 ">

                        <div class="login-logo mt-10">
                         <b>######</b>######
                        </div>

            <div class="card" >

                    <div class="card-header" style="background-color: #1567d8;"><span class="align-middle" style="font-size:19px;color:seashell; "><i class="fas fa-user" ></i>   <b>Rejoindre L'équipe<b></span></div>

                <div class="card-body">
                       <login-form></login-form>
             <!--  <form class="login-form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="field is-horizontal">
                            <div class="field-label">
                                <label class="label">E-Mail Address</label>
                            </div>

                            <div class="field-body">
                                <div class="field">
                                    <p class="control">
                                            <input  class="form-control"id="email" type="email" name="email"
                                            value="{{ old('email') }}" required autofocus>
                                    </p>

                                    @if ($errors->has('email'))
                                        <p class="help is-danger">
                                            {{ $errors->first('email') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="field is-horizontal">
                            <div class="field-label">
                                <label class="label">Password</label>
                            </div>

                            <div class="field-body">
                                <div class="field">
                                    <p class="control">
                                            <input  class="form-control" id="password" type="password" name="password" required>
                                    </p>

                                    @if ($errors->has('password'))
                                        <p class="help is-danger">
                                            {{ $errors->first('password') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="field is-horizontal">
                            <div class="field-label"></div>

                            <div class="field-body">
                                <div class="field">
                                    <p class="control">
                                        <label class="checkbox">
                                            <input type="checkbox"
                                                   name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="field is-horizontal">
                            <div class="field-label"></div>

                            <div class="field-body">
                                <div class="field is-grouped">
                                    <div class="control">
                                            <button type="submit" class="btn btn-primary">Login</button>
                                    </div>

                                    <div class="control">
                                        <a href="{{ route('password.request') }}">
                                            Forgot Your Password?
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>-->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
