// Article Editor
let quill;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill editor
    quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{ 'header': 1 }, { 'header': 2 }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'script': 'sub'}, { 'script': 'super' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'direction': 'rtl' }],
                [{ 'size': ['small', false, 'large', 'huge'] }],
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'font': [] }],
                [{ 'align': [] }],
                ['clean'],
                ['link', 'image']
            ]
        }
    });

    // Handle form submission
    const form = document.getElementById('articleForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const content = quill.root.innerHTML;
            document.getElementById('content').value = content;
            this.submit();
        });
    }
});

// Article Operations
async function showArticle(articleId) {
    try {
        const response = await fetch(`/stati/${articleId}`);
        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Ошибка загрузки статьи');
        }

        document.getElementById('viewArticleTitle').textContent = data.title;
        document.getElementById('viewArticleContent').innerHTML = data.content;
        document.getElementById('viewArticleDate').textContent = data.created_at;
        document.getElementById('viewArticleAuthor').textContent = data.author;

        const imgElement = document.getElementById('viewArticleImage');
        if (data.image_url) {
            imgElement.src = data.image_url;
            imgElement.style.display = 'block';
        } else {
            imgElement.style.display = 'none';
        }

        showModal('viewArticleModal');
    } catch (error) {
        console.error('Error:', error);
        showError(error.message);
    }
}

async function editArticle(articleId) {
    try {
        const response = await fetch(`/stati/${articleId}/edit`);
        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Ошибка загрузки статьи для редактирования');
        }

        document.getElementById('editArticleId').value = articleId;
        document.getElementById('editArticleTitle').value = data.title;
        quill.root.innerHTML = data.content;

        const imgElement = document.getElementById('editArticleImagePreview');
        if (data.image_url) {
            imgElement.src = data.image_url;
            imgElement.style.display = 'block';
        } else {
            imgElement.style.display = 'none';
        }

        showModal('editArticleModal');
    } catch (error) {
        console.error('Error:', error);
        showError(error.message);
    }
}

async function deleteArticle(articleId) {
    if (!confirm('Вы уверены, что хотите удалить эту статью?')) {
        return;
    }

    try {
        const response = await fetch(`/stati/${articleId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Ошибка удаления статьи');
        }

        if (data.success) {
            window.location.reload();
        } else {
            showError(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        showError(error.message);
    }
}

// Modal Functions
function showModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Close modals when clicking outside
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}

// Error Handling
function showError(message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-danger';
    alertDiv.textContent = message;
    
    const container = document.querySelector('.articles-container');
    container.insertBefore(alertDiv, container.firstChild);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

// Image Preview
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    const file = input.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
} 