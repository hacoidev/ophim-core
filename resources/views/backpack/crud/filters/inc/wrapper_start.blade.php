@php
	$filter->wrapper = $filter->wrapper ?? $filter->wrapperAttributes ?? [];

    // each wrapper attribute can be a callback or a string
    // for those that are callbacks, run the callbacks to get the final string to use
    foreach($filter->wrapper as $attributeKey => $value) {
        $filter->wrapper[$attributeKey] = !is_string($value) && $value instanceof \Closure ? $value($crud, $filter, $entry ?? null) : $value ?? '';
    }
	// if the field is required in any of the crud validators (FormRequest, controller validation or field validation)
	// we add an astherisc for it. Case it's a subfield, that check is done upstream in repeatable_row.
	// the reason for that is that here the field name is already the repeatable name: parent[row][fieldName]
	if(!isset($filter->parentFieldName) || !$filter->parentFieldName) {
		$filterName = is_array($filter->name) ? current($filter->name) : $filter->name;
		$required = (isset($action) && $crud->isRequired($filterName)) ? ' required' : '';
	}

	// if the developer has intentionally set the required attribute on the field
	// forget whatever is in the FormRequest, do what the developer wants
	// subfields also get here with `showAsterisk` already set.
	$required = isset($filter->showAsterisk) ? ($filter->showAsterisk ? ' required' : '') : ($required ?? '');

	$filter->wrapper['class'] = $filter->wrapper['class'] ?? "form-group col-sm-12";
	$filter->wrapper['class'] = $filter->wrapper['class'].$required;
	$filter->wrapper['element'] = $filter->wrapper['element'] ?? 'div';
	$filter->wrapper['bp-field-wrapper'] = 'true';
	$filter->wrapper['bp-field-name'] = square_brackets_to_dots(implode(',', (array)$filter->name));
	$filter->wrapper['bp-field-type'] = $filter->type;
@endphp

<{{ $filter->wrapper['element'] }}
	@foreach($filter->wrapper as $attribute => $value)
	    {{ $attribute }}="{{ $value }}"
	@endforeach
>
