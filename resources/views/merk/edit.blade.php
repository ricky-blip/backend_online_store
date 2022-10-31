@extends('layouts.dashboard.master')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            {{-- form input --}}
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit data Merk</h4>
                        <p class="card-description">
                            Basic form elements
                        </p>
                        @if (Session::get('failed'))
                            <div class="alert alert-warning">{{ Session::get('failed') }}</div>
                        @endif
                        <form class="forms-sample" action="{{ route('update-merk') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <div class="form-group">
                                <label for="exampleInputName1">Name</label>
                                <input type="text" class="form-control" id="exampleInputName1" name="merk_product" value="{{ $data->merk_product }}" placeholder="Name">
                            </div>
                           
                            <div class="form-group">
                                <label for="exampleSelectGender">Role</label>
                                <select class="form-control" id="exampleSelectGender" name="status">
                                    <option value="1" @if($data->status == '1') {{ 'selected' }}  @endif >Publish</option>
                                    <option value="0" @if($data->status == '0') {{ 'selected' }}  @endif>Not Publish</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <a href="{{ route('merk') }}" class="btn btn-light">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
