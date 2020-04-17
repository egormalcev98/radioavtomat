<div class="activity_description">
    <i class="{{ $iconClass }}"></i>
    <div class="activity_description_text">
        <u><b>{{ $name }}</b></u> {{ $text }} <b>{{ $old }}
            @if($new)
                <i class="fas fa-arrow-circle-right"></i> {{ $new }}
            @endif
        </b>
    </div>
    <div class="float-right">
        <i class="fa fa-clock"></i> {{ $time }}
    </div>
    <div class="activity_description_properties">
        @if(isset($properties) and $properties)
            @foreach($properties as $property)
                <div class="activity_description_properties_foreach">
                    {{ $property['caption'] }}: {{ $property['old'] }} <i class="fas fa-arrow-right"></i> {{ $property['new'] }}
                </div>
            @endforeach
        @endif
    </div>
</div>
