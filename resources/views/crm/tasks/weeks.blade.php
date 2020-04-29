@foreach($weeks as $week)
    <div class="col-2">
        <button class="btn btn-default task_data_goto" style="width: 240px"
                onclick="Task.setDate(this)"
                data-goto="{{$week['formated']}}">
            {{$week['start']}} - {{$week['end']}}
        </button>
    </div>
@endforeach
