@extends('layouts.app')

@section('title','Dashboard - Utilisateurs')

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
                    <form action="{{ route('register.submit') }}" method="POST" >
                        @csrf
                        <div class="row">
                            <div class="col-xxl-8 col-xl-7 col-lg-7 col-md-6 col-sm-12 col-12">
                                {{-- <div class="row">
                                    <div class="col-sm-6 col-12">
                                        <div class="d-flex flex-row align-items-start gap-4">
                                            <img src="{{ asset('assets/images/user2.png') }}" class="img-fluid change-img-avatar" id="preview-image" alt="Image" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                                            <div>
                                                <input type="file" name="image" id="image-upload" accept="image/*" onchange="previewImage(event)" style="display: none;">
                                                <label for="image-upload" class="btn btn-outline-primary mt-2">
                                                    <i class="fa fa-upload me-1"></i> Choisir un fichier
                                                </label>
                                                <p class="text-muted mt-2">Formats acceptés : .jpg, .png, .jpeg</p>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="row">

                                    <div class="col-xxl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" placeholder="example@mail.com">
                                            @error('email')
                                              <p class="mb-4"> {{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                  
                                    <div class="settings-block">
                                        <div class="settings-block-title">Sélectionner un rôle</div>
                                        <div class="settings-block-body">
                                          <select name="role" class="form-select">
                                            @foreach($roles as $role)
                                              <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                      </div>
                                      
                                </div>
                            </div>

                            <div class="col-sm-12 col-12">
                                <hr>
                                <button type="submit" class="btn btn-info">Enregistrer</button>
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
@endsection

