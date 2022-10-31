@extends('layouts.dashboard.master')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            {{-- form input --}}
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tambah data User</h4>
                        <p class="card-description">
                            Basic form elements
                        </p>
                        @if (Session::get('failed'))
                            <div class="alert alert-warning">{{ Session::get('failed') }}</div>
                        @endif
                        <form class="forms-sample" action="{{ route('store-user') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputName1">Name</label>
                                <input type="text" class="form-control" id="exampleInputName1" name="name" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail3">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail3" name="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword4">Password</label>
                                <input type="password" class="form-control" name="password" id="exampleInputPassword4"
                                    placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="exampleSelectGender">Role</label>
                                <select class="form-control" id="exampleSelectGender" name="role">
                                    <option value="1">Admin</option>
                                    <option value="2">Kasir</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <a href="{{ route('user') }}" class="btn btn-light">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
