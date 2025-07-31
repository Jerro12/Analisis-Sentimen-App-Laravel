@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Edit Novel</h2>

    @include('admin.novels._form', ['novel' => $novel])
@endsection
