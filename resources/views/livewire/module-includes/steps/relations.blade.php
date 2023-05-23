@php
    use App\Helpers\ModelHelper;
    use App\Helpers\TemplateHelper;
@endphp

<div class="w-100">
    @if ($countRelations > 0)
        <div class="px-4 py-1 bg-secondary">
            @foreach ($values['relations'] as $key => $relation)
                <div class="card card-flush my-4" wire:key="relation-{{ $key }}">
                    <div class="card-header pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">{{ __('Relation') }}
                                {{ $key + 1 }}</span>
                            {{-- <span class="text-gray-400 mt-1 fw-semibold fs-6">Users from all channels</span> --}}
                        </h3>

                        <div class="card-toolbar">
                            <button type="button" class="btn btn-danger"
                                wire:click="removeRelation({{ $key }})">
                                <i class="fa fa-trash p-0"></i>
                                {{-- {{ __('Remove') }} --}}
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row m-0">
                            <div class="col-md-4 mb-10 fv-plugins-icon-container">
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span class="required">{{ __('First Model') }}</span>
                                </label>
                                <select class="form-select form-control-lg form-control-solid"
                                    wire:model="values.relations.{{ $key }}.first_model">
                                    <option disabled value="">
                                        {{ __('Choose Table') }}
                                    </option>
                                    @foreach ($base_data['tables'] as $table)
                                        <option value="{{ $table['id'] }}">
                                            {{ $table['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                {!! TemplateHelper::getFormMessage($relation['errors']['first_model']) !!}
                            </div>

                            <div class="col-md-4 mb-10 fv-plugins-icon-container">
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span class="required">{{ __('Relation type') }}</span>
                                </label>
                                <select class="form-select form-control-lg form-control-solid"
                                    wire:model="values.relations.{{ $key }}.relation_type">
                                    <option disabled value="">
                                        {{ __('Choose Type') }}
                                    </option>
                                    @foreach ($base_data['relation_types'] as $type)
                                        <option value="{{ $type['id'] }}">
                                            {{ $type['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                {!! TemplateHelper::getFormMessage($relation['errors']['relation_type']) !!}
                            </div>

                            <div class="col-md-4 mb-10 fv-plugins-icon-container">
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span class="required">{{ __('Second Model') }}</span>
                                </label>
                                <select class="form-select form-control-lg form-control-solid"
                                    wire:model="values.relations.{{ $key }}.second_model">
                                    <option disabled value="">
                                        {{ __('Choose Table') }}
                                    </option>
                                    @foreach ($base_data['tables'] as $table)
                                        <option value="{{ $table['id'] }}">
                                            {{ $table['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                {!! TemplateHelper::getFormMessage($relation['errors']['second_model']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="d-flex justify-content-end">
        <div>
            <button type="button" class="btn btn-primary my-4" wire:click="addRelation">
                <i class="fa fa-plus p-0"></i>
                {{ __('Relation') }}
            </button>
        </div>
    </div>
</div>
