@extends('admin::layouts.master')

@section('style')

@stop
@section('content-header')
    <h1>
        页面<small>编辑</small>
    </h1>
@stop
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">

                @include('admin::client.page.from')
            </div>

        </div>
    </div>

@stop

@section('script')
    <script>
        var initialAjAx = {
            "url":"{!! route('m.client.page.update', ['id' => $info->id]) !!}",
            "backUrl":"{!! route('m.client.page.list', ['template' => $info->template]) !!}"
        }
    </script>
@stop