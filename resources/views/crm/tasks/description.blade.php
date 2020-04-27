<div style="max-width: 250px">
    @if($status)
        <div>
            Статус: <div style="float: right">{{$status}}</div>
        </div>
    @endif
    @if($doc)
        <div>
            Док.№: <div style="float: right">{{$doc}}</div>
        </div>
    @endif
        @if($user)
            <div>
                Отв.: <div style="float: right">{{$user}}</div>
            </div>
        @endif
</div>
