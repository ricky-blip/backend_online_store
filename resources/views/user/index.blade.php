@extends('layouts.dashboard.master')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data User</h4>
                        <p class="card-description">
                            @if (Auth::user()->role == '1')
                            <a href="{{ route('add-user') }}" class="btn btn-sm btn-primary">Tambah</a>
                            @endif
                        </p>
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Email
                                        </th>
                                        <th>
                                            Role
                                        </th>
                                        <th>
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $user)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ Auth::user()->role == '1' ?  $user->email : 'xxxxxxxx' }}</td>
                                            <td>{{ Auth::user()->role == '1' ? role_user($user->role) : 'xxxxxxxx' }}</td>
                                            <td>
                                                
                                                {{-- button edit & hapus ada hanya jika yg login rolenya adalah 1 /admin --}}
                                                @if (Auth::user()->role == '1')
                                                    <a href="{{ route('edit-user', $user->id ) }}" class="btn btn-sm btn-success">Edit</a>

                                                    {{-- button hapus tidak ada jika data user yg tampil di tabel sama dengan data user yg sedang login --}}
                                                    @if (Auth::user()->id != $user->id)
                                                        <a href="{{ route('delete-user', $user->id ) }}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                                                    @endif   

                                                @elseif(Auth::user()->role == '2')
                                                    {{-- jika role 2 / kasir maka hanya tampilkan button edit --}}
                                                    {{-- button editny harus punya dia sendiri --}}
                                                    @if (Auth::user()->id == $user->id)
                                                        <a href="{{ route('edit-user', $user->id ) }}" class="btn btn-sm btn-success">Edit</a>
                                                    @endif
                                                    
                                                @endif

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
