@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Add New Novel</h2>

    @include('admin.novels._form', ['novel' => new \App\Models\Novel()])
@endsection
