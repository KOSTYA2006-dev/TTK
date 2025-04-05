<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Модуль администрирования</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
@include('header.header')
<div class="admin-module">

    <nav class="module-nav">
        <div class="nav-item active">
            <i class="fas fa-users-cog"></i>
            <span>Администрирование</span>
        </div>
        <div class="nav-item">
            <i class="fas fa-tasks"></i>
            <span>Задачи</span>
        </div>
        <div class="nav-item">
            <i class="fas fa-newspaper"></i>
            <span>Статьи</span>
        </div>
    </nav>


    <div class="content">
        <h1>Управление пользователями</h1>


        <div class="filter-panel">
            <div class="filter-group">
                <input type="text" id="loginFilter" placeholder="Логин пользователя">
            </div>
            <div class="filter-group">
                <input type="text" id="nameFilter" placeholder="ФИО пользователя">
            </div>
            <div class="filter-group">
                <select id="roleFilter">
                    <option value="">Все роли</option>
                    <option value="user">Пользователь</option>
                    <option value="admin">Администратор</option>
                </select>
            </div>
            <div class="filter-group">
                <input type="date" id="dateFilter">
            </div>
        </div>


        <div class="users-table">
            <table>
                <thead>
                <tr>
                    <th>Логин пользователя</th>
                    <th>ФИО пользователя</th>
                    <th>Роль</th>
                    <th>Дата регистрации</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody id="usersTableBody">
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->login }}</td>
                        <td>{{ $user->full_name }}</td>
                        <td>{{ $user->role === 'admin' ? 'Администратор' : 'Пользователь' }}</td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="edit-btn" data-user-id="{{ $user->id }}">
                                    <i class="fas fa-edit"></i> Редактировать
                                </button>
                                <button class="delete-btn" data-user-id="{{ $user->id }}">
                                    <i class="fas fa-trash"></i> Удалить
                                </button>
                                <button class="password-btn" data-user-id="{{ $user->id }}">
                                    <i class="fas fa-key"></i> Сменить пароль
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('editModal')">&times;</span>
        <h2>Редактирование пользователя</h2>
        <form id="editUserForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="editUserId" name="id">
            <div class="form-group">
                <label for="editLogin">Логин:</label>
                <input type="text" id="editLogin" name="login" pattern="[a-zA-Z]+" required>
            </div>
            <div class="form-group">
                <label for="editName">ФИО:</label>
                <input type="text" id="editName" name="full_name" pattern="[а-яА-Я\s]+" required>
            </div>
            <div class="form-group">
                <label for="editRole">Роль:</label>
                <select id="editRole" name="role">
                    <option value="user">Пользователь</option>
                    <option value="admin">Администратор</option>
                </select>
            </div>
            <div class="modal-buttons">
                <button type="submit">Сохранить</button>
                <button type="button" class="cancel-btn">Отмена</button>
            </div>
        </form>
    </div>
</div>


<div id="passwordModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('passwordModal')">&times;</span>
        <h2>Смена пароля</h2>
        <form id="changePasswordForm" method="POST">
            @csrf
            <input type="hidden" id="passwordUserId" name="id">
            <div class="form-group">
                <label for="newPassword">Новый пароль:</label>
                <input type="password" id="newPassword" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Подтверждение пароля:</label>
                <input type="password" id="confirmPassword" name="password_confirmation" required>
            </div>
            <div class="modal-buttons">
                <button type="submit">Сохранить</button>
                <button type="button" class="cancel-btn">Отмена</button>
            </div>
        </form>
    </div>
</div>

<script>

    function showModal(modalId) {
        document.getElementById(modalId).style.display = 'block';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }


    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('.cancel-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                closeModal(this.closest('.modal').id);
            });
        });


        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const userId = this.getAttribute('data-user-id');
                const row = this.closest('tr');

                document.getElementById('editUserId').value = userId;
                document.getElementById('editLogin').value = row.cells[0].textContent;
                document.getElementById('editName').value = row.cells[1].textContent;
                document.getElementById('editRole').value = row.cells[2].textContent.trim() === 'Администратор' ? 'admin' : 'user';

                showModal('editModal');
            });
        });


        document.querySelectorAll('.password-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const userId = this.getAttribute('data-user-id');
                document.getElementById('passwordUserId').value = userId;
                showModal('passwordModal');
            });
        });


        document.getElementById('editUserForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const userId = formData.get('id');

            fetch(`/admin/${userId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-HTTP-Method-Override': 'PUT',
                    'Accept': 'application/json',
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert(data.message || 'Ошибка при обновлении пользователя');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ошибка: ' + error.message);
                });
        });

 
        document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const userId = formData.get('id');

            if (formData.get('password') !== formData.get('password_confirmation')) {
                alert('Пароли не совпадают');
                return;
            }


            fetch(`/admin/${userId}/password`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert(data.message || 'Ошибка при смене пароля');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ошибка: ' + error.message);
                });
        });

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (confirm('Вы уверены, что хотите удалить этого пользователя?')) {
                    const userId = this.getAttribute('data-user-id');


                    fetch(`/admin/${userId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.reload();
                            } else {
                                alert(data.message || 'Ошибка при удалении пользователя');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Ошибка: ' + error.message);
                        });
                }
            });
        });
    });
</script>
</body>
</html>
