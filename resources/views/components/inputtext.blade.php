
<div class="{{$inline}}">
    <div class="relative">
        <div class="absolute rounded-l w-10 h-full flex items-center justify-center" border text-gray-600"><i data-feather="{{$icon}}" class="text-sm"></i></div>
        <input type="text" autocomplete="off" @isset($required) @if($required=="true") required @endif @endisset @isset($alignright) @if($alignright=="true") style="text-align: right"  @endif @endisset  @isset($readonly) @if($readonly=="true") readonly @endif @endisset  id="{{$field}}" @isset($value) value="{{old($field) ? old($field) : $value}}"
        @else value="{{old($field)}}" @endisset  name="{{$field}}" class="input pl-12 w-{{$lebar}} border  @if($datepicker=='true') datepicker @endif   @error($field) error @enderror" placeholder="{{$label}}">
    </div>
    @error($field)
    <label id="name-error" class="error" for="name">{{ucwords($message)}}</label>
    @enderror
</div>

