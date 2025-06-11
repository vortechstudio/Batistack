<div class="d-flex flex-column flex-xl-row">
    <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
        <div class="card mb-5 mb-xl-8">
            <div class="card-body pt-15">
                <div class="d-flex flex-center flex-column mb-5">
                    <div class="symbol symbol-150px symbol-circle mb-7">
                        <x-bi-building-fill class="w-50px h-50px" />
                    </div>

                    <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1">
                        {{ $tiers->name }}
                    </a>

                    <a href="#" class="fs-5 fw-semibold text-muted text-hover-primary mb-6">
                        {{ $tiers->addresses->first()->email }}
                    </a>
                </div>
                <div class="d-flex flex-stack fs-4 py-3">
                    <div class="fw-bold">
                        Details
                    </div>
                    <div class="badge badge-{{ $tiers->nature->color() }} d-inline">{{ $tiers->nature->label() }}</div>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="pb-5 fs-6">
                    <!--begin::Details item-->
                    <div class="fw-bold mt-5">Code fournisseur</div>
                    <div class="text-gray-600">{{ $tiers->code_tiers }}</div>
                    <!--begin::Details item-->
                    <!--begin::Details item-->
                    <div class="fw-bold mt-5">Type de Compte</div>
                    <div class="text-gray-600">{{ $tiers->type->label() }}</div>
                    <!--begin::Details item-->
                    <!--begin::Details item-->
                    @if(count($tiers->addresses) > 0)
                    <div class="fw-bold mt-5">Adresse</div>
                    <div class="text-gray-600">
                        {{ $tiers->addresses->first()->address }},<br>
                        {{ $tiers->addresses->first()->cp }} {{ $tiers->addresses->first()->ville }}, <br>
                        {{ $tiers->addresses->first()->pays }}
                    </div>
                    @endif
                    <!--begin::Details item-->
                    <!--begin::Details item-->
                    @if(count($tiers->contacts) > 0)
                    <div class="fw-bold mt-5">Contact Principal</div>
                    <div class="text-gray-600">
                        <div class="d-flex flex-row align-items-center mb-1">
                            <x-heroicon-o-user class="w-15px me-2" />
                            <span class="fw-bold">{{ $tiers->contacts->first()->titre }} {{ $tiers->contacts->first()->nom }} {{ $tiers->contacts->first()->prenom }}</span>
                        </div>
                        <div class="d-flex flex-row align-items-center mb-1">
                            <x-heroicon-s-phone class="w-15px me-2" />
                            <span>{{ $tiers->contacts->first()->phone }}</span>
                        </div>
                        <div class="d-flex flex-row align-items-center mb-1">
                            <x-bi-phone-fill class="w-15px me-2" />
                            <span>{{ $tiers->contacts->first()->portable }}</span>
                        </div>
                        <div class="d-flex flex-row align-items-center mb-1">
                            <x-entypo-email class="w-15px me-2" />
                            <span>{{ $tiers->contacts->first()->email }}</span>
                        </div>
                    </div>
                    <!--begin::Details item-->
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="flex-lg-row-fluid ms-lg-15">
        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab" href="#tiers" aria-selected="true" role="tab">Tiers</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#contacts" aria-selected="false" tabindex="-1" role="tab">Contacts</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#address" aria-selected="false" tabindex="-1" role="tab">Adresses</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#fournisseur" aria-selected="false" tabindex="-1" role="tab">Fournisseur</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#rglt" aria-selected="false" tabindex="-1" role="tab">Mode de règlement</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show" id="tiers" role="tabpanel">
                <div class="card pt-4 mb-6 mb-xl-9">
                    <div class="card-header border-0">
                        <div class="card-title">
                            <h2>Informations Principales</h2>
                        </div>
                        <div class="card-toolbar gap-2">
                            {{ $this->sendMessage }}
                            {{ $this->editForm }}
                            <button class="btn btn-sm btn-danger">Supprimer</button>
                        </div>
                    </div>
                    <div class="card-body pt-0 pb-5">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed gy-5" id="kt_table_users_login_session">
                                <tbody class="fs-6 fw-semibold text-gray-600">
                                <tr>
                                    <td>Siren</td>
                                    <td>{{ $tiers->siren }}</td>
                                    <td class="text-end">

                                    </td>
                                </tr>

                                <tr>
                                    <td>Siret</td>
                                    <td>{{ $tiers->siret }}</td>
                                    <td class="text-end">

                                    </td>
                                </tr>
                                <tr>
                                    <td>Assujesti à la TVA</td>
                                    <td>
                                        @if($tiers->tva) Oui @else Non @endif
                                    </td>
                                </tr>
                                @if($tiers->tva)
                                <tr>
                                    <td>Numéro de TVA</td>
                                    <td>{{ $tiers->num_tva }}</td>
                                    <td class="text-end">

                                    </td>
                                </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card pt-4 mb-6 mb-xl-9">
                    <div class="card-header border-0">
                        <h3 class="card-title">Evenements Systèmes</h3>
                    </div>
                    <div class="card-body pt-0 pb-5">
                        {{ $this->table }}
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show active" id="contacts" role="tabpanel">
                @livewire('tiers.contact-panel', ['tiers' => $tiers])
            </div>
        </div>
    </div>

    <x-filament-actions::modals />
</div>
