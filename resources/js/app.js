import './bootstrap';

document.addEventListener("DOMContentLoaded", function() {
    const stars = document.querySelectorAll('.rating .star');
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-value');
            const itemId = this.closest('.rating').getAttribute('data-item-id');
            
            // Atualiza as estrelas visíveis
            updateStars(rating, itemId);

            // Enviar via AJAX
            fetch('/avaliar-item', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    item_id: itemId,
                    rating: rating
                })
            })
            .then(response => response.json())
            .then(data => console.log('Avaliação salva com sucesso!', data))
            .catch(error => console.error('Erro ao salvar avaliação:', error));
        });
    });

    function updateStars(rating, itemId) {
        const stars = document.querySelectorAll(`.rating[data-item-id="${itemId}"] .star`);
        
        // Limpa as estrelas
        stars.forEach(star => {
            star.classList.remove('filled');
        });
        
        // Preenche as estrelas até o valor de 'rating'
        for (let i = 0; i < rating; i++) {
            stars[i].classList.add('filled');
        }
    }
});