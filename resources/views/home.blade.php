@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $info[ 'status' ]}}</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-resposive">
                    <form action="/absensi" method="post">
                    {{csrf_field()}}
                    <tr>
                        <td>
                        <input type= "text" class="form-control" placeholder="Keterangan..."
                        name= "note"> 
                        </td>

                        <td>
                        <button type="submit" class= "btn btn-flat btn-primary" name= "btnIn" {{$info[ 'btnIn' ]}}>
                        ABSEN MASUK</button>
                        </td>

                        <td>
                        <button type="submit" class= "btn btn-flat btn-primary" name= "btnOut" {{$info[ 'btnOut' ]}}>
                        ABSEN KELUAR</button>
                        </td>
                    
                    </tr>
                    </form>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Riwayat Absensi</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-responsive table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Keterangan</th>
                    </tr>

                    </thead>
                    <tbody>
                    @forelse($data_absensi as $absensi)
                        <tr>
                            <td>{{$absensi->date}}</td>
                            <td>{{$absensi->time_in}}</td>
                            <td>{{$absensi->time_out}}</td>
                            <td>{{$absensi->note}}</td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="4"><b><i>TIDAK ADA DATA UNTUK DITAMPILKAN</i></b></td>
                    </tr>
                    @endforelse
                    </tbody>
                    
                    </table>
                    {!! $data_absensi->Links()!!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
