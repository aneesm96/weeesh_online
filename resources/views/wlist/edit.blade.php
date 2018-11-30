@extends('layouts.app')

@section('content')
<div class="container">
    <h2>@lang("Edit A List")</h2><br  />
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
    @endif
    @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div><br />
    @endif
    <form method="post" action="{{action('WListController@update', $id_list)}}">
        {{csrf_field()}}
        <input name="_method" type="hidden" value="PATCH">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="name">@lang("Name"):</label>
                <input type="text" class="form-control" name="name" value="{{$wlist->name}}">
            </div>
        </div>

        <?php $listPrivacies = \Weeesh\ListPrivacy::pluck('name', 'id_list_privacy')->toArray() ?>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="name">@lang("Privacy"):</label>
                {!! Form::select('id_list_privacy',
                    $listPrivacies, $wlist->id_list_privacy, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <button type="submit" class="btn btn-success" style="margin-left:38px">@lang("Update List")</button>
            </div>
        </div>
    </form>
</div>
@endsection