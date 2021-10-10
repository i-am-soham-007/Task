@include('include.header')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edit Profile</h1>
    </div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Edit Profile
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <form action="{{url('editprofile/'.$user->id)}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{csrf_token() }}">

                <div class="col-lg-3">
                    <div id="dbimage">
                    @if(isset($user->profile))
                        <img src="{{ asset('profile/'.$user->profile) }}" alt="{{ $user->profile }}"   id="img" style="border-radius: 10px;" height="200" width="200">
                    @else
                        <img src="{{ asset('profile/'.$user->profile) }}" id="img" height="200" width="200" style="border-radius: 10px;">
                    @endif
                     </div>
                    <span id="uploaded_image"></span>
                </div>
                    <input type="hidden" name="imageName" id="imageName">
                <div class="col-lg-9">
                        <div class="row">
                            <div class="col-lg-6">
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
                            <div class="col-lg-6">
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
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>First name</label>
                                    <input type="file" id="select_file" name="select_file" class="form-control" >
                                    <input type="hidden" id="image" name="image" class="form-control" >
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <label>Phone</label>
                                    <input type="text" id="phone" name="phone" class="form-control" value="{{ $user->phone }}" required autofocus>
                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" name="update" value="update" class="btn btn-info">Update Profile</button>
                            </div>

                        </div>

                </div>
                </form>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>

</div>
<!-- /.row -->
</div>
</div>
<!-- /.row -->
@include('include.footer')
<script>
    $(document).ready(function(){

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
                    $('#dbimage').hide();

                    $('#uploaded_image').show("");
                    $('#uploaded_image').html(data.uploaded_image);
                    $("#imageName").val(data.image_name);

                }
            })
        });
    });
</script>
