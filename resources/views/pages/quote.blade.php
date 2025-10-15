@extends('layouts.app')

@section('title', 'Demander un devis')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">

      {{-- Message de succès --}}
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      {{-- Erreurs de validation --}}
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

          {{-- NOTE: novalidate pour gérer nous-mêmes les messages et styles --}}
          <form id="quote-form" action="{{ route('pages.quote') }}" method="POST" novalidate>
            @csrf

            {{-- NOM (requis) --}}
            <div class="mb-3">
              <label for="nom_beneficiaire" class="form-label">Nom du bénéficiaire <span class="text-danger">*</span></label>
              <input
                id="nom_beneficiaire"
                type="text"
                name="nom_beneficiaire"
                class="form-control @error('nom_beneficiaire') is-invalid @enderror"
                value="{{ old('nom_beneficiaire') }}"
                required
                minlength="2"
                maxlength="255"
                pattern="^[\p{L}\p{N}\s\-'.]+$"
                title="2 à 255 caractères. Lettres, chiffres, espaces, - et ' autorisés."
                autocomplete="name"
              >
              <div class="invalid-feedback">Veuillez renseigner un nom valide (2–255 caractères).</div>
              @error('nom_beneficiaire')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            {{-- PRÉNOM (requis) --}}
            <div class="mb-3">
              <label for="prenom_beneficiaire" class="form-label">Prénom du bénéficiaire <span class="text-danger">*</span></label>
              <input
                id="prenom_beneficiaire"
                type="text"
                name="prenom_beneficiaire"
                class="form-control @error('prenom_beneficiaire') is-invalid @enderror"
                value="{{ old('prenom_beneficiaire') }}"
                required
                minlength="2"
                maxlength="255"
                pattern="^[\p{L}\p{N}\s\-'.]+$"
                title="2 à 255 caractères. Lettres, chiffres, espaces, - et ' autorisés."
                autocomplete="given-name"
              >
              <div class="invalid-feedback">Veuillez renseigner un prénom valide (2–255 caractères).</div>
              @error('prenom_beneficiaire')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            {{-- EMAIL (requis) --}}
            <div class="mb-3">
              <label for="email" class="form-label">E-mail <span class="text-danger">*</span></label>
              <input
                id="email"
                type="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                required
                maxlength="255"
                autocomplete="email"
                inputmode="email"
              >
              <div class="invalid-feedback">Veuillez renseigner une adresse e-mail valide.</div>
              @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            {{-- TÉLÉPHONE (requis) --}}
            <div class="mb-3">
              <label for="telephone" class="form-label">Téléphone <span class="text-danger">*</span></label>
              <input
                id="telephone"
                type="text"
                name="telephone"
                class="form-control @error('telephone') is-invalid @enderror"
                value="{{ old('telephone') }}"
                required
                minlength="6"
                maxlength="30"
                inputmode="tel"
                pattern="^[0-9 +().\-]{6,30}$"
                title="6 à 30 caractères. Chiffres, espaces, + ( ) . - autorisés."
                autocomplete="tel"
              >
              <div class="invalid-feedback">Veuillez renseigner un téléphone valide (6–30 caractères, chiffres/espaces/+().-).</div>
              @error('telephone')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            {{-- RAISON SOCIALE (requis) --}}
            <div class="mb-3">
              <label for="raison_sociale" class="form-label">Raison sociale <span class="text-danger">*</span></label>
              <input
                type="text"
                id="raison_sociale"
                name="raison_sociale"
                class="form-control @error('raison_sociale') is-invalid @enderror"
                value="{{ old('raison_sociale') }}"
                required
                minlength="2"
                maxlength="255"
                pattern="^[\p{L}\p{N}\s&'’\-,./()]+$"
                title="2 à 255 caractères. Lettres, chiffres, espaces et & ' ’ - , . / ( ) autorisés."
                inputmode="text"
                autocomplete="organization"
              >
              <div class="invalid-feedback" id="rs-help">
                Veuillez renseigner une raison sociale valide (2–255 caractères).
              </div>
              @error('raison_sociale')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            {{-- SIRET (requis – 14 chiffres) --}}
            <div class="mb-3">
              <label for="siret" class="form-label">SIRET (14 chiffres) <span class="text-danger">*</span></label>
              <input
                type="text"
                id="siret"
                name="siret"
                class="form-control @error('siret') is-invalid @enderror"
                value="{{ old('siret') }}"
                required
                inputmode="numeric"
                pattern="^\d{14}$"
                maxlength="14"
                placeholder="Ex. 73282932000074"
                title="Le SIRET doit contenir exactement 14 chiffres."
                autocomplete="on"
              >
              <div class="invalid-feedback" id="siret-help">
                Veuillez renseigner un SIRET valide : exactement 14 chiffres.
              </div>
              @error('siret')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            {{-- ADRESSE (requis) --}}
            <div class="mb-3">
              <label for="adresse" class="form-label">Adresse <span class="text-danger">*</span></label>
              <input
                id="adresse"
                type="text"
                name="adresse"
                class="form-control @error('adresse') is-invalid @enderror"
                value="{{ old('adresse') }}"
                required
                minlength="4"
                maxlength="255"
                autocomplete="street-address"
              >
              <div class="invalid-feedback">Veuillez renseigner une adresse (4–255 caractères).</div>
              @error('adresse')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <!-- SECTEUR (requis) -->
            <div class="mb-3">
              <label for="secteur" class="form-label">Secteur d'activité <span class="text-danger">*</span></label>
              <select name="secteur" id="secteur" class="form-select @error('secteur') is-invalid @enderror" required>
                <option value="">-- Sélectionnez un secteur --</option>
                @foreach(\App\Models\Quote::SECTEURS as $secteur)
                  <option value="{{ $secteur }}" {{ old('secteur') == $secteur ? 'selected' : '' }}>
                    {{ ucfirst($secteur) }}
                  </option>
                @endforeach
              </select>
              <div class="invalid-feedback">Veuillez sélectionner un secteur.</div>
              @error('secteur')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
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

{{-- ================== Script ================== --}}
<script>
  // --- Données & éléments
  const secteurOps    = @json(\App\Models\Quote::SECTEUR_OPS);
  const oldSecteur    = "{{ old('secteur') }}";
  const oldOps        = @json(old('operations', []));

  const form          = document.getElementById('quote-form');
  const nomInput      = document.getElementById('nom_beneficiaire');
  const prenomInput   = document.getElementById('prenom_beneficiaire');
  const emailInput    = document.getElementById('email');
  const telInput      = document.getElementById('telephone');
  const rsInput       = document.getElementById('raison_sociale');
  const siretInput    = document.getElementById('siret');
  const adresseInput  = document.getElementById('adresse');
  const secteurSelect = document.getElementById('secteur');

  const opsContainer  = document.getElementById('operations-container');
  const opsCheckboxes = document.getElementById('operations-checkboxes');
  const qsContainer   = document.getElementById('operation-questions');
  const qsWrapper     = document.getElementById('questions-wrapper');

  // --- Regex & contraintes
  const NAME_REGEX   = /^[\p{L}\p{N}\s\-'.]+$/u;
  const EMAIL_REGEX  = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/i;
  const TEL_REGEX    = /^[0-9 +().\-]{6,30}$/;
  const RS_REGEX     = /^[\p{L}\p{N}\s&'’\-,./()]+$/u;
  const SIRET_REGEX  = /^\d{14}$/;

  // --- État : on ne montre rien avant la 1re tentative
  let triedSubmit = false;

  // --- Utils
  function setInvalid(el, msg) {
    if (!triedSubmit) return; // Ne pas afficher si pas encore tenté d'envoyer
    el.classList.remove('is-valid');
    el.classList.add('is-invalid');
    const fb = el.parentElement.querySelector('.invalid-feedback');
    if (fb && msg) fb.textContent = msg;
  }
  function setValid(el) {
    if (!triedSubmit) return; // Ne pas afficher si pas encore tenté d'envoyer
    el.classList.remove('is-invalid');
    if ((el.value || '').trim().length > 0) el.classList.add('is-valid');
  }
  function focusFirstInvalid() {
    const first = form.querySelector('.is-invalid');
    if (first) {
      first.scrollIntoView({ behavior: 'smooth', block: 'center' });
      first.focus({ preventScroll: true });
    }
  }
  function trimVal(el){ el.value = (el.value || '').trim(); }

  // --- Validations unitaires
  function validateNom(){
    trimVal(nomInput);
    const v = nomInput.value;
    const ok = v.length >= 2 && v.length <= 255 && NAME_REGEX.test(v);
    ok ? setValid(nomInput) : setInvalid(nomInput, "Veuillez renseigner un nom valide (2–255 caractères).");
    return ok;
  }
  function validatePrenom(){
    trimVal(prenomInput);
    const v = prenomInput.value;
    const ok = v.length >= 2 && v.length <= 255 && NAME_REGEX.test(v);
    ok ? setValid(prenomInput) : setInvalid(prenomInput, "Veuillez renseigner un prénom valide (2–255 caractères).");
    return ok;
  }
  function validateEmail(){
    trimVal(emailInput);
    const v = emailInput.value;
    const ok = v.length > 0 && v.length <= 255 && EMAIL_REGEX.test(v);
    ok ? setValid(emailInput) : setInvalid(emailInput, "Veuillez renseigner une adresse e-mail valide.");
    return ok;
  }
  function validateTel(){
    trimVal(telInput);
    const v = telInput.value;
    const ok = v.length >= 6 && v.length <= 30 && TEL_REGEX.test(v);
    ok ? setValid(telInput) : setInvalid(telInput, "Veuillez renseigner un téléphone valide (6–30 caractères, chiffres/espaces/+().-).");
    return ok;
  }
  function validateRS(){
    trimVal(rsInput);
    const v = rsInput.value;
    const ok = v.length >= 2 && v.length <= 255 && RS_REGEX.test(v);
    ok ? setValid(rsInput) : setInvalid(rsInput, "Veuillez renseigner une raison sociale valide (2–255 caractères).");
    return ok;
  }
  function normalizeSiret(){
    siretInput.value = (siretInput.value||'').replace(/\D+/g, '').slice(0, 14);
  }
  function validateSiret(){
    normalizeSiret();
    const v = siretInput.value;
    const ok = SIRET_REGEX.test(v);
    ok ? setValid(siretInput) : setInvalid(siretInput, "Veuillez renseigner un SIRET valide : exactement 14 chiffres.");
    return ok;
  }
  function validateAdresse(){
    trimVal(adresseInput);
    const v = adresseInput.value;
    const ok = v.length >= 4 && v.length <= 255;
    ok ? setValid(adresseInput) : setInvalid(adresseInput, "Veuillez renseigner une adresse (4–255 caractères).");
    return ok;
  }
  function validateSecteur(){
    const ok = !!secteurSelect.value;
    ok ? setValid(secteurSelect) : setInvalid(secteurSelect, "Veuillez sélectionner un secteur.");
    return ok;
  }

  // --- Activer la validation “live” seulement après première tentative
  function attachLiveValidationOnce() {
    if (attachLiveValidationOnce._done) return;
    attachLiveValidationOnce._done = true;

    nomInput.addEventListener('input', validateNom);
    prenomInput.addEventListener('input', validatePrenom);
    emailInput.addEventListener('input', validateEmail);
    telInput.addEventListener('input', validateTel);
    rsInput.addEventListener('input', validateRS);
    siretInput.addEventListener('input', validateSiret);
    adresseInput.addEventListener('input', validateAdresse);
    secteurSelect.addEventListener('change', validateSecteur);
  }

  // --- Questions (inchangé)
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
            <label class="form-label d-block">Êtes-vous dans le secteur agriculture maraîchère ?</label>
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
            <label class="form-label d-block">Avez-vous un groupe froid qui alimente une chambre froide ou une installation de climatisation de confort ?</label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="qs[${slug}][type_froid]" id="${slug}_type_chambre" value="chambre" required>
              <label class="form-check-label" for="${slug}_type_chambre">Chambre froide</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="qs[${slug}][type_froid]" id="${slug}_type_clim" value="climatique" required>
              <label class="form-check-label" for="${slug}_type_clim">Climatisation de confort</label>
            </div>
          </div>
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
            <label class="form-label d-block">Puissance nominale climatisation de confort ≥ 80 kW ?</label>
            <div class="form-check form-check-inline">
              <input class="form-check-input sub-req" type="radio" name="qs[${slug}][clim_ge_880]" id="${slug}_cl_oui" value="oui">
              <label class="form-check-label" for="${slug}_cl_oui">Oui</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input sub-req" type="radio" name="qs[${slug}][clim_ge_880]" id="${slug}_cl_non" value="non">
              <label class="form-check-label" for="${slug}_cl_non">Non</label>
            </div>
          </div>
          <small class="text-muted d-block mt-2">Choisissez <strong>Chambre froide</strong> ou <strong>Climatisation de confort</strong>, puis répondez aux sous-questions.</small>
        </div>
      `;
    }
    return '';
  }

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

      document.querySelectorAll('.op-check').forEach(cb => {
        cb.addEventListener('change', (e) => {
          const op = e.target.value;
          if (e.target.checked) addQuestionnaire(op);
          else removeQuestionnaire(op);
        });
      });

      if (oldOps.length) oldOps.forEach(op => addQuestionnaire(op));
    } else {
      opsContainer.style.display = 'none';
    }
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

  // --- Validation des radios "required"
  function validateQuestionRadios() {
    const reqRadios = qsWrapper.querySelectorAll('input[required][type="radio"]');
    if (!reqRadios.length) return true;

    let ok = true;
    const groups = {};
    reqRadios.forEach(r => { groups[r.name] = groups[r.name] || []; groups[r.name].push(r); });

    Object.keys(groups).forEach(name => {
      const anyChecked = groups[name].some(r => r.checked);
      if (!anyChecked) {
        ok = false;
        if (triedSubmit) groups[name].forEach(r => r.classList.add('is-invalid'));
      } else {
        if (triedSubmit) groups[name].forEach(r => r.classList.remove('is-invalid'));
      }
    });

    return ok;
  }

  function validateForm() {
    const results = [
      validateNom(),
      validatePrenom(),
      validateEmail(),
      validateTel(),
      validateRS(),
      validateSiret(),
      validateAdresse(),
      validateSecteur(),
      validateQuestionRadios()
    ];
    return results.every(Boolean);
  }

  // --- Soumission : on déclenche l’affichage seulement ici
  form.addEventListener('submit', function(e){
    triedSubmit = true;               // on peut maintenant afficher les erreurs
    attachLiveValidationOnce();       // et activer la validation live
    if (!validateForm()) {
      e.preventDefault();
      focusFirstInvalid();
    }
  });

  // --- Init
  secteurSelect.addEventListener('change', updateOperations);
  if (oldSecteur) updateOperations();
  // Surtout pas de validation initiale ici : rien en rouge par défaut.
</script>

@endsection
