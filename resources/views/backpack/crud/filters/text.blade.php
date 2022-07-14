<!-- text input -->

<label>{!! $filter->label !!}</label>
@include('crud::filters.inc.translatable_icon')

@if (isset($filter->prefix) || isset($filter->suffix))
    <div class="input-group">
@endif
@if (isset($filter->prefix))
    <div class="input-group-prepend"><span class="input-group-text">{!! $filter->prefix !!}</span></div>
@endif
<input type="text" name="{{ $filter->name }}"
    value="{{ old_empty_or_null($filter->name, '') ?? ($filter->value ?? ($filter->default ?? '')) }}"
    @include('crud::filters.inc.attributes')>
@if (isset($filter->suffix))
    <div class="input-group-append"><span class="input-group-text">{!! $filter->suffix !!}</span></div>
@endif
@if (isset($filter->prefix) || isset($filter->suffix))
    </div>
@endif

{{-- HINT --}}
@if (isset($filter->hint))
    <p class="help-block">{!! $filter->hint !!}</p>
@endif
