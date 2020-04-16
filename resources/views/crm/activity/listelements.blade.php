@if(!empty($tableData))
    @foreach( $tableData as $date => $dataRows)
        <div class="row activity_row">
            <div class="container-fluid">
                <div class="activity_date">
                    {{ $date }}
                </div>
            </div>
            @foreach( $dataRows as $key => $rows)
                <div class="activity_doby">
                    {{ $rows[0]['formatedTitle'] }}
                    @foreach( $rows as $row)
                        {{ $row->formatedProperties }}
                    @endforeach
                </div>
            @endforeach
        </div>
    @endforeach
    <div class="activity_footer">
        <div class="float-right">
            {!! $paginator !!}
        </div>
    </div>
    @else
    Ничего не найдено
@endif
