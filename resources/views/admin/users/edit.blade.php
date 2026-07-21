@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-user-edit text-primary me-2"></i>
                Edit User
            </h2>
            <p class="text-muted mb-0">Perbarui data akun {{ $user->name }}.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary px-4 rounded-3">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger rounded-3 shadow-sm mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" class="form-control rounded-3 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required placeholder="Masukkan nama lengkap" style="height: 48px;">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold">Alamat Email</label>
                        <input type="email" class="form-control rounded-3 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required placeholder="nama@domain.com" style="height: 48px;">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="role" class="form-label fw-semibold">Role / Hak Akses</label>
                        <select class="form-select rounded-3 @error('role') is-invalid @enderror" id="role" name="role" required style="height: 48px;">
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User (Analyst)</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin (Full Access)</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 border-top my-4 pt-3">
                        <h5 class="fw-semibold text-secondary">Ubah Password <small class="text-muted fw-normal">(Kosongkan jika tidak ingin diubah)</small></h5>
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label fw-semibold">Password Baru</label>
                        <input type="password" class="form-control rounded-3 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Minimal 8 karakter" style="height: 48px;">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control rounded-3" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" style="height: 48px;">
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary px-5 rounded-3 py-2.5" style="height: 48px;">
                            <i class="fas fa-save me-2"></i> Perbarui User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
