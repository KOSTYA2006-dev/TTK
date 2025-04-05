<script>
// Устанавливаем CSRF-токен для всех AJAX-запросов
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Функция для обработки ошибок AJAX
function handleAjaxError(error) {
    if (error.status === 419) { // CSRF token mismatch
        window.location.reload(); // Перезагружаем страницу для обновления токена
    }
}
</script> 