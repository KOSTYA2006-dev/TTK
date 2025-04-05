// Модель данных пользователей
class User {
    constructor(login, name, role, registrationDate, isDeleted = false) {
        this.login = login;
        this.name = name;
        this.role = role;
        this.registrationDate = registrationDate;
        this.isDeleted = isDeleted;
    }
}

// Сервис для работы с пользователями
class UserService {
    constructor() {
        this.users = [
            new User('admin', 'Администратор Системы', 'admin', '2024-01-01'),
            new User('user1', 'Иванов Иван Иванович', 'user', '2024-02-01'),
            new User('user2', 'Петров Петр Петрович', 'user', '2024-02-15')
        ];
    }

    getAllUsers() {
        return this.users.filter(user => !user.isDeleted);
    }

    updateUser(login, updatedData) {
        const user = this.users.find(u => u.login === login);
        if (user) {
            Object.assign(user, updatedData);
            return true;
        }
        return false;
    }

    deleteUser(login) {
        const user = this.users.find(u => u.login === login);
        if (user) {
            user.isDeleted = true;
            return true;
        }
        return false;
    }

    changePassword(login, newPassword) {
        // В реальном приложении здесь будет хеширование пароля
        console.log(`Пароль изменен для пользователя ${login}`);
        return true;
    }
}

// UI контроллер
class AdminUI {
    constructor() {
        this.userService = new UserService();
        this.currentUser = { role: 'admin' }; // Текущий пользователь (для демонстрации)
        this.initializeUI();
        this.setupEventListeners();
    }

    initializeUI() {
        this.renderUsers();
        this.setupFilters();
    }

    setupEventListeners() {
        // Обработчики модальных окон
        document.querySelectorAll('.cancel-btn').forEach(btn => {
            btn.addEventListener('click', () => this.closeAllModals());
        });

        // Форма редактирования
        document.getElementById('editUserForm').addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleEditSubmit();
        });

        // Форма смены пароля
        document.getElementById('changePasswordForm').addEventListener('submit', (e) => {
            e.preventDefault();
            this.handlePasswordChange();
        });
    }

    setupFilters() {
        const filters = ['loginFilter', 'nameFilter', 'roleFilter', 'dateFilter'];
        filters.forEach(filterId => {
            document.getElementById(filterId).addEventListener('input', () => this.applyFilters());
        });
    }

    renderUsers(users = this.userService.getAllUsers()) {
        const tbody = document.getElementById('usersTableBody');
        tbody.innerHTML = '';

        users.forEach(user => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${user.login}</td>
                <td>${user.name}</td>
                <td>${user.role === 'admin' ? 'Администратор' : 'Пользователь'}</td>
                <td>${user.registrationDate}</td>
                <td>
                    <div class="action-buttons">
                        <button class="edit-btn" data-login="${user.login}">
                            <i class="fas fa-edit"></i> Редактировать
                        </button>
                        <button class="delete-btn" data-login="${user.login}">
                            <i class="fas fa-trash"></i> Удалить
                        </button>
                        <button class="password-btn" data-login="${user.login}">
                            <i class="fas fa-key"></i> Сменить пароль
                        </button>
                    </div>
                </td>
            `;

            // Добавляем обработчики для кнопок
            tr.querySelector('.edit-btn').addEventListener('click', () => this.openEditModal(user));
            tr.querySelector('.delete-btn').addEventListener('click', () => this.handleDelete(user.login));
            tr.querySelector('.password-btn').addEventListener('click', () => this.openPasswordModal(user.login));

            tbody.appendChild(tr);
        });
    }

    applyFilters() {
        const loginFilter = document.getElementById('loginFilter').value.toLowerCase();
        const nameFilter = document.getElementById('nameFilter').value.toLowerCase();
        const roleFilter = document.getElementById('roleFilter').value;
        const dateFilter = document.getElementById('dateFilter').value;

        const filteredUsers = this.userService.getAllUsers().filter(user => {
            return user.login.toLowerCase().includes(loginFilter) &&
                   user.name.toLowerCase().includes(nameFilter) &&
                   (roleFilter === '' || user.role === roleFilter) &&
                   (dateFilter === '' || user.registrationDate === dateFilter);
        });

        this.renderUsers(filteredUsers);
    }

    openEditModal(user) {
        if (this.currentUser.role !== 'admin' && user.role === 'admin') {
            alert('У вас нет прав для редактирования администратора');
            return;
        }

        const modal = document.getElementById('editModal');
        document.getElementById('editLogin').value = user.login;
        document.getElementById('editName').value = user.name;
        document.getElementById('editRole').value = user.role;
        modal.style.display = 'block';
    }

    openPasswordModal(login) {
        const modal = document.getElementById('passwordModal');
        modal.dataset.login = login;
        modal.style.display = 'block';
    }

    closeAllModals() {
        document.querySelectorAll('.modal').forEach(modal => {
            modal.style.display = 'none';
        });
    }

    handleEditSubmit() {
        const login = document.getElementById('editLogin').value;
        const name = document.getElementById('editName').value;
        const role = document.getElementById('editRole').value;

        if (this.currentUser.role !== 'admin' && role === 'admin') {
            alert('У вас нет прав назначать роль администратора');
            return;
        }

        const success = this.userService.updateUser(login, { name, role });
        if (success) {
            this.closeAllModals();
            this.renderUsers();
        }
    }

    handleDelete(login) {
        if (confirm('Вы уверены, что хотите удалить этого пользователя?')) {
            const success = this.userService.deleteUser(login);
            if (success) {
                this.renderUsers();
            }
        }
    }

    handlePasswordChange() {
        const modal = document.getElementById('passwordModal');
        const login = modal.dataset.login;
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        if (newPassword !== confirmPassword) {
            alert('Пароли не совпадают');
            return;
        }

        const success = this.userService.changePassword(login, newPassword);
        if (success) {
            this.closeAllModals();
            document.getElementById('newPassword').value = '';
            document.getElementById('confirmPassword').value = '';
        }
    }
}

// Инициализация приложения
document.addEventListener('DOMContentLoaded', () => {
    const adminUI = new AdminUI();
}); 