@extends('layouts.app')
@section('title', 'Reset Password')

@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center pt-5">
            <div class="col-sm-4">
                <div class="card">
                    <h4 class="card-header text-center">Your Password Reset</h4>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success w-100 mt-2">Reset</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
