
													<!--begin::Card-->
													<div class="card pt-4 mb-6 mb-xl-9">
														<!--begin::Card header-->
														<div class="card-header border-0">
															<!--begin::Card title-->
															<div class="card-title flex-column">
																<span class="fw-bold mb-2 text-dark">{{ __('Email received') }}</span>
																<span class="text-muted fw-semibold fs-7">Choose what email you’d like to receive from other users.</span>
																
															</div>
															<!--end::Card title-->
														</div>
														<!--end::Card header-->
														<!--begin::Card body-->
														<div class="card-body">
															<!--begin::Form-->
															<form wire:submit.prevent="submit_permissions" method="POST">
																<!--begin::Item-->
																<table class="table table-flush align-middle table-row-bordered table-row-solid gy-4 gs-9 border">
																	<!--begin::Tbody-->
																	<tbody class="fw-6 fw-semibold text-gray-600">
																		
																		<tr style="">
																			<td >
																				{{ __('module_name') }}
																			</td>
																			<td >
																				{{ __('permission') }}
																			</td>
																			<td >
																				{{ __('value') }}
																			</td>
																		</tr>
																		@foreach ($email_received as $key => $element)
																			@if (count($element['permission']) == 0)
																				@continue
																			@endif
																			@foreach ($element['permission'] as $key2 => $element2)
																			<tr style="">
																				@if ($key2 == 0)
																					
																				<td rowspan="{{ count($element['permission']) }}" width="20%" style="border-right: 1px solid var(--kt-border-color);">
																					{{ $element['name'] }}
																				</td>
																				@endif
																					<td class="ps-9">{{ __($element2['pseudo_name']) }}
																					</td>
																					<td >
											
																						<div class="form-check form-check-custom form-check-solid">
																							<!--begin::Input-->
																							<input class="form-check-input me-3" wire:model="permissions.{{ $element2['id'] }}"  type="checkbox" value="true" >
																							<!--end::Input-->
																						</div>
																					</td>  
																				
																			</tr>                               
																			@endforeach
																		@endforeach
																	</tbody>
																	<!--end::Tbody-->
																</table>
															
																<!--begin::Action buttons-->
																<div class="d-flex justify-content-end align-items-center mt-12">
																	<!--begin::Button-->
																	<button type="submit" class="btn btn-primary" >Save
																	</button>
																	<!--end::Button-->
																</div>
																<!--begin::Action buttons-->
															</form>
															<!--end::Form-->
														</div>
														<!--end::Card body-->
														<!--begin::Card footer-->
														<!--end::Card footer-->
													</div>
													<!--end::Card-->