@php
    $time = time();
    $listing_tables = $listing['base_data']['tables'];
    $length_columns = count($listing['base_data']['columns']);
    foreach ($tables as $key => $table) {
        array_push($listing_tables, [
            'id' => $table['table_name'],
            'name' => $table['table_name'],
        ]);
    }
@endphp

<div class="card card-flush">
    <div class="card-body">
        @include('livewire.module-includes.listing')

        @if (count($listing['base_data']['data']) > 0)
            <div class="bg-secondary p-5 mt-5 rounded">
                <div class="card card-flush">
                    <div class="card-header pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">Preview</span>
                            <span
                                class="text-gray-400 mt-1 fw-semibold fs-6">{{ $listing['values']['name_table'] }}</span>
                        </h3>
                    </div>

                    <div class="card-body pt-0">
                        <livewire:table _key="Table-{{ $time }}" :data="$listing['base_data']['data']" :columns="$listing['base_data']['columns_show']"
                            :types="$listing['base_data']['types']" :totals="$listing['base_data']['totals']" />
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
