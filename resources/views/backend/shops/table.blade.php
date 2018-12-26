<table class="table table-responsive" id="shops-table">
    <thead>
        <tr>
            <th>Name</th>
        <th>Description</th>
        <th>Icon</th>
        <th>Lng</th>
        <th>Lat</th>
        <th>Slug</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($shops as $shop)
        <tr>
            <td>{!! $shop->name !!}</td>
            <td>{!! $shop->description !!}</td>
            <td>{!! $shop->icon !!}</td>
            <td>{!! $shop->lng !!}</td>
            <td>{!! $shop->lat !!}</td>
            <td>{!! $shop->slug !!}</td>
            <td>
                {!! Form::open(['route' => ['backend.shops.destroy', $shop->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('backend.shops.show', [$shop->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('backend.shops.edit', [$shop->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>