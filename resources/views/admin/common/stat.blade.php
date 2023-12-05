<div class="row mt-3 statistics-section">
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body d-flex align-items-center red-stats-bg"
                 onclick="window.location.replace('{{route('operation.index')}}');">
                <span class="number mr-2"></span>
                <span class="title">{{trans("Operations")}}</span>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="card">
            <div class="card-body d-flex align-items-center blue-stats-bg"
                 onclick="window.location.replace('{{route('operation.index')}}');">
                <span class="number mr-2"></span>
                <span class="title">{{ trans("Operators") }}</span>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="card">
            <div
                class="card-body d-flex align-items-center green-stats-bg"
                onclick="window.location.replace('{{route('operation.index')}}');">
                <span class="number mr-2"></span>
                <span class="title">{{trans("Readers")}}</span>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="card">
            <div
                class="card-body d-flex align-items-center orange-stats-bg">
                <span class="number mr-2"></span>
                <span class="title">{{trans("Days")}}</span>
            </div>
        </div>
    </div>
</div>
