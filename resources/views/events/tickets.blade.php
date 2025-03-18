@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ $event->title }} - Billets disponibles</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('events.purchase-tickets', $event) }}" method="POST" id="tickets-form">
                        @csrf
                        <div class="tickets-container">
                            @foreach($event->tickets as $index => $ticket)
                                @php
                                    $remainingTickets = $ticket->quantite - $ticket->quantite_vendue;
                                    $isPromo = $ticket->montant_promotionnel && now()->between($ticket->promotion_start, $ticket->promotion_end);
                                    $price = $isPromo ? $ticket->montant_promotionnel : $ticket->prix;
                                @endphp
                                <div class="ticket-item mb-4 p-3 border rounded @if($remainingTickets <= 0) opacity-50 @endif">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <h5 class="mb-1">{{ $ticket->nom }}</h5>
                                            <p class="text-muted mb-2">{{ $ticket->description }}</p>
                                            <div class="price-info">
                                                @if($isPromo)
                                                    <span class="text-decoration-line-through text-muted">{{ number_format($ticket->prix, 0, ',', ' ') }} FCFA</span>
                                                    <span class="text-danger ms-2">{{ number_format($price, 0, ',', ' ') }} FCFA</span>
                                                @else
                                                    <span class="text-primary">{{ number_format($price, 0, ',', ' ') }} FCFA</span>
                                                @endif
                                            </div>
                                            <small class="text-muted">
                                                {{ $remainingTickets }} billets restants
                                            </small>
                                        </div>
                                        <div class="col-md-6 text-md-end">
                                            <div class="d-flex align-items-center justify-content-end">
                                                <input type="number"
                                                       name="tickets[{{ $index }}][quantity]"
                                                       class="form-control quantity-input me-2"
                                                       style="width: 100px"
                                                       min="0"
                                                       max="{{ $remainingTickets }}"
                                                       value="0"
                                                       {{ $remainingTickets <= 0 ? 'disabled' : '' }}>
                                                <input type="hidden"
                                                       name="tickets[{{ $index }}][ticket_id]"
                                                       value="{{ $ticket->id }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="total-section mt-4 p-3 bg-light rounded">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Total :</h5>
                                <h5 class="mb-0" id="total-amount">0 FCFA</h5>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg" id="purchase-button" disabled>
                                Procéder au paiement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('tickets-form');
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const totalAmount = document.getElementById('total-amount');
    const purchaseButton = document.getElementById('purchase-button');

    function updateTotal() {
        let total = 0;
        let hasTickets = false;

        quantityInputs.forEach(input => {
            const quantity = parseInt(input.value) || 0;
            const ticketItem = input.closest('.ticket-item');
            const priceText = ticketItem.querySelector('.price-info').textContent;
            const price = parseInt(priceText.match(/\d+/g).pop().replace(/\s/g, ''));

            total += price * quantity;
            if (quantity > 0) hasTickets = true;
        });

        totalAmount.textContent = `${total.toLocaleString('fr-FR')} FCFA`;
        purchaseButton.disabled = !hasTickets;
    }

    quantityInputs.forEach(input => {
        input.addEventListener('change', updateTotal);
        input.addEventListener('input', updateTotal);
    });

    form.addEventListener('submit', function(e) {
        const hasTickets = Array.from(quantityInputs).some(input => parseInt(input.value) > 0);
        if (!hasTickets) {
            e.preventDefault();
            alert('Veuillez sélectionner au moins un billet.');
        }
    });
});
</script>
@endpush

@push('styles')
<style>
.ticket-item {
    transition: all 0.3s ease;
}
.ticket-item:hover {
    background-color: rgba(var(--bs-primary-rgb), 0.05);
}
.quantity-input {
    border-radius: 4px;
}
.total-section {
    border-top: 2px solid #eee;
}
</style>
@endpush
@endsection
