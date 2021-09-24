@extends('layouts.master')
@section('title', 'ECommerce')
@section('content')
<br>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Log in</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login-submit') }}" id="login_form">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                            <span class="text-danger error-text email_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password">
                            <span class="text-danger error-text password_error"></span>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>                  
                        <button type="submit" class="btn btn-primary" id="submitLogin">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>            
</div>

<br>

<script>
    $(document).ready(function(){
        //$('#submitLogin').on('click', function(){   // Also works
        $('#login_form').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url:$(this).attr('action'),
                method:$(this).attr('method'),
                data:new FormData(this),
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend:function(){
                    $(document).find('span.error-text').text('');
                },
                success:function(data){
                    if (data.status==0) {
                        $.each(data.error, function(prefix, value) {
                            $('span.' + prefix + '_error').text(value[0]);
                        });
                    } else if (data.status==1) {
                        alert(data.msg);
                        //$('span.match_error').text(data.msg);
                    } else {
                        //alert(data.status);
                        $('#login_form')[0].reset();
                        const base_path = '{{ url('/') }}\/';
                        alert(base_path);
                        window.location.href = base_path + 'products';
                    }
                }
            });
        })
    });
    
</script>
@endsection