@extends('layouts.dashboard.master')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Laptop</h4>
                        <p class="card-description">
                            <a href="{{ route('add-product') }}" class="btn btn-sm btn-primary">Tambah</a>
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
                                            Nama
                                        </th>
                                        <th>
                                            Harga
                                        </th>
                                        <th>
                                            Gambar
                                        </th>
                                        <th>
                                            Spesifikasi
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Recomended
                                        </th>
                                        <th>
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $product)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $product->merk->merk_product }}</td>
                                            <td>{{ $product->nama_product }}</td>
                                            <td>{{ format_rupiah($product->harga) }}</td>
                                            <td>
                                                {{-- <img src="{{ asset('storage/' . $product->gambar) }}" width="500"
                                                    srcset=""> --}}
                                                <img src="{{ $product->gambar }}" width="500"
                                                    srcset="">
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars_decode($product->spesifikasi) ?>
                                            </td>
                                            <td>{{ status_publish($product->status) }}</td>
                                            <td>{{ $product->rekomendasi == '1' ? 'Yes' : 'No' }}</td>
                                            <td>
                                                <a href="{{ route('edit-product', $product->id) }}"
                                                    class="btn btn-sm btn-success">Edit</a>
                                                <a href="{{ route('delete-product', $product->id) }}"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
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
