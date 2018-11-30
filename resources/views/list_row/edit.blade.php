@extends('layouts.app')

@section('content')
<div class="container">
    <h2>@lang("Edit an Object in list:")
        <a href="{{action('WListController@show', $list_row->id_list)}}"><b>{{ $list_row->wlist->name }}</b></a>
    </h2><br  />
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

    {!! Form::model($list_row, array('method' => 'put',
        'route' => array('wlists.list_rows.update', $list_row->id_list, $list_row->id_list_row), 'class' => 'form')) !!}

        {{csrf_field()}}
        <input name="_method" type="hidden" value="PATCH">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="object">@lang("Name"):</label>
                <input type="text" class="form-control" name="object" value="{{$list_row->object}}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="link_web">@lang("Link"):</label>
                <input type="text" class="form-control" name="link_web" value="{{$list_row->link_web}}">
            </div>
        </div>


        <?php $listPrivacies = \Weeesh\ListPrivacy::pluck('name', 'id_list_privacy')->toArray() ?>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="name">@lang("Privacy"):</label>
                {!! Form::select('id_list_privacy',
                    $listPrivacies, $list_row->id_list_privacy, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <button type="submit" class="btn btn-success" style="margin-left:38px">@lang("Update Object")</button>
            </div>
        </div>
    </form>
</div>
@endsection