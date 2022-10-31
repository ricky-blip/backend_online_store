@extends('layouts.dashboard.master')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Pemesanan</h4>
                      
                        @if (Session::get('success')) {{-- jika ada session yg bernama success (diambil dari controller (with->([ 'success' => "pesannya" ])) ) --}}

                        <div class="alert alert-success">
                            <strong>Success!</strong> {{ Session::get('success') }}
                        </div>

                        @elseif(Session::get('failed')) {{-- jika ada session yg bernama failed (diambil dari controller (with->([ 'failed' => "pesannya" ])) ) --}}

                        <div class="alert alert-warning">
                            <strong>Failed!</strong> {{ Session::get('failed') }}
                        </div>

                        @endif
                        
                        {{-- detail pemesanan --}}
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Kode Transaksi</th>
                                        <th>:</th>
                                        <th>{{ $data->kode_transaksi }}</th>
                                    </tr>
                                    <tr>
                                        <th>Pemesan</th>
                                        <th>:</th>
                                        <th>{{ $data->nama }}</th>
                                    </tr>
                                    <tr>
                                        <th>No.HP</th>
                                        <th>:</th>
                                        <th>{{ $data->nohp }}</th>
                                    </tr>
                                    <tr>
                                        <th>Kota & Kecamatan</th>
                                        <th>:</th>
                                        <th>{{ $data->kota_kecamatan }}</th>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <th>:</th>
                                        <th>{{ $data->alamat }}</th>
                                    </tr>
                                    <tr>
                                        <th>Jenis Pembayaran</th>
                                        <th>:</th>
                                        <th>{{ $data->jenis_pembayaran }}</th>
                                    </tr>
                                    <tr>
                                        <th>Jenis Pengiriman</th>
                                        <th>:</th>
                                        <th>{{ $data->jenis_pengiriman }}</th>
                                    </tr>
                                    <tr>
                                        <th>Ongkir</th>
                                        <th>:</th>
                                        <th>Rp. {{ number_format($data->ongkir) }}</th>
                                    </tr>
                                    <tr>
                                        <th>Total Pemesanan</th>
                                        <th>:</th>
                                        <th>Rp. {{ number_format($data->grand_total) }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        {{-- item2 product yg dipesan --}}
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>
                                            Gambar
                                        </th>
                                        <th>
                                            Nama Product
                                        </th>
                                        <th>
                                            Harga Satuan
                                        </th>
                                        <th>
                                            Jumlah Beli
                                        </th>
                                        <th>
                                            Total Harga
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @foreach ($products as $pd)
                                       <tr>
                                           <td>{{ $loop->index + 1 }}</td>
                                           <td>
                                               <img src="{{ asset('storage/' . $pd->gambar) }}" width="250" srcset="">
                                           </td>
                                           <td>
                                               {{ $pd->merk_product }} {{ $pd->nama_product }}
                                           </td>
                                           <td>
                                               Rp. {{ number_format($pd->harga_satuan) }}
                                           </td>
                                           <td>
                                               {{ $pd->jumlah }}
                                           </td>
                                           <td>
                                             Rp. {{ number_format($pd->totalharga) }}
                                           </td>
                                       </tr>
                                   @endforeach
                                   <tr>
                                    <td colspan="4">Update Status</td>
                                    <td colspan="2">
                                        {{-- form update status pemesanan --}}
                                        <form action="{{ route('update-status-pemesanan') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $data->id }}">
                                            <div class="form-group">
                                                <select name="status" class="form-control" required>
                                                    <option value="">-Pilih-</option>
                                                    <option value="0" @if($data->status == '0') {{ 'selected' }} @endif>Baru</option>
                                                    <option value="1" {{ $data->status == '1' ? 'selected' : '' }}>Proses</option>
                                                    <option value="2" {{ $data->status == '2' ? 'selected' : '' }}>Selesai</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-info btn-block" type="submit">Update</button>
                                            </div>
                                        </form>
                                    </td>
                                   </tr>
                                </tbody>
                            </table>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
