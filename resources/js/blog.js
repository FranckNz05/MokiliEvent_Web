// Gestion des likes
function handleLike(blogId) {
    fetch(`/blogs/${blogId}/like`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const likeButton = document.querySelector(`#like-button-${blogId}`);
            const likeCount = document.querySelector(`#like-count-${blogId}`);

            if (data.action === 'liked') {
                likeButton.classList.add('liked');
                likeButton.querySelector('i').classList.remove('far');
                likeButton.querySelector('i').classList.add('fas');
            } else {
                likeButton.classList.remove('liked');
                likeButton.querySelector('i').classList.remove('fas');
                likeButton.querySelector('i').classList.add('far');
            }

            likeCount.textContent = data.likesCount;
        }
    })
    .catch(error => console.error('Erreur:', error));
}

// Gestion des commentaires
function submitComment(blogId) {
    const commentInput = document.querySelector(`#comment-input-${blogId}`);
    const content = commentInput.value.trim();

    if (!content) return;

    fetch(`/blogs/${blogId}/comment`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ content })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Ajouter le nouveau commentaire à la liste
            const commentsList = document.querySelector(`#comments-list-${blogId}`);
            const commentTemplate = `
                <div class="comment">
                    <img src="${data.comment.user.profile_photo_url}" class="rounded-circle" width="32" height="32">
                    <div class="comment-content">
                        <strong>${data.comment.user.name}</strong>
                        <p>${data.comment.content}</p>
                        <small class="text-muted">${data.comment.created_at}</small>
                    </div>
                </div>
            `;
            commentsList.insertAdjacentHTML('afterbegin', commentTemplate);

            // Mettre à jour le compteur de commentaires
            document.querySelector(`#comment-count-${blogId}`).textContent = data.commentsCount;

            // Réinitialiser le champ de commentaire
            commentInput.value = '';
        }
    })
    .catch(error => console.error('Erreur:', error));
}

// Gestion du partage
function shareBlog(blogId) {
    fetch(`/blogs/${blogId}/share`)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Créer un élément temporaire pour copier l'URL
            const temp = document.createElement('input');
            document.body.appendChild(temp);
            temp.value = data.shareUrl;
            temp.select();
            document.execCommand('copy');
            document.body.removeChild(temp);

            // Afficher une notification
            const shareButton = document.querySelector(`#share-button-${blogId}`);
            const originalText = shareButton.textContent;
            shareButton.textContent = 'Copié !';
            setTimeout(() => {
                shareButton.textContent = originalText;
            }, 2000);

            // Ouvrir les options de partage si disponibles
            if (navigator.share) {
                navigator.share({
                    title: data.title,
                    url: data.shareUrl
                });
            }
        }
    })
    .catch(error => console.error('Erreur:', error));
}

// Initialisation des gestionnaires d'événements
document.addEventListener('DOMContentLoaded', () => {
    // Gestionnaires pour les likes
    document.querySelectorAll('[id^="like-button-"]').forEach(button => {
        button.addEventListener('click', () => {
            const blogId = button.id.replace('like-button-', '');
            handleLike(blogId);
        });
    });

    // Gestionnaires pour les commentaires
    document.querySelectorAll('[id^="comment-form-"]').forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const blogId = form.id.replace('comment-form-', '');
            submitComment(blogId);
        });
    });

    // Gestionnaires pour le partage
    document.querySelectorAll('[id^="share-button-"]').forEach(button => {
        button.addEventListener('click', () => {
            const blogId = button.id.replace('share-button-', '');
            shareBlog(blogId);
        });
    });
});
