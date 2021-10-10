@include('include.header')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">User list</h1>
    </div>

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            @if(session()->has('message.level'))
                <div class="alert alert-{{ session('message.level') }}">
                    {!! session('message.content') !!}
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">
                    user list
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                        <tr>
                            <th>firstname</th>
                            <th>lastname</th>
                            <th>email</th>
                            <th>phone</th>
                            <th>actions</th>
                            <th>actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)

                        <tr class="odd gradeX">
                            <td>{{ $user->firstname }}</td>
                            <td>{{ $user->lastname }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td><a href="{{url('editprofile/'.$user->id)}}" class="btn btn-warning"><i class="fa fa-pencil"></i> Edit</a></td>
                            <td>
                                <form action="{{ url('delete-user/'.$user->id)}}" method="post">

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" name="deleteuser" id="deleteuser"  class="btn btn-danger" value="deleteuser"><i class="fa fa-trash"></i> Delete</button>
                                </form>
                            </td>

                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->

                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
@include('include.footer')
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>
