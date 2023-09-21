@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Utility Providers Management</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('utility_provider.create') }}"> Create New Utility Provider</a>
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif

<table class="table table-bordered">
 <tr>
   <th>No</th>
   <th>Provider Name</th>
   <th>Provider Code</th>
   <th>Provider Status</th>
   <th width="280px">Action</th>
 </tr>
 @foreach ($providers as $key => $provider)
  <tr>
    <td>{{ ++$i }}</td>
    <td>{{ $provider->provider_name }}</td>
    <td>{{ $provider->provider_code }}</td>
    <td>{{ $provider->provider_status }}</td>
    {{-- <td>
      @if(!empty($user->getRoleNames()))
        @foreach($user->getRoleNames() as $v)
           <label class="badge badge-success">{{ $v }}</label>
        @endforeach
      @endif
    </td> --}}
    <td>
       <a class="btn btn-info" href="{{ route('utility_provider.show',$provider->id) }}">Show</a>
       <a class="btn btn-primary" href="{{ route('utility_provider.edit',$provider->id) }}">Edit</a>
        {{-- {!! Form::open(['method' => 'DELETE','route' => ['provider.destroy', $provider->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!} --}}
    </td>
  </tr>
 @endforeach
</table>

{{-- {!! $data->render() !!} --}}

@endsection