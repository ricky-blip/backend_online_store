@extends('layouts.dashboard.master')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            {{-- form input --}}
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit data User</h4>
                        <p class="card-description">
                            Basic form elements
                        </p>
                        @if (Session::get('failed'))
                            <div class="alert alert-warning">{{ Session::get('failed') }}</div>
                        @endif
                        <form class="forms-sample" action="{{ route('update-product') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <div class="form-group">
                                <label for="exampleInputName1">Merk</label>
                                <select name="merk_id" class="form-control">
                                    <option value="">--Pilih--</option>
                                    @foreach ($merk as $mrk)
                                        <option value="{{ $mrk->id }}" @if($data->merk_id == $mrk->id) {{ 'selected' }} @endif >{{ $mrk->merk_product }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail3">Nama</label>
                                <input type="text" class="form-control" id="exampleInputEmail3" name="nama_product"
                                    placeholder="Nama" value="{{ $data->nama_product }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputHarga4">Harga</label>
                                <input type="number" class="form-control" name="harga" id="exampleInputHarga4"
                                    placeholder="Harga" value="{{ $data->harga }}">
                            </div>
                            <div class="form-group">
                                <label>Gambar</label>
                                <input type="file" name="gambar" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled
                                        placeholder="Upload Image">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                    </span>
                                </div>
                                {{-- <img src="{{ asset('storage/'. $data->gambar ) }}" width="300px" srcset=""> --}}
                                <img src="{{  $data->gambar  }}" width="300px" srcset="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputSpesifikasi4">Spesifikasi</label>
                                <textarea name="spesifikasi" class="form-control" id="editor" cols="30" rows="10">{{ $data->spesifikasi }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleSelectGender">Status</label>
                                <select class="form-control" id="exampleSelectGender" name="status">
                                    <option value="0" @if($data->status == '0') {{ 'selected' }} @endif >Unpublish</option>
                                    <option value="1" @if($data->status == '1') {{ 'selected' }} @endif>Publish</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleSelectGender">Recomended?</label>
                                <select class="form-control" id="exampleSelectGender" name="rekomendasi">
                                    <option value="0" @if($data->rekomendasi == '0') {{ 'selected' }} @endif >No</option>
                                    <option value="1" @if($data->rekomendasi == '1') {{ 'selected' }} @endif>Yes</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <a href="{{ route('product') }}" class="btn btn-light">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
    <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
        <script src="{{ asset('admin-template/js/file-upload.js') }}"></script>
    @endpush
@endsection
