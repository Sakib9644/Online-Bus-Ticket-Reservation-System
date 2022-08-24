@extends('admin.master')

@section('content')
    <h3>Add Counter</h3>

    <form action="{{route('admin.counter.store')}}" method="POST">@csrf
        
        @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div>
                <p class="alert alert-danger">{{$error}}</p>
            </div>
        @endforeach
    @endif
    
    @if(session()->has('msg'))
        <p class="alert alert-success">{{session()->get('msg')}}</p>
    @endif

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Enter counter name</label>
        <select class="form-control" required name="counter name">
            <option value=""></option>
            <option value="Fakirapool, Dhaka">Fakirapool, Dhaka</option>
            <option value="Kamlapur, BRTC, Dhaka">Kamlapur, BRTC, Dhaka</option>
            <option value="Arambagh, Eden Complex, Dhaka">Arambagh, Eden Complex, Dhaka</option>
            <option value="Malibagh DIT Road, Dhaka">Malibagh DIT Road, Dhaka</option>
            <option value="Jhonson Road, SAARC Law Chambar Dhaka">Jhonson Road, SAARC Law Chambar Dhaka</option>
            <option value="Sydabad, Dhaka">Sydabad, Dhaka</option>
            <option value="Middle Badda, Dhaka">Middle Badda, Dhaka</option>
            <option value="Abdullahpur (Uttara) Sec# 9 Dhaka">Abdullahpur (Uttara) Sec# 9 Dhaka</option>
            <option value="Mohakhali Rail Gate, Dhaka">Mohakhali Rail Gate, Dhaka</option>
            <option value="Narayngonj">Narayngonj</option>
            <option value="Abdullahpur (Uttara) Sec# 9 Dhaka">Abdullahpur (Uttara) Sec# 9 Dhaka</option>
            <option value="Mohakhali Rail Gate, Dhaka">Mohakhali Rail Gate, Dhaka</option>
            <option value="Gabtoli">Gabtoli</option>
            <option value="Manikgonj">Manikgonj</option>
            <option value="Dampara CMP, Chittagong">Dampara CMP, Chittagong</option>
            <option value="AK Khan Gate, Chittagong">AK Khan Gate, Chittagong</option>
            <option value="Shetakunda, Chittagong">Shetakunda, Chittagong</option>
            <option value="Kolatoli, Cox’s Bazar">Kolatoli, Cox’s Bazar</option>
            <option value="Jhautola, Cox’s Bazar">Jhautola, Cox’s Bazar</option>
            <option value="Monihar, Jessore">Monihar, Jessore</option>
            <option value="Benapole Bazar">Benapole Bazar</option>
            <option value="Shibbari, Khulna">Shibbari, Khulna</option>
            <option value="Shatkhira Kaliganj Road">Shatkhira Kaliganj Road</option>
        </select>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Enter counter no</label>
            <input required name="counter no" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Enter counter phone number</label>
            <input required name="counter phone" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection