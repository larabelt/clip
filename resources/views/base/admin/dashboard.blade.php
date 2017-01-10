@extends('ohio-core::layouts.admin.main')

@section('scripts-body-close')
    @parent
    <script src="/js/ohio-storage.js"></script>
@endsection

@section('main')

    <div id="ohio-storage">
        <router-view></router-view>
    </div>

@stop