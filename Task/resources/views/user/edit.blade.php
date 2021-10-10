@include('include.header')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Add User</h1>
    </div>
    <!-- /.col-lg-12 -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit user form
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{ url('update-user/'.$user->id) }}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                                <div class="col-lg-4">
                                    <div class="form-group {{ $errors->has('firstname') ? ' has-error' : '' }}">
                                        <label>First name</label>
                                        <input type="text" id="firstname" name="firstname" class="form-control" value="{{ $user->firstname }}" required autofocus>
                                        @if ($errors->has('firstname'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('firstname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group {{ $errors->has('lastname') ? ' has-error' : '' }}">
                                        <label>Last name</label>
                                        <input type="text" id="lastname" name="lastname" class="form-control" value="{{ $user->lastname }}" required autofocus>
                                        @if ($errors->has('lastname'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label>Email</label>
                                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}"">
                                    <label>Password</label>
                                    <input type="password" id="password" name="password" class="form-control">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" id="confpassword" name="cpassword" class="form-control">

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group  {{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label>Phone</label>
                                <input type="number" id="number" min="0" name="phone" class="form-control" value="{{ old('phone') }}" required autofocus>
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Profile</label>
                                <input type="file" id="select_file" name="select_file" class="form-control">
                                <input type="hidden" name="image" id="imageName">

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                        <span id="uploaded_image" style="display: none;">
                            </div>
                        </div>
                        <div class="col-lg-12 my-3">
                            <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
                        </div>

                        </form>
                    </div>

                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
</div>
<!-- /.row -->
@include('include.footer')
<script>
    $(document).ready(function(){
        $("#uploaded_image").hide();

        $('#select_file').change(function(){
            //alert(" run f");

            var form_data = new FormData();
            var name = document.getElementById("select_file").files[0].name;
            var ext = name.split('.').pop().toLowerCase();
            if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1)
            {
                alert("Invalid Image File");
            }

            form_data.append("select_file", document.getElementById('select_file').files[0]);
            form_data.append("type","select_file");

            /*let reader = new FileReader();
            reader.onload = (e) => {
                $("#uploaded_image").show();
                $('#uploaded_image').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);*/
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{ route('user.profile.submit') }}",
                method:"POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success:function(data)
                {
                    //$('#message').css('display', 'block');
                    //$('#message').html(data.message);
                    //$('#message').addClass(data.class_name);
                    $('#uploaded_image').show();
                    $('#uploaded_image').html(data.uploaded_image);
                    $("#imageName").val(data.image_name);

                }
            })
        });
    });
</script>