@extends('admin::layouts.master')

@section('style')

@stop
@section('content-header')
    <h1>
         {!! $page->title !!}<small>创建</small>
    </h1>
@stop
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">

                @include('admin::client.news.from')
            </div>

        </div>
    </div>

@stop

@section('script')
    <script>
        var initialAjAx = {
            "url":"{!! route('m.client.news.store',['cid' => $page->id]) !!}",
            "backUrl":"{!! route('m.client.news.list',  ['cid' => $page->id]) !!}"
        }
    </script>
@stop