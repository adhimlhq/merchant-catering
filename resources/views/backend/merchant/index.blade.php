@extends('dashboard')

@section('admin')
<div class="container">
    <h1>Daftar Merchant</h1>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Nama Perusahaan</th>
                <th>Alamat</th>
                <th>No. Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($merchants as $merchant)
            <tr>
                <td>{{ $merchant->company_name }}</td>
                <td>{{ $merchant->address }}</td>
                <td>{{ $merchant->contact }}</td>
                <td>
                    <a href="{{ route('merchant.show', $merchant) }}" class="btn btn-info">Lihat</a>
                    <a href="{{ route('merchant.edit', $merchant) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('merchant.destroy', $merchant) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
