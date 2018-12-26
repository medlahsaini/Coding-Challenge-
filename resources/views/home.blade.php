@extends('layouts.app')

@section('content')
<div class="container">
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; grid-gap: 60px 30px;  padding: 50px 0;">
    @foreach ($shops as $shop)
        <div class="card">
            <img class="card-img-top" src=".../100px180/" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">{{ $shop->name }}</h5>
                <p class="card-text">{{ $shop->description }}.</p>
                <a href="/home/dislike/{{$shop->id}}" class="btn btn-danger">Dislike</a>
                <a href="/home/likehome/{{$shop->id}}" class="btn btn-success float-right">Like</a>
            </div>
            </div>
    @endforeach
    </div>
    
    
</div>
@endsection

@section('script')
    <script>
    @auth
        window.onload = function() {getLocation()};
                function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);                
                } else { 
                    alert ('Geolocation is not supported by this browser.');
                }
                }

                function showPosition(position) {
                    $.ajax({
                        url:"/location",
                        method:"GET",
                        data:{
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                            },
                        datatype:'json',
                        success:function(data){
                            console.log(data);
                        }
                    });
                
                }
    @endauth
    </script>
@endsection
