{{-- form - start --}}
{!! renderInput('name', 'form.name', __('Name'), [
    'class' => 'col-md-4',
    'placeholder' => __('name'),
    'maxlength' => 255,
    'required' => true,
]) !!}

{!! renderInput('capital', 'form.capital', __('capital'), [
    'type' => 'number',
    'class' => 'col-md-4',
    'placeholder' => __('capital'),
    'required' => true,
]) !!}

{!! renderInput('vat', 'form.vat', __('vat'), [
    'class' => 'col-md-4',
    'placeholder' => __('vat'),
    'maxlength' => 255,
    'required' => true,
]) !!}

{!! renderInput('common_identifier', 'form.common_identifier', __('common_identifier'), [
    'type' => 'number',
    'class' => 'col-md-4',
    'placeholder' => __('common_identifier'),
    'maxlength' => 255,
    'required' => true,
]) !!}

{!! renderInput('commercial_register', 'form.commercial_register', __('commercial_register'), [
    'type' => 'number',
    'class' => 'col-md-4',
    'placeholder' => __('commercial_register'),
    'maxlength' => 255,
    'required' => true,
]) !!}

{!! renderInput('social_security', 'form.social_security', __('social_security'), [
    'type' => 'number',
    'class' => 'col-md-4',
    'placeholder' => __('social_security'),
    'maxlength' => 255,
    'required' => true,
]) !!}

{!! renderSelect('company_parent', 'form.company_parent', __('company_parent'), $base_data['companies'], [
    'class' => 'col-md-4',
    'placeholder' => 'Select company',
    'dataText' => 'name',
    'select2' => false,
]) !!}

{!! renderSelect('activity', 'form.activity', __('activity'), $base_data['activities'], [
    'class' => 'col-md-4',
    'placeholder' => 'Select activity',
]) !!}

{!! renderSwitch('active', 'form.active', __('Active'), [
    'class' => 'col-md-4',
]) !!}
{{-- form - end --}}
