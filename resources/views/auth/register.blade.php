@extends('layouts.app')
@section('title', 'Login')

@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center pt-5">
            <div class="col-sm-4">
                <div class="card">
                    <h4 class="card-header text-center">User Registration</h4>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <button type="button" onclick="registerForm()" class="btn btn-success w-100 mt-2">Register</button>
                        <div class="form-group text-center mt-2">
                            <a href="{{ route('login') }}" class="text-dark">Already Have an account?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>

        const registerForm = async () => {
            let name = document.getElementById("name").value,
            email = document.getElementById("email").value,
            password = document.getElementById("password").value;
            
            const response = await axios.post('/register', {
                name: name,
                email: email,
                password: password,
            });

            if(response.status == 200) {
                window.location.href = "/login";
            }
        }
    </script>
@endsection
