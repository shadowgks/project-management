<div class="{{ $options['show_forms']['company_sites'] ? '' : 'hidden' }}">
    <div class="row">
        {!! renderInput('sites-name', 'form.sites.name', __('Name'), [
            'class' => 'col-md-4',
        ]) !!}
        {!! renderInput('sites-number_of_floors', 'form.sites.number_of_floors', __('number_of_floors'), [
            'type' => 'number',
            'class' => 'col-md-4',
        ]) !!}
        {!! renderInput('sites-post_code', 'form.sites.post_code', __('post_code'), [
            'type' => 'number',
            'class' => 'col-md-4',
        ]) !!}

        {!! renderInput('sites-phone_number', 'form.sites.phone_number', __('phone_number'), [
            'class' => 'col-md-4',
        ]) !!}
        {!! renderInput('sites-email', 'form.sites.email', __('email'), [
            'type' => 'email',
            'class' => 'col-md-4',
        ]) !!}
        {!! renderSelect('sites-country_id', 'form.sites.country_id', __('Country'), $base_data['countries'], [
            'class' => 'col-md-4',
            'placeholder' => 'Select country',
            'dataText' => 'name',
            'change' => 'getCities',
            'select2' => false,
        ]) !!}

        {!! renderSelect('sites-city_id', 'form.sites.city_id', __('City'), $base_data['cities'], [
            'class' => 'col-md-4',
            'placeholder' => 'Select city',
            'dataText' => 'name',
            'change' => 'getAreas',
            'select2' => false,
        ]) !!}
        {!! renderSelect('sites-area_id', 'form.sites.area_id', __('Area'), $base_data['areas'], [
            'class' => 'col-md-4',
            'placeholder' => 'Select area',
            'dataText' => 'name',
            'select2' => false,
        ]) !!}
        {!! renderSelect('sites-type', 'form.sites.type', __('Type'), $base_data['site_types'], [
            'class' => 'col-md-4',
            'placeholder' => 'Select type',
        ]) !!}

        {!! renderSwitch('sites-basic_address', 'form.sites.basic_address', __('basic_address'), [
            'class' => 'col-md-4',
        ]) !!}
        {!! renderSwitch('sites-shipping_address', 'form.sites.shipping_address', __('shipping_address'), [
            'class' => 'col-md-4',
        ]) !!}
        {!! renderSwitch('sites-pos_address', 'form.sites.pos_address', __('pos_address'), [
            'class' => 'col-md-4',
        ]) !!}
        {!! renderSwitch('sites-active', 'form.sites.active', __('Active'), [
            'class' => 'col-md-4',
        ]) !!}

        {!! renderTextarea('sites-address', 'form.sites.address', __('Address'), [
            'class' => 'col-md-12',
        ]) !!}
    </div>

    <div class="d-flex flex-row align-items-center justify-content-end">
        <button class="btn btn-danger btn-sm me-2"
            wire:click="action_show_form('company_sites', false)">{{ __('Cancel') }}</button>
        <button class="btn btn-success btn-sm" wire:click="saveSite">{{ __('Save') }}</button>
    </div>
</div>

<div class="{{ $options['show_forms']['company_sites'] ? 'hidden' : '' }}">
    <livewire:table _id="{{ $base_data['datatables']['company_sites']['name'] }}" :columns="$base_data['datatables']['company_sites']['columns']"
        route="{{ route($base_data['datatables']['company_sites']['name'] . '.list') }}" />
</div>
