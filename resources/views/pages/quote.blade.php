@extends('layouts.app')

@section('title', 'Demander un devis')

@section('content')


    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <!-- Message de succès -->
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Erreurs de validation -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-body p-4">
                        <h3 class="mb-4">Remplissez vos informations</h3>

                        <form id="quote-form" action="{{ route('pages.quote') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="nom_beneficiaire" class="form-label">Nom du bénéficiaire</label>
                                <input type="text" name="nom_beneficiaire" class="form-control @error('nom_beneficiaire') is-invalid @enderror"
                                       value="{{ old('nom_beneficiaire') }}" required>
                                @error('nom_beneficiaire')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="prenom_beneficiaire" class="form-label">Prénom du bénéficiaire</label>
                                <input type="text" name="prenom_beneficiaire" class="form-control @error('prenom_beneficiaire') is-invalid @enderror"
                                       value="{{ old('prenom_beneficiaire') }}">
                                @error('prenom_beneficiaire')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <input type="text" name="telephone" class="form-control @error('telephone') is-invalid @enderror"
                                       value="{{ old('telephone') }}">
                                @error('telephone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="raison_sociale" class="form-label">Raison sociale</label>
                                <input type="text" name="raison_sociale" class="form-control @error('raison_sociale') is-invalid @enderror"
                                       value="{{ old('raison_sociale') }}">
                                @error('raison_sociale')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="adresse" class="form-label">Adresse</label>
                                <input type="text" name="adresse" class="form-control @error('adresse') is-invalid @enderror"
                                       value="{{ old('adresse') }}">
                                @error('adresse')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Secteur -->
                            <div class="mb-3">
                                <label for="secteur" class="form-label">Secteur d'activité</label>
                                <select name="secteur" id="secteur" class="form-select @error('secteur') is-invalid @enderror" required>
                                    <option value="">-- Sélectionnez un secteur --</option>
                                    @foreach(\App\Models\Quote::SECTEURS as $secteur)
                                        <option value="{{ $secteur }}" {{ old('secteur') == $secteur ? 'selected' : '' }}>
                                            {{ ucfirst($secteur) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('secteur')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Opérations dynamiques -->
                            <div class="mb-3" id="operations-container" style="display:none;">
                                <label class="form-label">Opérations disponibles</label>
                                <div id="operations-checkboxes"></div>
                                @error('operations')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <!-- Questionnaires par opération -->
                            <div class="mb-3" id="operation-questions" style="display:none;">
                                <label class="form-label">Questions supplémentaires</label>
                                <div id="questions-wrapper" class="d-flex flex-column gap-3"></div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Envoyer la demande</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Script dynamique -->
    <script>
        // Mapping secteur -> opérations (depuis le modèle)
        const secteurOps = @json(\App\Models\Quote::SECTEUR_OPS);
        const oldSecteur = "{{ old('secteur') }}";
        const oldOps = @json(old('operations', []));

        const secteurSelect   = document.getElementById('secteur');
        const opsContainer    = document.getElementById('operations-container');
        const opsCheckboxes   = document.getElementById('operations-checkboxes');

        const qsContainer     = document.getElementById('operation-questions');
        const qsWrapper       = document.getElementById('questions-wrapper');
        const form            = document.getElementById('quote-form');

        // Génère le HTML de questionnaire pour une opération
        function questionBlock(op) {
            const slug = op; // op en minuscules
            const nice = op.charAt(0).toUpperCase() + op.slice(1);

            if (op === 'destratificateur') {
                return `
                  <div class="border rounded p-3" data-op="${slug}">
                    <h6 class="mb-3">Questions – ${nice}</h6>

                    <div class="mb-2">
                      <label class="form-label d-block">La hauteur sous plafond est-elle ≥ 5 m ?</label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="qs[${slug}][hauteur_ge_5]" id="${slug}_h_oui" value="oui" required>
                        <label class="form-check-label" for="${slug}_h_oui">Oui</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="qs[${slug}][hauteur_ge_5]" id="${slug}_h_non" value="non" required>
                        <label class="form-check-label" for="${slug}_h_non">Non</label>
                      </div>
                    </div>

                    <div class="mb-0">
                      <label class="form-label d-block">Est-ce une zone de stockage ?</label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="qs[${slug}][zone_stockage]" id="${slug}_zs_oui" value="oui" required>
                        <label class="form-check-label" for="${slug}_zs_oui">Oui</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="qs[${slug}][zone_stockage]" id="${slug}_zs_non" value="non" required>
                        <label class="form-check-label" for="${slug}_zs_non">Non</label>
                      </div>
                    </div>
                  </div>
                `;
            }

            if (op === 'deshumidificateur') {
                return `
                  <div class="border rounded p-3" data-op="${slug}">
                    <h6 class="mb-3">Questions – ${nice}</h6>

                    <div class="mb-2">
                      <label class="form-label d-block">Êtes-vous dans le secteur agriculture maraîchère  ?</label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="qs[${slug}][secteur_marche]" id="${slug}_sm_oui" value="oui" required>
                        <label class="form-check-label" for="${slug}_sm_oui">Oui</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="qs[${slug}][secteur_marche]" id="${slug}_sm_non" value="non" required>
                        <label class="form-check-label" for="${slug}_sm_non">Non</label>
                      </div>
                    </div>

                    <div class="mb-0">
                      <label class="form-label d-block">La surface de la serre est-elle ≥ 200 m² ?</label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="qs[${slug}][surface_ge_200]" id="${slug}_s_oui" value="oui" required>
                        <label class="form-check-label" for="${slug}_s_oui">Oui</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="qs[${slug}][surface_ge_200]" id="${slug}_s_non" value="non" required>
                        <label class="form-check-label" for="${slug}_s_non">Non</label>
                      </div>
                    </div>
                  </div>
                `;
            }

            if (op === 'variateur') {
                return `
                  <div class="border rounded p-3" data-op="${slug}">
                    <h6 class="mb-3">Questions – ${nice}</h6>

                    <div class="mb-2">
                      <label class="form-label d-block">
                        Avez-vous un groupe froid qui alimente une chambre froide ou une installation de climatisation de confort ?
                      </label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="qs[${slug}][type_froid]" id="${slug}_type_chambre" value="chambre" required>
                        <label class="form-check-label" for="${slug}_type_chambre">Chambre froide</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="qs[${slug}][type_froid]" id="${slug}_type_clim" value="climatique" required>
                        <label class="form-check-label" for="${slug}_type_clim">Climatisation de confort</label>
                      </div>
                    </div>

                    <!-- Sous-questions -->
                    <div class="mt-2 ps-2" data-sub="chambre" style="display:none;">
                      <label class="form-label d-block">Puissance nominale chambre froide ≥ 10 kW ?</label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input sub-req" type="radio" name="qs[${slug}][chambre_ge_10]" id="${slug}_ch_oui" value="oui">
                        <label class="form-check-label" for="${slug}_ch_oui">Oui</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input sub-req" type="radio" name="qs[${slug}][chambre_ge_10]" id="${slug}_ch_non" value="non">
                        <label class="form-check-label" for="${slug}_ch_non">Non</label>
                      </div>
                    </div>

                    <div class="mt-2 ps-2" data-sub="climatique" style="display:none;">
                      <label class="form-label d-block">puissance nominale climatisation de confort ≥ 80 kw ?</label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input sub-req" type="radio" name="qs[${slug}][clim_ge_880]" id="${slug}_cl_oui" value="oui">
                        <label class="form-check-label" for="${slug}_cl_oui">Oui</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input sub-req" type="radio" name="qs[${slug}][clim_ge_880]" id="${slug}_cl_non" value="non">
                        <label class="form-check-label" for="${slug}_cl_non">Non</label>
                      </div>
                    </div>

                    <small class="text-muted d-block mt-2">
                      Choisissez <strong>Chambre froide</strong> ou <strong>Climatisation de confort</strong>, répondez ensuite.  
                    </small>
                  </div>
                `;
            }

            return '';
        }

        // Gestion sous-questions Variateur
        function attachVariateurHandlers(blockEl) {
            const typeRadios = blockEl.querySelectorAll('input[name="qs[variateur][type_froid]"]');
            const subChambre = blockEl.querySelector('[data-sub="chambre"]');
            const subClim    = blockEl.querySelector('[data-sub="climatique"]');

            function toggleSubs() {
                const type = blockEl.querySelector('input[name="qs[variateur][type_froid]"]:checked')?.value;

                // masquer les deux
                subChambre.style.display = 'none';
                subClim.style.display = 'none';

                // enlever required des sous-questions
                subChambre.querySelectorAll('.sub-req').forEach(i => i.required = false);
                subClim.querySelectorAll('.sub-req').forEach(i => i.required = false);

                if (type === 'chambre') {
                    subChambre.style.display = 'block';
                    subChambre.querySelectorAll('.sub-req').forEach(i => i.required = true);
                } else if (type === 'climatique') {
                    subClim.style.display = 'block';
                    subClim.querySelectorAll('.sub-req').forEach(i => i.required = true);
                }
            }

            typeRadios.forEach(r => r.addEventListener('change', toggleSubs));
            toggleSubs();
        }

        // Affiche les opérations selon le secteur choisi
        function updateOperations() {
            const secteur = secteurSelect.value;
            opsCheckboxes.innerHTML = '';
            qsWrapper.innerHTML = '';
            qsContainer.style.display = 'none';

            if (secteur && secteurOps[secteur]) {
                opsContainer.style.display = 'block';
                secteurOps[secteur].forEach(op => {
                    const id = 'op_' + op;
                    const checked = oldOps.includes(op) ? 'checked' : '';
                    opsCheckboxes.insertAdjacentHTML('beforeend', `
                        <div class="form-check">
                            <input class="form-check-input op-check" type="checkbox" name="operations[]" value="${op}" id="${id}" ${checked}>
                            <label class="form-check-label" for="${id}">
                                ${op.charAt(0).toUpperCase() + op.slice(1)}
                            </label>
                        </div>
                    `);
                });

                bindOperationCheckHandlers();

                if (oldOps.length) {
                    oldOps.forEach(op => addQuestionnaire(op));
                }
            } else {
                opsContainer.style.display = 'none';
            }
        }

        function bindOperationCheckHandlers() {
            document.querySelectorAll('.op-check').forEach(cb => {
                cb.addEventListener('change', (e) => {
                    const op = e.target.value;
                    if (e.target.checked) {
                        addQuestionnaire(op);
                    } else {
                        removeQuestionnaire(op);
                    }
                });
            });
        }

        function addQuestionnaire(op) {
            if (qsWrapper.querySelector(`[data-op="${op}"]`)) return;
            const block = questionBlock(op);
            if (!block) return;
            qsWrapper.insertAdjacentHTML('beforeend', block);
            qsContainer.style.display = 'block';

            if (op === 'variateur') {
                const blockEl = qsWrapper.querySelector('[data-op="variateur"]');
                attachVariateurHandlers(blockEl);
            }
        }

        function removeQuestionnaire(op) {
            const el = qsWrapper.querySelector(`[data-op="${op}"]`);
            if (el) el.remove();
            if (!qsWrapper.children.length) qsContainer.style.display = 'none';
        }

        // ===============================
        // Validation à la soumission (NEW)
        // → on NE bloque plus rien : toutes les réponses sont acceptées.
        // ===============================
        form.addEventListener('submit', function (e) {
            // pas de preventDefault, pas d'alert — on laisse envoyer.
            // Les `required` natifs s'appliquent toujours (une option doit être cochée).
        });

        // Init
        secteurSelect.addEventListener('change', updateOperations);
        if (oldSecteur) updateOperations();
    </script>
@endsection
