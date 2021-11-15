<div class="form-group  @error($field) error @enderror"">
    <div class=" form-label-group position-relative has-icon-left">
    <div class="controls">
        <div class="input-group">
            <input type="text" class="form-control" autocomplete="off" id="{{$field}}" @isset($value) value="{{old($field) ? old($field) : $value}}" @else value="{{old($field)}}" @endisset class="form-control  name=" {{$field}}" @isset($readonly) readonly @endisset" placeholder="{{$label}}">
            <div class="form-control-position">
                <i class="{{$icon}}"></i>
            </div>
            <div class="input-group-append" id="button-addon2">
                <button class="btn btn-primary waves-effect waves-light" id="search" type="button"><i class="feather icon-search"></i></button>
            </div>
        </div>
    </div>
</div>
</div>
