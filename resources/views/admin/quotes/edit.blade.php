@extends('layouts.back')

@section('title', 'Modifier la demande de devis')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Modifier la demande #{{ $quote->id }}</h4>
        <a href="{{ route('admin.quotes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            // Valeurs initiales robustes
            $opsSelected = old('operations', is_array($quote->operations) ? $quote->operations : (json_decode($quote->operations, true) ?: []));
            $secteurs    = $secteurs ?? \App\Models\Quote::SECTEURS;
            $secteurOps  = $secteurOps ?? \App\Models\Quote::SECTEUR_OPS;
        @endphp

        <form id="admin-quote-edit" action="{{ route('admin.quotes.update', $quote->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Identité bénéficiaire --}}
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nom_beneficiaire" class="form-label">Nom du bénéficiaire *</label>
                    <input type="text"
                           class="form-control @error('nom_beneficiaire') is-invalid @enderror"
                           id="nom_beneficiaire" name="nom_beneficiaire"
                           value="{{ old('nom_beneficiaire', $quote->nom_beneficiaire) }}" required>
                    @error('nom_beneficiaire')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="prenom_beneficiaire" class="form-label">Prénom du bénéficiaire</label>
                    <input type="text"
                           class="form-control @error('prenom_beneficiaire') is-invalid @enderror"
                           id="prenom_beneficiaire" name="prenom_beneficiaire"
                           value="{{ old('prenom_beneficiaire', $quote->prenom_beneficiaire) }}">
                    @error('prenom_beneficiaire')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           id="email" name="email"
                           value="{{ old('email', $quote->email) }}">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="telephone" class="form-label">Téléphone</label>
                    <input type="text"
                           class="form-control @error('telephone') is-invalid @enderror"
                           id="telephone" name="telephone"
                           value="{{ old('telephone', $quote->telephone) }}">
                    @error('telephone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="raison_sociale" class="form-label">Raison sociale</label>
                    <input type="text"
                           class="form-control @error('raison_sociale') is-invalid @enderror"
                           id="raison_sociale" name="raison_sociale"
                           value="{{ old('raison_sociale', $quote->raison_sociale) }}">
                    @error('raison_sociale')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- 🔹 SIRET (14 chiffres) --}}
                <div class="col-md-6">
                    <label for="siret" class="form-label">SIRET</label>
                    <input
                        type="text"
                        class="form-control @error('siret') is-invalid @enderror"
                        id="siret"
                        name="siret"
                        value="{{ old('siret', $quote->siret) }}"
                        inputmode="numeric"
                        maxlength="14"
                        pattern="^\d{14}$"
                        placeholder="Ex. 73282932000074"
                        autocomplete="off"
                    >
                    <div class="form-text">14 chiffres (sans espaces ni séparateurs).</div>
                    @error('siret')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-12">
                    <label for="adresse" class="form-label">Adresse</label>
                    <input type="text"
                           class="form-control @error('adresse') is-invalid @enderror"
                           id="adresse" name="adresse"
                           value="{{ old('adresse', $quote->adresse) }}">
                    @error('adresse')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <hr class="my-4">

            {{-- Secteur --}}
            <div class="mb-3">
                <label for="secteur" class="form-label">Secteur d'activité *</label>
                <select name="secteur" id="secteur" class="form-select @error('secteur') is-invalid @enderror" required>
                    <option value="">-- Sélectionnez un secteur --</option>
                    @foreach($secteurs as $s)
                        <option value="{{ $s }}" {{ old('secteur', $quote->secteur) === $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>
                @error('secteur')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Opérations dynamiques --}}
            <div class="mb-3" id="operations-container" style="display:none;">
                <label class="form-label">Opérations disponibles</label>
                <div id="operations-checkboxes"></div>
                @error('operations')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            {{-- Questionnaires par opération --}}
            <div class="mb-3" id="operation-questions" style="display:none;">
                <label class="form-label">Questions supplémentaires</label>
                <div id="questions-wrapper" class="d-flex flex-column gap-3"></div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.quotes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== JS dynamique ==================== --}}
<script>
    // Données depuis PHP
    const secteurOps = @json($secteurOps);
    const initialSecteur = "{{ old('secteur', $quote->secteur) }}";
    const oldOps = @json($opsSelected);
    const oldQS = @json(old('qs', []));

    // Helpers DOM
    const form          = document.getElementById('admin-quote-edit');
    const secteurSelect = document.getElementById('secteur');
    const opsContainer  = document.getElementById('operations-container');
    const opsCheckboxes = document.getElementById('operations-checkboxes');
    const qsContainer   = document.getElementById('operation-questions');
    const qsWrapper     = document.getElementById('questions-wrapper');

    // Util: marquer "checked" selon old('qs')
    function checkedAttr(op, key, val) {
        const v = oldQS?.[op]?.[key] ?? null;
        return v === val ? 'checked' : '';
    }

    // Blocs de questionnaires
    function questionBlock(op) {
        const slug = op;
        const nice = op.charAt(0).toUpperCase() + op.slice(1);

        if (op === 'destratificateur') {
            return `
              <div class="border rounded p-3" data-op="${slug}">
                <h6 class="mb-3">Questions – ${nice}</h6>

                <div class="mb-2">
                  <label class="form-label d-block">La hauteur sous plafond est-elle ≥ 5 m ?</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="qs[${slug}][hauteur_ge_5]" id="${slug}_h_oui" value="oui" ${checkedAttr(slug,'hauteur_ge_5','oui')} required>
                    <label class="form-check-label" for="${slug}_h_oui">Oui</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="qs[${slug}][hauteur_ge_5]" id="${slug}_h_non" value="non" ${checkedAttr(slug,'hauteur_ge_5','non')} required>
                    <label class="form-check-label" for="${slug}_h_non">Non</label>
                  </div>
                </div>

                <div class="mb-0">
                  <label class="form-label d-block">Est-ce une zone de stockage ?</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="qs[${slug}][zone_stockage]" id="${slug}_zs_oui" value="oui" ${checkedAttr(slug,'zone_stockage','oui')} required>
                    <label class="form-check-label" for="${slug}_zs_oui">Oui</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="qs[${slug}][zone_stockage]" id="${slug}_zs_non" value="non" ${checkedAttr(slug,'zone_stockage','non')} required>
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
                  <label class="form-label d-block">Êtes-vous dans le secteur marché ?</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="qs[${slug}][secteur_marche]" id="${slug}_sm_oui" value="oui" ${checkedAttr(slug,'secteur_marche','oui')} required>
                    <label class="form-check-label" for="${slug}_sm_oui">Oui</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="qs[${slug}][secteur_marche]" id="${slug}_sm_non" value="non" ${checkedAttr(slug,'secteur_marche','non')} required>
                    <label class="form-check-label" for="${slug}_sm_non">Non</label>
                  </div>
                </div>

                <div class="mb-0">
                  <label class="form-label d-block">La surface est-elle ≥ 200 m² ?</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="qs[${slug}][surface_ge_200]" id="${slug}_s_oui" value="oui" ${checkedAttr(slug,'surface_ge_200','oui')} required>
                    <label class="form-check-label" for="${slug}_s_oui">Oui</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="qs[${slug}][surface_ge_200]" id="${slug}_s_non" value="non" ${checkedAttr(slug,'surface_ge_200','non')} required>
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
                  <label class="form-label d-block">Avez-vous un groupe froid qui alimente une chambre froide ou une installation climatique ?</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="qs[${slug}][type_froid]" id="${slug}_type_chambre" value="chambre" ${checkedAttr(slug,'type_froid','chambre')} required>
                    <label class="form-check-label" for="${slug}_type_chambre">Chambre froide</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="qs[${slug}][type_froid]" id="${slug}_type_clim" value="climatique" ${checkedAttr(slug,'type_froid','climatique')} required>
                    <label class="form-check-label" for="${slug}_type_clim">Climatique</label>
                  </div>
                </div>

                <div class="mt-2 ps-2" data-sub="chambre" style="display:none;">
                  <label class="form-label d-block">Puissance chambre froide ≥ 10 kW ?</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input sub-req" type="radio" name="qs[${slug}][chambre_ge_10]" id="${slug}_ch_oui" value="oui" ${checkedAttr(slug,'chambre_ge_10','oui')}>
                    <label class="form-check-label" for="${slug}_ch_oui">Oui</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input sub-req" type="radio" name="qs[${slug}][chambre_ge_10]" id="${slug}_ch_non" value="non" ${checkedAttr(slug,'chambre_ge_10','non')}>
                    <label class="form-check-label" for="${slug}_ch_non">Non</label>
                  </div>
                </div>

                <div class="mt-2 ps-2" data-sub="climatique" style="display:none;">
                  <label class="form-label d-block">Climatisation ≥ 80 kW ?</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input sub-req" type="radio" name="qs[${slug}][clim_ge_80]" id="${slug}_cl_oui" value="oui" ${checkedAttr(slug,'clim_ge_80','oui')}>
                    <label class="form-check-label" for="${slug}_cl_oui">Oui</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input sub-req" type="radio" name="qs[${slug}][clim_ge_80]" id="${slug}_cl_non" value="non" ${checkedAttr(slug,'clim_ge_80','non')}>
                    <label class="form-check-label" for="${slug}_cl_non">Non</label>
                  </div>
                </div>

                <small class="text-muted d-block mt-2">
                  Le formulaire passe si la réponse est <strong>Oui</strong> sur la branche sélectionnée (Chambre ≥ 10 kW ou Climatique ≥ 80 kW).
                </small>
              </div>
            `;
        }

        return '';
    }

    // Affichage conditionnel des sous-questions Variateur
    function attachVariateurHandlers(blockEl) {
        const typeRadios = blockEl.querySelectorAll('input[name="qs[variateur][type_froid]"]');
        const subChambre = blockEl.querySelector('[data-sub="chambre"]');
        const subClim    = blockEl.querySelector('[data-sub="climatique"]');

        function toggleSubs() {
            const type = blockEl.querySelector('input[name="qs[variateur][type_froid]"]:checked')?.value;

            subChambre.style.display = 'none';
            subClim.style.display = 'none';
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

    // Mise à jour des opérations selon le secteur
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
                        <label class="form-check-label text-capitalize" for="${id}">${op}</label>
                    </div>
                `);
            });

            bindOpHandlers();

            // Pré-afficher questionnaires pour les opérations déjà cochées
            if (oldOps.length) {
                oldOps.forEach(op => addQuestionnaire(op));
            }
        } else {
            opsContainer.style.display = 'none';
        }
    }

    function bindOpHandlers() {
        document.querySelectorAll('.op-check').forEach(cb => {
            cb.addEventListener('change', (e) => {
                const op = e.target.value;
                if (e.target.checked) addQuestionnaire(op);
                else removeQuestionnaire(op);
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

    // Validation front (bloquante) avant envoi
    form.addEventListener('submit', function (e) {
        const checkedOps = Array.from(document.querySelectorAll('.op-check:checked')).map(i => i.value);

        for (const op of checkedOps) {
            const blk = qsWrapper.querySelector(`[data-op="${op}"]`);
            if (!blk) {
                e.preventDefault();
                alert(`Veuillez répondre au questionnaire pour l'opération « ${op} ».`);
                blk?.scrollIntoView({behavior: 'smooth', block: 'center'});
                return;
            }

            const getVal = (name) => {
                const inp = blk.querySelector(`input[name="${name}"]:checked`);
                return inp ? inp.value : null;
            };

            if (op === 'destratificateur') {
                const h5  = getVal(`qs[${op}][hauteur_ge_5]`);
                const zst = getVal(`qs[${op}][zone_stockage]`);
                if (h5 !== 'oui') {
                    e.preventDefault();
                    alert("Pour 'Destratificateur' : hauteur sous plafond ≥ 5 m requise (Oui).");
                    blk.scrollIntoView({behavior: 'smooth', block: 'center'});
                    return;
                }
                if (zst !== 'non') {
                    e.preventDefault();
                    alert("Pour 'Destratificateur' : la zone ne doit pas être une zone de stockage (Non).");
                    blk.scrollIntoView({behavior: 'smooth', block: 'center'});
                    return;
                }
            }

            if (op === 'deshumidificateur') {
                const sm   = getVal(`qs[${op}][secteur_marche]`);
                const s200 = getVal(`qs[${op}][surface_ge_200]`);
                if (sm !== 'oui') {
                    e.preventDefault();
                    alert("Pour 'Déshumidificateur' : secteur marché requis (Oui).");
                    blk.scrollIntoView({behavior: 'smooth', block: 'center'});
                    return;
                }
                if (s200 !== 'oui') {
                    e.preventDefault();
                    alert("Pour 'Déshumidificateur' : surface ≥ 200 m² requise (Oui).");
                    blk.scrollIntoView({behavior: 'smooth', block: 'center'});
                    return;
                }
            }

            if (op === 'variateur') {
                const type = getVal(`qs[${op}][type_froid]`);
                if (!type) {
                    e.preventDefault();
                    alert("Pour 'Variateur' : choisissez 'Chambre froide' ou 'Climatique'.");
                    blk.scrollIntoView({behavior: 'smooth', block: 'center'});
                    return;
                }
                if (type === 'chambre') {
                    const ch = getVal(`qs[${op}][chambre_ge_10]`);
                    if (ch !== 'oui') {
                        e.preventDefault();
                        alert("Pour 'Variateur' (Chambre froide) : puissance ≥ 10 kW requise (Oui).");
                        blk.scrollIntoView({behavior: 'smooth', block: 'center'});
                        return;
                    }
                } else if (type === 'climatique') {
                    const cl = getVal(`qs[${op}][clim_ge_80]`);
                    if (cl !== 'oui') {
                        e.preventDefault();
                        alert("Pour 'Variateur' (Climatique) : climatisation ≥ 80 kW requise (Oui).");
                        blk.scrollIntoView({behavior: 'smooth', block: 'center'});
                        return;
                    }
                }
            }
        }
    });

    // Init
    secteurSelect.addEventListener('change', updateOperations);
    if (initialSecteur) updateOperations();
</script>
@endsection
