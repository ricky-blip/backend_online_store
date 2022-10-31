@extends('layouts.dashboard.master')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Merk</h4>
                        <p class="card-description">
                            <a href="{{ route('add-merk') }}" class="btn btn-sm btn-primary">Tambah</a>
                        </p>
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered" id="myTable">
                                <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>
                                            Merk
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $merk)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $merk->merk_product }}</td>
                                            <td>{{ $merk->status == '1' ? 'Publish' : 'Unpublish' }}</td>
                                            <td>
                                                <a href="{{ route('edit-merk', $merk->id ) }}" class="btn btn-sm btn-success">Edit</a>
                                                <a href="{{ route('delete-merk', $merk->id ) }}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
