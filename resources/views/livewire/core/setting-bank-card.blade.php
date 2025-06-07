<div>
    <ul class="nav nav-pills nav-pills-custom mb-5">
        @foreach($banks as $bank)
            @foreach($bank->accounts as $account)
               <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                   <a class="nav-link d-flex flex-column overflow-hidden w-275px h-175px py-4" data-bs-toggle="pill" href="#{{ \Illuminate\Support\Str::slug($account->name) }}" aria-selected="true" role="tab">
                        <div class="d-flex flex-row justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <img src="{{ $bank->banque_logo_url }}" class="img-fluid w-45px" alt="">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold fs-3 text-dark">{{ $bank->banque_name }}</span>
                                    <span class="inline-flex items-center rounded-md bg-{{ $account->account_type->color() }}-50 px-2 py-1 text-xs font-medium text-{{ $account->account_type->color() }}-600 ring-1 ring-{{ $account->account_type->color() }}-500/10 ring-inset">{{ $account->account_type->label() }}</span>
                                </div>
                            </div>
                            <button class="btn btn-link" data-bs-toggle="tooltip" title="Dernière synchronisation en date du {{ \Carbon\Carbon::createFromTimestamp($bank->last_refreshed_at) }}">
                                <i class="fa-solid fa-refresh fs-3"></i>
                            </button>
                        </div>
                       <span class="d-flex flex-column">
                           <span class="fs-6 text-dark">{{ $account->name }}</span>
                           @if($account->balance >= 0)
                               <span class="fw-bold fs-3 text-primary">+ {{ \App\Helpers\Helpers::eur($account->balance) }}</span>
                           @else
                               <span class="fw-bold fs-3 text-danger">{{ \App\Helpers\Helpers::eur($account->balance) }}</span>
                           @endif
                       </span>
                   </a>
               </li>
            @endforeach
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach($banks as $bank)
            @foreach($bank->accounts as $account)
                <div class="tab-pane fade show" id="{{ \Illuminate\Support\Str::slug($account->name) }}" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#{{ \Illuminate\Support\Str::slug($account->name) }}_{{ $account->id }}_mvm">Mouvements</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#{{ \Illuminate\Support\Str::slug($account->name) }}_{{ $account->id }}_income">A Venir</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade show" id="{{ \Illuminate\Support\Str::slug($account->name) }}_{{ $account->id }}_mvm" role="tabpanel"></div>
                                <div class="tab-pane fade show" id="{{ \Illuminate\Support\Str::slug($account->name) }}_{{ $account->id }}_income" role="tabpanel"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach

    </div>
</div>


