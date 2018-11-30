@extends('layouts.app')

@section('content')

<!-- create.blade.php -->
<!-- https://appdividend.com/2017/08/20/laravel-5-5-tutorial-example/#Step_3_Create_a_model_as_well_as_migration_file_for_our_Products_table -->
    <div class="container">


        <div class="row">
            <div class="col-md-12 text-center">
                <div class="btn btn-group cen">
                    @lang("Create A List")
                </div>
            </div>
        </div>


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

      <form method="post" action="{{url('wlists')}}" enctype="multipart/form-data">
          {{csrf_field()}}
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <label for="name">@lang("Name"):</label>
            <input type="text" class="form-control" name="name" value="{{old('name')}}">
          </div>
        </div>

          <div class="row">
              <div class="col-md-4"></div>
              <div class="form-group col-md-4">
                  <label for="date_valide_to">@lang("Valide to"):</label>
                  <input type="date" class="form-control" name="date_valide_to"
                         value="{{old('date_valide_to')}}">
              </div>
          </div>

          <div class="row">
              <div class="col-md-4"></div>
              <div class="form-group col-md-4">
                  <label for="image">@lang("Image"):</label>
                  <input type="file" class="form-control" name="image" value="{{old('image')}}">
              </div>
          </div>


      <?php $listPrivacies = \Weeesh\ListPrivacy::pluck('name', 'id_list_privacy')->toArray() ?>

          <div class="row">
              <div class="col-md-4"></div>
              <div class="form-group col-md-4">
                  <label for="name">@lang("Visibility"):</label>
                  {!! Form::select('id_list_privacy', $listPrivacies, null, ['class' => 'form-control']) !!}
              </div>
          </div>




        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <button type="submit" class="btn btn-success" style="margin-left:38px">@lang("Insert List")</button>
          </div>
        </div>
      </form>
    </div>
@endsection