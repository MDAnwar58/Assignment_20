@extends('layouts.app')
@section('title', 'Login')

@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center pt-5">
            <div class="col-sm-6 col-md-4">
                <div class="card">
                    <h4 class="card-header text-center">User Login</h4>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="form-group text-end">
                            <a href="{{ route('forget.password') }}">Forget Your Password</a>
                        </div>
                        <button type="button" onclick="loginForm()" class="btn btn-success w-100 mt-2">Login</button>
                        <div class="form-group text-center mt-2">
                            <a href="{{ route('register') }}">Create a new account</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>

        const loginForm = async () => {
            let email = document.getElementById("email").value,
            password = document.getElementById("password").value;
            
            const response = await axios.post('/login', {
                email: email,
                password: password,
            });
            // console.log(response);
            if(response.status == 200) {
                window.location.href = "/home";
            }
        }
    </script>
@endsection