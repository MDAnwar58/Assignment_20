@extends('layouts.app')
@section('title', 'Forget Password')

@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center pt-5">
            <div class="col-md-4 col-sm-6">
                <div class="card">
                    <h4 class="card-header text-center">Verify OTP</h4>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="otp">OTP</label>
                            <input type="number" name="otp" id="otp" class="form-control">
                        </div>
                        <button type="submit" onclick="otpVerify()" class="btn btn-success w-100 mt-2">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        const otpVerify = async () => {
            let email = sessionStorage.getItem('email');
            let otp = document.getElementById("otp").value;
            
            const response = await axios.post('/verify-otp', {
                email: email,
                otp: otp
            });
            // console.log(response);
            if(response.status == 200) {
                // sessionStorage.removeItem('email');
                window.location.href = "/reset-password";
            }
        }
    </script>
@endsection