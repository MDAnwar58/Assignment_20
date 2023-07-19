@extends('layouts.app')
@section('title', 'Reset Password')

@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center pt-5">
            <div class="col-md-4 col-sm-6">
                <div class="card">
                    <h4 class="card-header text-center">Your Password Reset</h4>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                            <span class="text-danger" id="passwordE"></span>
                        </div>
                        <div class="form-group">
                            <label for="confrimation-password">Confrim Password</label>
                            <input type="password" name="confrimation-password" id="confrimation-password"
                                class="form-control">
                            <span class="text-danger" id="confrimationPasswordE"></span>
                        </div>
                        <button type="button" onclick="resetPassword()" class="btn btn-success w-100 mt-2">Reset</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const resetPassword = async () => {
            let password = document.getElementById("password").value,
                confrimation_password = document.getElementById("confrimation-password").value;
            email = sessionStorage.getItem('email'),
                passwordE = document.getElementById('passwordE'),
                confrimationPasswordE = document.getElementById('confrimationPasswordE');

            if (password === '') {
                passwordE.textContent = 'Please enter your password';
                return;
            }
            if (confrimation_password === '') {
                passwordE.textContent = '';
                confrimationPasswordE.textContent = 'Please enter your confrimation_password';
                return;
            }
            if (password !== confrimation_password) {
                confrimationPasswordE.textContent = 'New password ro confirmation password is not mass!';
                return;
            }

            const response = await axios.post('/reset-password', {
                email: email,
                password: password
            });
            // console.log(response);
            if (response.status == 200) {
                sessionStorage.removeItem('email');
                window.location.href = "/login";
            }
        }
    </script>
@endsection
