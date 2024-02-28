@extends('backend.layouts.app')
@section('title', 'Add Vendor')
@section('content')

    <div class="row">

        <div class="col-xl-12">
            <div class="callout callout-info mt-2">
                <div class="row">

                    <div class="col-md-6  mt-2">
                        <h5><i class="nav-icon fa fa-user-plus"></i> Add Vendor</h5>
                    </div>
                    <div class="col-md-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Edit Vendor</li>
                        </ol>
                    </div><!-- /.col -->
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card" style="border-radius: 15px;">
                @if (session('success'))
                    <script>
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-right',
                            iconColor: 'white',
                            customClass: {
                                popup: 'colored-toast',
                            },
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                        })

                        ;
                        (async () => {
                            Toast.fire({
                                icon: 'success',
                                title: "{{ session('success') }}",
                            })

                        })()
                    </script>
                @endif
                <form action="{{ route('vendor.update',$vendor->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row align-items-center pt-2 pb-1"> <!--row Start -->
                            <div class="col-md-2 ps-5">
                                <h6 class="mb-0">Vendor Name</h6>
                            </div>

                            <div class="col-md-10 pe-5">
                                <input type="text" name="name"
                                    class="form-control form-control-lg  @if ($errors->has('name')) is-invalid @elseif(old('name')) is-valid @endif"
                                    placeholder="Vendor Name" value="{{ old('name') ?? $vendor->name }}" />
                                @error('name')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                        </div> <!--row end -->

                        <hr class="mx-n3">

                        <div class="row align-items-center pt-2 pb-1"> <!--row Start -->
                            <div class="col-md-2 ps-5">
                                <h6 class="mb-0">Vendor Phone</h6>
                            </div>
                            <div class="col-md-10 pe-5">
                                <input type="text" name="phone"
                                    class="form-control form-control-lg  @if ($errors->has('phone')) is-invalid @elseif(old('phone')) is-valid @endif"
                                    placeholder="Vendor phone" value="{{ old('phone') ?? $vendor->phone }}" />
                                @error('phone')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div> <!--row end -->

                        <hr class="mx-n3">

                        <!-- ./row -->

                        <div class="row align-items-center pt-2 pb-1"> <!--row Start -->
                            <div class="col-md-2 ps-5">
                                <h6 class="mb-0">Vendor Address</h6>
                            </div>

                            <div class="col-md-10 pe-5">
                                <div class="card card-outline card-info">

                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <!-- Hidden input for Summernote content -->
                                        <input type="hidden" id="content_details" name="hidden_deatils">
                                        <textarea id="summernote" name="content_details"> {{ old('address') ?? $vendor->address }}</textarea>
                                    </div>

                                </div>
                            </div>
                            <!-- /.col-->
                        </div>
                        <!-- ./row -->

                        <div class="row align-items-center py-1 mt-2"> <!--row Start -->
                            <div class="col-md-4 ps-5"> </div>
                            <div class="col-md-3 pe-5">
                                <button type="reset"  onclick="resetSummernote()" class="btn btn-default">Reset</button>
                                <button type="submit" class="btn btn-info">Submit</button>
                            </div>
                        </div> <!--row end -->

                    </div> <!--card body End-->

                </form>

            </div>
        </div>
    </div>


    </div>

    <script>
         $(document).ready(function() {
                        // Get the Summernote content
                        var summernoteContent = $('#summernote').summernote('code');

                        // Set the Summernote content to the hidden input
                        $('#content_details').val(summernoteContent);

                        $('#summernote').summernote({
                            disableReturn: true,
                            height: 300,

                            // other options...
                        });

                        // Submit the form
                        //this.submit();
                    });

                    function resetSummernote() {
    // Reset Summernote content
    $('#summernote').summernote('code', '');

    // Reset hidden input value
    $('#content_details').val('');
}
    </script>





@endsection
