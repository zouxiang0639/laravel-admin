<li class="dd-item" data-id="{{ $branch[$keyName] }}">
    <div class="dd-handle">
        {!! $branchCallback($branch) !!}
        <span class="pull-right dd-nodrag">
             <a href="{!! route('m.client.nav.edit', ['id' => $branch[$keyName]]) !!}"><i class="fa fa-edit" style="color: #F56954"></i></a>
            @if(!empty($branch['route']))
                <a href="{!! route($branch['route'], ['cid' => $branch['page_id']]) !!}"><i style="color: #F56954" class="fa fa-align-justify"></i></a>
            @endif

            <a href="{!! route('m.client.nav.edit', ['id' => $branch[$keyName]]) !!}"><i class="fa fa-edit"></i></a>
            <a href="javascript:void(0);" data-url="{!! route('m.client.nav.destroy', ['id' => $branch[$keyName]])!!}" class="item-delete"><i class="fa fa-trash"></i></a>
        </span>
    </div>
    @if(isset($branch['children']))
    <ol class="dd-list">
        @foreach($branch['children'] as $branch)
            @include($branchView, $branch)
        @endforeach
    </ol>
    @endif
</li>