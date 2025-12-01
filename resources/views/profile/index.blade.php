@extends('layouts.dashboard')

@section('content')

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>My Profile</h3>
                <p class="text-subtitle text-muted">View your personal information and employment details</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="avatar avatar-4xl position-relative">
                                <img src="{{ $user->employee && $user->employee->profile_picture
                                    ? asset('storage/' . $user->employee->profile_picture)
                                    : ($user->employee && $user->employee->gender == 'female'
                                        ? asset('mazer/dist/assets/static/images/faces/2.jpg')
                                        : asset('mazer/dist/assets/static/images/faces/1.jpg')) }}"
                                     alt="Profile Picture"
                                     style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;">

                                <!-- Upload button overlay -->
                                <button type="button" class="btn btn-primary btn-sm position-absolute"
                                        style="bottom: 0; right: 0; border-radius: 50%; width: 32px; height: 32px; padding: 0;"
                                        data-bs-toggle="modal" data-bs-target="#uploadPictureModal">
                                    <i class="bi bi-camera"></i>
                                </button>
                            </div>

                            <h3 class="mt-3">{{ $user->employee->name ?? $user->name }}</h3>
                            <p class="text-small">{{ $user->employee->position->name ?? 'No Position' }}</p>
                            <p class="text-muted text-small">{{ $user->employee->unit->name ?? 'No Unit' }}</p>

                            <div class="mt-3">
                                <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-pencil-square"></i> Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Personal Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">Full Name</label>
                                    <p class="form-control-static">{{ $user->employee->name ?? $user->name }}</p>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">Employee Code</label>
                                    <p class="form-control-static">{{ $user->employee->employee_code ?? '-' }}</p>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <p class="form-control-static">{{ $user->email }}</p>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">Phone</label>
                                    <p class="form-control-static">{{ $user->employee->phone ?? '-' }}</p>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">Gender</label>
                                    <p class="form-control-static">{{ ucfirst($user->employee->gender ?? '-') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">NIK</label>
                                    <p class="form-control-static">{{ $user->employee->nik ?? '-' }}</p>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">NPWP</label>
                                    <p class="form-control-static">{{ $user->employee->npwp ?? '-' }}</p>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">Birth Place</label>
                                    <p class="form-control-static">{{ $user->employee->birth_place ?? '-' }}</p>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">Birth Date</label>
                                    <p class="form-control-static">
                                        {{ $user->employee->birth_date ? \Carbon\Carbon::parse($user->employee->birth_date)->format('d F Y') : '-' }}
                                    </p>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">Address</label>
                                    <p class="form-control-static">{{ $user->employee->address ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title">Employment Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">Position</label>
                                    <p class="form-control-static">{{ $user->employee->position->name ?? '-' }}</p>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">Unit/Department</label>
                                    <p class="form-control-static">{{ $user->employee->unit->name ?? '-' }}</p>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">Employment Status</label>
                                    <p class="form-control-static">
                                        <span class="badge bg-{{ $user->employee->employment_status == 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($user->employee->employment_status ?? 'Unknown') }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">Hire Date</label>
                                    <p class="form-control-static">
                                        {{ $user->employee->hire_date ? \Carbon\Carbon::parse($user->employee->hire_date)->format('d F Y') : '-' }}
                                    </p>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">End Date</label>
                                    <p class="form-control-static">
                                        {{ $user->employee->end_date ? \Carbon\Carbon::parse($user->employee->end_date)->format('d F Y') : 'Active' }}
                                    </p>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">Account Role</label>
                                    <p class="form-control-static">
                                        <span class="badge bg-primary">{{ ucfirst($user->role ?? 'User') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Upload Picture Modal -->
<div class="modal fade" id="uploadPictureModal" tabindex="-1" aria-labelledby="uploadPictureModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadPictureModalLabel">Upload Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profile.upload-picture') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">Choose Picture</label>
                        <input type="file" class="form-control" id="profile_picture" name="profile_picture"
                               accept="image/jpeg,image/png,image/jpg,image/gif" required>
                        <div class="form-text">Max file size: 2MB. Supported formats: JPEG, PNG, JPG, GIF</div>
                    </div>

                    <!-- Image Preview -->
                    <div class="mb-3" id="imagePreview" style="display: none;">
                        <label class="form-label">Preview:</label>
                        <div class="text-center">
                            <img id="previewImg" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 10px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload Picture</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Image preview functionality
document.getElementById('profile_picture').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});
</script>

@endsection
