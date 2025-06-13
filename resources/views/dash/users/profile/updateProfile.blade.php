@extends('layouts.app')

@section('title','Dashboard - gerer les Utilisateurs')

@section('content')

<!-- Content wrapper start -->
<div class="content-wrapper">

    <!-- Row start -->
    <div class="row">
        <div class="col-xl-12">
            <!-- Card start -->
            <div class="card">
                <div class="card-body">

                    <!-- Row start -->
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12  col-12">
                                <div class="row">
                                    <div class="col-sm-6 col-12">
                                        <div class="d-flex flex-row align-items-start gap-4">
                                            {{-- <img src="{{ asset('assets/images/user2.png') }}" class="img-fluid change-img-avatar" id="preview-image" alt="Image" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;"> --}}
                                            <img src="{{ $user->image_url }}" class="img-fluid change-img-avatar" id="preview-image" alt="Image" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                                            <div>
                                                <input type="file" name="image" id="image-upload" accept="image/*" onchange="previewImage(event)" style="display: none;">
                                                <label for="image-upload" class="btn btn-outline-primary mt-2">
                                                    <i class="fa fa-upload me-1"></i> Choisir un fichier
                                                </label>
                                                <p class="text-muted mt-2">Formats acceptés : .jpg, .png, .jpeg</p>
                                            </div>
                                           
                                        </div>
                               
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xxl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">First Name</label>
                                            {{-- <input type="text" name="first_name" class="form-control" placeholder="First Name"> --}}
                                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}" placeholder="First Name">
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}" placeholder="Last Name">
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" placeholder="Username">
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" placeholder="example@mail.com">
                                            {{-- @error('email')
                                              <p class="mb-4"> {{ $message }}</p>
                                            @enderror  --}}
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Phone</label>
                                            <input type="number" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="77 000 00 00" pattern="^(77|76|78|70|75) \d{3} \d{2} \d{2}$" title="Format : 77 000 00 00">
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Address</label>
                                            <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}" placeholder="Address">
                                        </div>
                                    </div>
                                  
                                    
                                </div>
                            </div>
                            <div class="col-sm-12 col-12">
                                <hr>
                                <button type="submit" class="btn btn-info">Enregitrer les modifications</button>
                            </div>
                        </div>
                    </form>
                    <!-- Row end -->

                </div>
            </div>
            <!-- Card end -->
        </div>
    </div>
    <!-- Row end -->

</div>
<!-- Content wrapper end -->
<script>
    function previewImage(event) {
        const input = event.target;
        const reader = new FileReader();
        reader.onload = function(){
            document.getElementById('preview-image').src = reader.result;
        };
        if (input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

 {{-- Pour les roles --}}
 <script>
    function selectRole(role) {
        document.getElementById('role-input').value = role;

        document.querySelectorAll('.pricing-change-plan a').forEach(function(link) {
            link.classList.remove('active-plan');
        });

        event.currentTarget.classList.add('active-plan');
    }
</script>
@endsection

  
