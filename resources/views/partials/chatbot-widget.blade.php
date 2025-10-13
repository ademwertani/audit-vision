{{-- resources/views/partials/chatbot-widget.blade.php --}}
<style>
  :root{
    --cb-size: 56px;
    --cb-gap: 18px;
    --cb-z: 2147483000; /* bien au-dessus */
    --cb-radius: 16px;
  }
  .cb-launcher{
    position: fixed;
    right: var(--cb-gap);
    bottom: var(--cb-gap);
    width: var(--cb-size);
    height: var(--cb-size);
    border-radius: 999px;
    background: #2563eb;
    color: #fff;
    display: grid; place-items: center;
    box-shadow: 0 12px 28px rgba(0,0,0,.28);
    cursor: pointer; z-index: var(--cb-z);
  }
  .cb-launcher:hover{ filter: brightness(1.05) }

  .cb-panel{
    position: fixed;
    right: var(--cb-gap);
    bottom: calc(var(--cb-gap) + var(--cb-size) + 10px);
    width: min(380px, 92vw);
    height: 520px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: var(--cb-radius);
    box-shadow: 0 24px 64px rgba(0,0,0,.22);
    display: none;
    flex-direction: column;
    overflow: hidden;
    z-index: var(--cb-z);
  }
  .cb-panel.is-open{ display: flex; }

  .cb-header{
    padding: 10px 12px;
    background: #f8fafc;
    border-bottom: 1px solid #eef2f7;
    display: flex; align-items: center; justify-content: space-between;
  }
  .cb-title{ font-weight: 700; margin: 0; font-size: 15px; color:#0f172a}
  .cb-actions{ display: flex; gap: 8px; }
  .cb-btn{
    appearance: none; border: 1px solid #e5e7eb; background: #fff; color:#111827;
    border-radius: 10px; padding: 6px 10px; font-size: 13px; cursor: pointer;
  }
  .cb-btn:hover{ background:#f3f4f6 }

  .cb-body{ padding: 10px; overflow: auto; flex: 1; background:#fff; }
  .cb-row{ display: flex; margin-bottom: 8px; }
  .cb-row.user{ justify-content: flex-end; }
  .cb-bubble{
    max-width: 78%;
    padding: 8px 10px;
    border-radius: 12px;
    font-size: 14px; line-height: 1.45;
    border: 1px solid #e5e7eb;
    background:#f8fafc; color:#111827;
    white-space: pre-wrap;
  }
  .cb-row.user .cb-bubble{
    background:#2563eb; color:#fff; border-color:#2563eb;
  }

  .cb-footer{
    border-top: 1px solid #eef2f7;
    padding: 8px;
    display: grid; grid-template-columns: 1fr auto; gap: 8px;
    background:#fff;
  }
  .cb-input{
    resize: none; min-height: 42px; max-height: 140px;
    padding: 9px 10px; border-radius: 10px;
    border: 1px solid #e5e7eb; outline: none; font-size: 14px;
  }
  .cb-send{
    background:#2563eb; color:#fff; border:0; border-radius: 10px;
    padding: 0 14px; font-weight: 700; font-size: 14px; cursor: pointer;
  }
  .cb-send:hover{ filter: brightness(1.05); }
  .cb-hint{ font-size: 11px; color:#6b7280; padding: 0 8px 8px; }


  @media (max-width: 480px){
    .cb-panel{ height: 70vh; }
  }
</style>

<div class="cb-launcher" id="cbLauncher" aria-label="Ouvrir le chatbot" title="Chatbot">
  <!-- Icône bulle -->
  <svg width="26" height="26" viewBox="0 0 24 24" fill="none" aria-hidden="true">
    <path d="M7 8h10M7 12h7M5 20l3.5-3H17a4 4 0 0 0 4-4V8a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v5a4 4 0 0 0 4 4"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  </svg>
</div>

<div class="cb-panel" id="cbPanel" role="dialog" aria-modal="true" aria-labelledby="cbTitle">
  <div class="cb-header">
    <h3 class="cb-title" id="cbTitle">Assistant Groq</h3>
    <div class="cb-actions">
      <button class="cb-btn" id="cbReset" title="Réinitialiser">Reset</button>
      <button class="cb-btn" id="cbClose" title="Fermer">Fermer</button>
    </div>
  </div>

  <div class="cb-body" id="cbBody" aria-live="polite"></div>

  <div class="cb-footer">
    <textarea id="cbInput" class="cb-input" rows="1" placeholder="Écrivez votre message…"></textarea>
    <button id="cbSend" class="cb-send">Envoyer</button>
    <div class="cb-hint">Shift+Entrée pour une nouvelle ligne. Entrée pour envoyer.</div>
  </div>
</div>

<script>
(function(){
  const qs = (s, p=document) => p.querySelector(s);
  const launcher = qs('#cbLauncher');
  const panel    = qs('#cbPanel');
  const closeBtn = qs('#cbClose');
  const resetBtn = qs('#cbReset');
  const bodyEl   = qs('#cbBody');
  const inputEl  = qs('#cbInput');
  const sendBtn  = qs('#cbSend');
  const csrf     = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
  // -- Téléporter les éléments pour sortir de tout parent avec transform/overflow --

  function openPanel(){
    panel.classList.add('is-open');
    // Message d'accueil (une seule fois)
    if(!panel.dataset.greeted){
      panel.dataset.greeted = '1';
      bubble('assistant', 'Bonjour 👋 Comment puis-je vous aider ?');
    }
    setTimeout(()=> inputEl?.focus(), 50);
  }
  function closePanel(){ panel.classList.remove('is-open'); }
  function scrollBottom(){ bodyEl.scrollTop = bodyEl.scrollHeight; }

  function bubble(role, text){
    const row = document.createElement('div');
    row.className = 'cb-row ' + (role === 'user' ? 'user' : 'assistant');
    const b = document.createElement('div');
    b.className = 'cb-bubble';
    b.textContent = text;
    row.appendChild(b);
    bodyEl.appendChild(row);
    scrollBottom();
  }

  async function sendMessage(text){
    // Affiche utilisateur
    bubble('user', text);

    // Indicateur "réflexion"
    const waiting = document.createElement('div');
    waiting.className = 'cb-row assistant';
    waiting.innerHTML = '<div class="cb-bubble">⟲ Réflexion…</div>';
    bodyEl.appendChild(waiting);
    scrollBottom();

    try{
      const res = await fetch(`{{ url('/chatbot/send') }}`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrf,
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ message: text })
      });

      const contentType = res.headers.get('content-type') || '';
      let data = {};
      if(contentType.includes('application/json')){
        data = await res.json();
      }else{
        // Si jamais une page HTML est retournée (erreur 500 avec blade), on récupère le texte
        const raw = await res.text();
        data = { ok: false, error: 'Réponse non-JSON du serveur', raw };
      }

      waiting.remove();

      if(data.ok){
        bubble('assistant', data.answer || '(réponse vide)');
      }else{
        bubble('assistant', data.error || 'Désolé, une erreur est survenue.');
      }
    }catch(e){
      waiting.remove();
      bubble('assistant', 'Erreur réseau: ' + (e?.message || 'inconnue'));
    }
  }

  launcher?.addEventListener('click', openPanel);
  closeBtn?.addEventListener('click', closePanel);

  resetBtn?.addEventListener('click', async ()=>{
    try{
      const res = await fetch(`{{ url('/chatbot/reset') }}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
      });
      await res.json().catch(()=>{});
      bodyEl.innerHTML = '';
      bubble('assistant', 'Historique réinitialisé. Repartons !');
    }catch(e){
      bubble('assistant', 'Impossible de réinitialiser: ' + (e?.message || 'inconnue'));
    }
  });

  sendBtn?.addEventListener('click', ()=>{
    const text = inputEl.value.trim();
    if(!text) return;
    inputEl.value = '';
    sendMessage(text);
  });

  inputEl?.addEventListener('keydown', (e)=>{
    if(e.key === 'Enter' && !e.shiftKey){
      e.preventDefault();
      const text = inputEl.value.trim();
      if(!text) return;
      inputEl.value = '';
      sendMessage(text);
    }
  });

  // Optionnel: ouvrir le chat si hash #chatbot
  if(location.hash === '#chatbot'){ openPanel(); }
})();
</script>
