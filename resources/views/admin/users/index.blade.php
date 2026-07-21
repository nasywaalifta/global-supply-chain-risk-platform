@extends('admin.layouts.app')

@section('title', 'Kelola User')

@section('header')
Kelola User
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="fw-bold">
        Kelola User
    </h2>

    <a href="{{ route('admin.users.create') }}"
       class="btn btn-primary">

        <i class="fas fa-plus me-2"></i>
        Tambah User

    </a>

</div>

@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                <tr>

                    <th width="80">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th width="150">Role</th>
                    <th width="220">Aksi</th>

                </tr>

                </thead>

                <tbody>

                @forelse($users as $user)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $user->name }}</td>

                    <td>{{ $user->email }}</td>

                    <td>

                        @if($user->role=='admin')

                            <span class="badge bg-danger">

                                Admin

                            </span>

                        @else

                            <span class="badge bg-primary">

                                User

                            </span>

                        @endif

                    </td>

                    <td>

                        <a href="{{ route('admin.users.edit',$user) }}"
                           class="btn btn-warning btn-sm">

                            <i class="fas fa-edit"></i>

                            Edit

                        </a>

                        <form
                            action="{{ route('admin.users.destroy',$user) }}"
                            method="POST"
                            class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('Yakin ingin menghapus user ini?')"
                                class="btn btn-danger btn-sm">

                                <i class="fas fa-trash"></i>

                                Hapus

                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5" class="text-center">

                        Belum ada data user.

                    </td>

                </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        {{ $users->links() }}

    </div>

</div>

@endsection