<div class="{{ $options['show_forms']['company_departements'] ? '' : 'hidden' }}">
    <div class="row">
        {!! renderInput('departements-name', 'form.departements.name', __('Name'), [
            'class' => 'col-md-4',
        ]) !!}

        {!! renderInput('departements-floors', 'form.departements.floors', __('floors'), [
            'type' => 'number',
            'class' => 'col-md-4',
        ]) !!}

        {!! renderSelect(
            'departements-reception_user_id',
            'form.departements.reception_user_id',
            __('reception'),
            $base_data['users'],
            [
                'class' => 'col-md-4',
                'placeholder' => 'Select reception',
                'dataText' => 'full_name',
            ],
        ) !!}

        {!! renderSelect(
            'departements-responsible_user_id',
            'form.departements.responsible_user_id',
            __('responsible'),
            $base_data['users'],
            [
                'class' => 'col-md-4',
                'placeholder' => 'Select responsible',
                'dataText' => 'full_name',
            ],
        ) !!}

        {!! renderSelect(
            'departements-company_site_id',
            'form.departements.company_site_id',
            __('company_site'),
            $base_data['sites'],
            [
                'class' => 'col-md-4',
                'placeholder' => 'Select site',
                'dataText' => 'name',
                'ignore' => false,
            ],
        ) !!}

        {!! renderSelect(
            'departements-departement_parent',
            'form.departements.departement_parent',
            __('departement_parent'),
            $base_data['departements'],
            [
                'class' => 'col-md-4',
                'placeholder' => 'Select departement_parent',
                'dataText' => 'name',
                'ignore' => false,
            ],
        ) !!}

        {!! renderSwitch('departements-active', 'form.departements.active', __('Active'), [
            'class' => 'col-md-4',
        ]) !!}

        {!! renderTextarea('departements-description', 'form.departements.description', __('description'), [
            'class' => 'col-md-12',
        ]) !!}
    </div>

    <div class="d-flex flex-row align-items-center justify-content-end">
        <button class="btn btn-danger btn-sm me-2"
            wire:click="action_show_form('company_departements', false)">{{ __('Cancel') }}</button>
        <button class="btn btn-success btn-sm" wire:click="saveDepartement">{{ __('Save') }}</button>
    </div>
</div>
<div class="{{ $options['show_forms']['company_departements'] ? 'hidden' : '' }}">
    <livewire:table _id="{{ $base_data['datatables']['company_departements']['name'] }}" :columns="$base_data['datatables']['company_departements']['columns']"
        route="{{ route($base_data['datatables']['company_departements']['name'] . '.list') }}" />
</div>
