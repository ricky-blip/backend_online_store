@extends('layouts.dashboard.master')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Pemesanan</h4>
                        {{-- <p class="card-description">
                            <a href="{{ route('add-checkout') }}" class="btn btn-sm btn-primary">Tambah</a>
                        </p> --}}
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered" id="myTable">
                                <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>
                                            Kode Transaksi
                                        </th>
                                        <th>
                                            Pemesan
                                        </th>
                                        <th>
                                            No. HP
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
                                    @foreach ($data as $checkout)
                                        @php
                                            $sts = $checkout->status;
                                            if($sts == '0') {
                                                $sts = '<span class="badge badge-info">Baru</span>';
                                            } elseif ($sts == '1') {
                                                $sts = '<span class="badge badge-warning">Diproses</span>';
                                            } elseif($sts == '2') {
                                                $sts = '<span class="badge badge-success">Selesai</span>';
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $checkout->kode_transaksi }}</td>
                                            <td>{{ $checkout->nama }}</td>
                                            <td>{{ $checkout->nohp }}</td>
                                            <td><?php echo htmlspecialchars_decode($sts) ?></td>
                                            <td>
                                                <a href="{{ route('detail-pemesanan', $checkout->id ) }}" class="btn btn-sm btn-success">Detail</a>
                                                {{-- <a href="{{ route('delete-checkout', $checkout->id ) }}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">Hapus</a> --}}
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
