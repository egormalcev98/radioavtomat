<div class="row">
    <div class="col-5">
        <div class="form-group">
            @php
                $wayFilter = Illuminate\Support\Facades\Cookie::get('activity_way');
            @endphp
            <button onclick="Activity.radioCheck($(this))" type="radio" name="activity_way" class="btn btn-default activity_btn
            @if(!$wayFilter) activity_btn_active @endif ">Все
            </button>
            <button onclick="Activity.radioCheck($(this))" type="radio" name="activity_way" value="in"
                    class="btn btn-default activity_btn   @if($wayFilter == 'in') activity_btn_active @endif ">Входящие
            </button>
            <button onclick="Activity.radioCheck($(this))" type="radio" name="activity_way" value="out"
                    class="btn btn-default activity_btn @if($wayFilter == 'out') activity_btn_active @endif">Исходящие
            </button>
        </div>
    </div>

    <div class="col-5">
        <div class="input-group">
            <input oninput="Activity.search()" class="form-control" name="search" id="activity_search"
                   value="{{  Illuminate\Support\Facades\Cookie::get('activity_search') }}">
            <div class=input-group-append">
                <span class="input-group-text">
                    <i class="fas fa-search activity_search_span"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="col-2">
    </div>
</div>
