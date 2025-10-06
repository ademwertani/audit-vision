@php $current = (int) old('note', $customer->note ?? 0); @endphp

<div class="mb-3">
  <label class="form-label">Nom du client</label>
  <input type="text" name="customer_name" class="form-control"
         value="{{ old('customer_name', $customer->customer_name ?? '') }}" required>
  @error('customer_name') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Titre</label>
  <input type="text" name="title" class="form-control"
         value="{{ old('title', $customer->title ?? '') }}" required>
  @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label d-block">Note (0–5)</label>

  {{-- Widget étoiles --}}
  <div id="starWidget" class="d-flex align-items-center gap-1" style="font-size:22px; cursor:pointer;">
    @for ($i = 1; $i <= 5; $i++)
      <i class="{{ $i <= $current ? 'fa-solid' : 'fa-regular' }} fa-star" data-val="{{ $i }}"></i>
    @endfor
    <span class="ms-2 text-muted" id="starValue">{{ $current }}/5</span>
  </div>

  {{-- input qui sera envoyé --}}
  <input type="hidden" name="note" id="note" value="{{ $current }}">
  @error('note') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Commentaire</label>
  <textarea name="comment" rows="4" class="form-control">{{ old('comment', $customer->comment ?? '') }}</textarea>
  @error('comment') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const stars = document.querySelectorAll('#starWidget .fa-star');
  const input = document.getElementById('note');
  const label = document.getElementById('starValue');

  function sync(val){
    const v = Math.max(0, Math.min(5, parseInt(val || 0, 10)));
    stars.forEach((s, i) => {
      s.classList.toggle('fa-solid', i < v);
      s.classList.toggle('fa-regular', i >= v);
    });
    input.value = v;
    if (label) label.textContent = v + '/5';
  }

  stars.forEach(star => star.addEventListener('click', () => sync(star.dataset.val)));
  sync(input.value);
});
</script>
@endpush
