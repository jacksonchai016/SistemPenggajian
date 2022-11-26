@extends('layouts.main')

@section('container')
    <div class="container">
        <div class="row">
            

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">User Access {{ $user_access->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/user_access') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/user_access/' . $user_access->id . '/edit') }}" title="Edit user_access"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('admin/user_access' . '/' . $user_access->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete user_access" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $user_access->id }}</td>
                                    </tr>
                                    <tr><th> Nama </th><td> {{ $user_access->nama }} </td></tr><tr><th> Email </th><td> {{ $user_access->email }} </td></tr>
                                    <tr>
                                        <th> Access </th>
                                        <td> 
                                    <?php 
                                    $access_keyword = $user_access->access_role;
                                    $json_data = json_decode('{"hr": "HR", "bpjs": "BPJS", "payroll": "Payroll"}' ,true);
                                    echo $json_data[$access_keyword];
                                    ?>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
