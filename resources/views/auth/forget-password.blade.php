@extends('layouts.app')
@section('title', 'Forget Password')

@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center pt-5">
            <div class="col-sm-4">
                <div class="card">
                    <h4 class="card-header text-center">Forget Password</h4>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>
                        <button type="button" onclick="forgetPassword()" class="btn btn-success w-100 mt-2">Send</button>
                        <div class="form-group text-center mt-2">
                            <a href="{{ route('login') }}">back to Login.</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>

        const forgetPassword = async () => {
            let email = document.getElementById("email").value;
            
            const response = await axios.post('/login', {
                email: email
            });
            console.log(response);
            if(response.status == 200) {
                window.location.href = "/verify-otp";
            }
        }
    </script>
@endsection