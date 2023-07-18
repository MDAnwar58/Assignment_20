@extends('layouts.app')
@section('title', 'Home')

@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center pt-5">
            <div class="col-sm-6 col-md-4">
                <div class="card">
                    <h4 class="card-header text-center">Welcome to your home</h4>
                    <div class="card-body text-center">
                        <button type="button" onclick="logout()" class="btn btn-danger">Logout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

<script>
    const logout = async () =>
    {
        const response = await axios.get('/logout');
        if(response.status === 200)
        {
            window.location.href = "/login";
        }
    }
</script>

@endsection