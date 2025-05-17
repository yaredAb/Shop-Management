@if(session('success'))
    <div>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div>
        {{ session('error') }}
    </div>
@endif

<table class="order-table">
    <thead>
    <tr>
        @foreach($headers as $header)
            <th>{{$header}}</th>
        @endforeach
        @if(isset($hasActions) && $hasActions)
            <th>Actions</th>
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach($rows as $row)
        <tr>
            @foreach($row as $cell)
                <td>{{$cell}}</td>
            @endforeach
            @if(isset($hasActions) && $hasActions)
               <td class="actions">
                   {{--Action slot--}}
                   {{ $actionSlot($row['model']) }}
               </td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
