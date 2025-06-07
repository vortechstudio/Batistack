<div>
    <form id="saveCompany" wire:submit="saveCompany" enctype="multipart/form-data">
        <div class="card card-flush bg-light mb-5">
            <div class="card-header">
                <h3 class="card-title">Information Société/Entreprise</h3>
                <div class="card-toolbar">
                    <button type="submit" class="btn btn-sm btn-success">
                        Sauvegarder
                    </button>
                </div>
            </div>
            <div class="card-body bg-white">
                <x-form.input
                    name="name"
                    label="Nom de la companie" />

                <x-form.textarea
                    name="address"
                    label="Adresse Postal" />

                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="mb-5">
                            <label for="" class="form-label">Code Postal</label>
                            <input type="text" wire:model.lazy="cp" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="mb-5">
                            <label for="" class="form-label">Ville</label>
                            <input type="text" class="form-control" wire:model="city">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="mb-5">
                            <label for="" class="form-label">Pays</label>
                            <div wire:ignore>
                                <select data-pharaonic="select2" data-component-id="{{ $this->__id }}" wire:model="country">
                                    @foreach($this->countries as $country)
                                        <option value="{{ $country }}">{{ $country }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <x-form.input-group
                            name="phone"
                            label="Téléphone"
                            icon="fa-phone"
                            mask="true"
                            mask-value="99 99 99 99 99" />
                    </div>
                    <div class="col-md-4">
                        <x-form.input-group
                            name="portable"
                            label="Portable"
                            icon="fa-mobile"
                            mask="true"
                            mask-value="99 99 99 99 99" />
                    </div>
                    <div class="col-md-4">
                        <x-form.input-group
                            name="fax"
                            label="Fax"
                            icon="fa-fax"
                            mask="true"
                            mask-value="99 99 99 99 99"/>
                    </div>
                </div>
                <x-form.input
                    name="email"
                    type="email"
                    label="Adresse Mail" />

                <x-form.input
                    name="web"
                    type="web"
                    label="Site Web" />

            </div>
        </div>
    </form>
    <form id="saveInfo" wire:submit="saveInfo">
        <div class="card card-flush bg-light mb-5">
            <div class="card-header">
                <h3 class="card-title">Identifiant Société/Entreprise</h3>
                <div class="card-toolbar">
                    <button type="submit" class="btn btn-sm btn-success">
                        Sauvegarder
                    </button>
                </div>
            </div>
            <div class="card-body bg-white">
                <x-form.input
                    name="director"
                    label="Nom du Directeur/PDG/Gérant" />

                <x-form.input-group
                    name="capital"
                    label="Capital"
                    icon="fa-euro"
                    icon-placement="right" />

                <div class="mb-5">
                    <label for="" class="form-label">Type d'entreprise (Status)</label>
                    <div wire:ignore>
                        <select data-pharaonic="select2" class="form-control" data-placeholder="Selectionner le type d'entreprise" data-component="{{ $this->__id }}" wire:model="type">
                            <option value=""></option>
                            @foreach($typeEntreprise as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <x-form.textarea
                    name="object"
                    label="Objet de la société" />

                <x-form.input
                    name="num_tva"
                    label="Numéro de TVA"
                    mask="true"
                    mask-value="FR99 999 999 999" />

                <x-form.input
                    name="num_siren"
                    label="Numéro de SIREN"
                    mask="true"
                    mask-value="999 999 999" />

                <x-form.input
                    name="num_siret"
                    label="Numéro de SIRET"
                    mask="true"
                    mask-value="999 999 999 99999" />

                <x-form.input
                    name="num_naf"
                    label="Code NAF/APE"
                    mask="true" />

                <x-form.input
                    name="rcs"
                    label="RCS/RM" />
            </div>
        </div>
    </form>
    <form id="saveTva" wire:submit="saveTVA">
        <div class="card card-flush bg-light mb-5">
            <div class="card-header">
                <h3 class="card-title">Gestion TVA</h3>
                <div class="card-toolbar">
                    <button type="submit" class="btn btn-sm btn-success">
                        Sauvegarder
                    </button>
                </div>
            </div>
            <div class="card-body bg-white">
                <div class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input" type="radio" wire:model="tva" value="1" id="flexRadioDefault"/>
                    <label class="form-check-label" for="flexRadioDefault">
                        <strong>Assujetti à la TVA</strong>
                        <p><i>Lors de la création de documents (devis, factures, commandes...), le taux de la taxe sur les ventes par défaut est fixé selon les règles standard (en fonction des pays du vendeur et de l'acheteur)</i></p>
                    </label>
                </div>
                <div class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input" type="radio" wire:model="tva" value="0" id="flexRadioDefault1"/>
                    <label class="form-check-label" for="flexRadioDefault1">
                        <strong>Non assujetti à la TVA</strong>
                        <p><i>Le taux de TVA proposé par défaut est 0. C'est le cas d'associations, particuliers ou certaines petites sociétés.</i></p>
                    </label>
                </div>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-sm-12 col-md-6">
            <form method="POST" action="{{ route('upload') }}" enctype="multipart/form-data">
                @csrf
                <div class="card card-flush bg-light mb-5">
                    <div class="card-header">
                        <h3 class="card-title">Logo de la société</h3>
                        <div class="card-toolbar">
                            <button type="submit" class="btn btn-sm btn-success">Upload</button>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <img src="{{ Storage::disk('public')->url('societe/logo_wide.png') }}" class="img-thumbnail mb-2" alt="">
                        <div wire:ignore>
                            <input type="file" class="form-control" name="file" wire:model="logo">
                            <input type="hidden" name="folder" value="societe">
                            <input type="hidden" name="name_file" value="logo_wide.png">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-12 col-md-6">
            <form method="POST" action="{{ route('upload') }}" enctype="multipart/form-data">
                @csrf
                <div class="card card-flush bg-light mb-5">
                    <div class="card-header">
                        <h3 class="card-title">Logo de la société (Carré)</h3>
                        <div class="card-toolbar">
                            <button type="submit" class="btn btn-sm btn-success">Upload</button>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <img src="{{ Storage::disk('public')->url('societe/logo.png') }}" class="img-thumbnail mb-2" alt="">
                        <div wire:ignore>
                            <input type="file" class="form-control" name="file" wire:model="logo">
                            <input type="hidden" name="folder" value="societe">
                            <input type="hidden" name="name_file" value="logo.png">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let selects = document.querySelectorAll('[data-pharaonic="select2"]')

            selects.forEach((select) => {
                select.select2()
                select.addEventListener('change', function (e) {
                    let data = e.select2("val")
                    @this.set('selected', data);
                })
            })
        })
    </script>
@endpush
