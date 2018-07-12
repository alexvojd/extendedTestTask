@extends('layouts.structure')
@section('content')
<form method="POST" action="/" style="padding: 20px 15px 0 15px;">
    {{ csrf_field() }}
    <div class="form-group row">
        <select name="address" class="form-control" onchange="this.form.submit()">
            <option value="{{$currAddress}}">{{$currAddress}}</option>

            @foreach($addressList as $item)
                @if($item['address'] != $currAddress)
                    <option value="{{$item['address']}}">{{$item['address']}}</option>
                @endif
            @endforeach
        </select>
    </div>
    @if($isFiltered)
        <input type="submit" id="save" class="btn btn-block btn-danger" name="delete" value="Delete {{$currAddress}}">
    @endif
</form>
<table class="table" style="margin-top: 10px;">
    <thead class="thead-dark">
        <tr>
          <th>Area</th>
            @if($isFiltered)
                <th>Distance (kms)</th>
            @else
                <th>Latitude</th>
                <th>Longitude</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @if($isFiltered)
            @foreach($places as $address => $distance)
                    <tr>
                        <td>{{$address}}</td>
                        <td>{{$distance}}</td>
                    </tr>
            @endforeach
        @else
            @foreach($places as $place)
                <tr>
                    <td>{{$place->address}}</td>
                    <td>{{$place->lat}}</td>
                    <td>{{$place->lng}}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

@endsection