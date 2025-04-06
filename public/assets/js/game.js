class Game {
    constructor() {
        this.bird = document.querySelector('.bird');
        this.gameContainer = document.querySelector('.game-container');
        this.startScreen = document.querySelector('.start-screen');
        this.startButton = document.getElementById('start-game');
        this.pipesCount = 0;
        this.coinsCount = 0;
        this.isGameOver = false;
        this.birdY = 300;
        this.birdVelocity = 0;
        this.gravity = 0.5;
        this.jumpForce = -10;
        this.pipes = [];
        this.coins = [];
        this.pipeGap = 250;
        this.pipeInterval = 2000;
        this.coinInterval = 2000;
        this.pipeSpeed = 1.5;
        
        this.setupEventListeners();
    }

    setupEventListeners() {
        this.startButton.addEventListener('click', () => {
            this.startScreen.classList.add('hidden');
            this.gameContainer.classList.remove('hidden');
            this.init();
        });

        document.addEventListener('keydown', (e) => {
            if (e.code === 'Space' && !this.isGameOver) {
                this.jump();
            }
        });

        document.getElementById('restart').addEventListener('click', () => {
            this.restartGame();
        });
    }

    init() {
        this.createBirdElements();
        this.gameLoop();
        this.createPipes();
        this.createCoins();
    }

    createBirdElements() {
        const wing = document.createElement('div');
        wing.className = 'wing';
        this.bird.appendChild(wing);

        const beak = document.createElement('div');
        beak.className = 'beak';
        this.bird.appendChild(beak);
    }

    jump() {
        this.birdVelocity = this.jumpForce;
        // Ускоряем анимацию крыльев при прыжке
        const wing = this.bird.querySelector('.wing');
        wing.style.animationDuration = '0.2s';
        setTimeout(() => {
            wing.style.animationDuration = '0.3s';
        }, 200);
    }

    updateBird() {
        this.birdVelocity += this.gravity;
        this.birdY += this.birdVelocity;
        this.bird.style.top = `${this.birdY}px`;
        
        // Простой поворот птицы
        const rotation = Math.min(Math.max(this.birdVelocity * 2, -30), 90);
        this.bird.style.transform = `rotate(${rotation}deg)`;

        if (this.birdY <= 0 || this.birdY >= this.gameContainer.offsetHeight - this.bird.offsetHeight) {
            this.gameOver();
        }
    }

    createPipes() {
        setInterval(() => {
            if (this.isGameOver) return;

            const pipeTop = document.createElement('div');
            const pipeBottom = document.createElement('div');
            const gapPosition = Math.random() * (this.gameContainer.offsetHeight - this.pipeGap - 200) + 100;

            pipeTop.className = 'pipe top';
            pipeBottom.className = 'pipe bottom';

            pipeTop.style.height = `${gapPosition}px`;
            pipeBottom.style.height = `${this.gameContainer.offsetHeight - gapPosition - this.pipeGap}px`;
            pipeTop.style.left = `${this.gameContainer.offsetWidth}px`;
            pipeBottom.style.left = `${this.gameContainer.offsetWidth}px`;
            pipeBottom.style.top = `${gapPosition + this.pipeGap}px`;

            this.gameContainer.appendChild(pipeTop);
            this.gameContainer.appendChild(pipeBottom);

            this.pipes.push({ top: pipeTop, bottom: pipeBottom });
            
            // Создаем монетку между трубами
            this.createCoinBetweenPipes(gapPosition, parseInt(pipeTop.style.height), parseInt(pipeBottom.style.height));
        }, this.pipeInterval);
    }

    createCoinBetweenPipes(gapPosition, pipeTopHeight, pipeBottomHeight) {
        const coin = document.createElement('div');
        coin.className = 'coin';
        
        // Размещаем монетку точно между трубами
        const coinY = gapPosition + (this.pipeGap / 2) - 15; // 15 - половина высоты монетки
        coin.style.top = `${coinY}px`;
        coin.style.left = `${this.gameContainer.offsetWidth + 30}px`;
        
        this.gameContainer.appendChild(coin);
        this.coins.push(coin);
    }

    createCoins() {
        // Метод оставлен пустым, так как монетки теперь создаются в createPipes
    }

    isPositionInPipeArea(y) {
        return this.pipes.some(pipe => {
            const pipeLeft = parseInt(pipe.top.style.left);
            const pipeTopHeight = parseInt(pipe.top.style.height);
            const pipeBottomTop = this.gameContainer.offsetHeight - parseInt(pipe.bottom.style.height);
            
            return pipeLeft > 0 && pipeLeft < this.gameContainer.offsetWidth &&
                   (y < pipeTopHeight || y > pipeBottomTop);
        });
    }

    updatePipes() {
        this.pipes.forEach((pipe, index) => {
            const currentLeft = parseInt(pipe.top.style.left);
            const newLeft = currentLeft - this.pipeSpeed;
            
            pipe.top.style.left = `${newLeft}px`;
            pipe.bottom.style.left = `${newLeft}px`;

            if (newLeft < -80) {
                this.gameContainer.removeChild(pipe.top);
                this.gameContainer.removeChild(pipe.bottom);
                this.pipes.splice(index, 1);
                this.pipesCount++;
                document.getElementById('pipes-count').textContent = this.pipesCount;

                if (this.pipesCount >= 33) {
                    this.gameOver();
                }
            }

            // Проверяем коллизию только если труба находится в зоне птицы
            if (newLeft < this.gameContainer.offsetWidth && newLeft > -80) {
                if (this.checkCollision(pipe.top) || this.checkCollision(pipe.bottom)) {
                    this.gameOver();
                }
            }
        });
    }

    updateCoins() {
        this.coins.forEach((coin, index) => {
            const currentLeft = parseInt(coin.style.left);
            const newLeft = currentLeft - this.pipeSpeed;
            coin.style.left = `${newLeft}px`;

            if (newLeft < -35) {
                this.gameContainer.removeChild(coin);
                this.coins.splice(index, 1);
            }

            // Проверяем коллизию только если монетка находится в зоне птицы
            if (newLeft < this.gameContainer.offsetWidth && newLeft > -35) {
                if (this.checkCoinCollision(coin)) {
                    this.gameContainer.removeChild(coin);
                    this.coins.splice(index, 1);
                    this.coinsCount++;
                    document.getElementById('coins-count').textContent = this.coinsCount;

                    if (this.coinsCount >= 33) {
                        this.gameOver();
                    }
                }
            }
        });
    }

    checkCollision(pipe) {
        const birdRect = this.bird.getBoundingClientRect();
        const pipeRect = pipe.getBoundingClientRect();
        
        // Добавляем небольшой отступ для более точной проверки коллизий
        const birdMargin = 5;
        
        return !(
            birdRect.right - birdMargin < pipeRect.left ||
            birdRect.left + birdMargin > pipeRect.right ||
            birdRect.bottom - birdMargin < pipeRect.top ||
            birdRect.top + birdMargin > pipeRect.bottom
        );
    }

    checkCoinCollision(coin) {
        const birdRect = this.bird.getBoundingClientRect();
        const coinRect = coin.getBoundingClientRect();
        
        // Добавляем небольшой отступ для более точной проверки коллизий
        const birdMargin = 5;
        
        return !(
            birdRect.right - birdMargin < coinRect.left ||
            birdRect.left + birdMargin > coinRect.right ||
            birdRect.bottom - birdMargin < coinRect.top ||
            birdRect.top + birdMargin > coinRect.bottom
        );
    }

    gameOver() {
        this.isGameOver = true;
        const gameOverElement = document.querySelector('.game-over');
        const resultText = `Трубы: ${this.pipesCount}/33\nМонетки: ${this.coinsCount}/33`;
        gameOverElement.querySelector('h2').textContent = resultText;
        gameOverElement.classList.remove('hidden');
    }

    restartGame() {
        this.pipes.forEach(pipe => {
            this.gameContainer.removeChild(pipe.top);
            this.gameContainer.removeChild(pipe.bottom);
        });
        this.coins.forEach(coin => {
            this.gameContainer.removeChild(coin);
        });

        this.pipes = [];
        this.coins = [];
        this.pipesCount = 0;
        this.coinsCount = 0;
        this.birdY = 300;
        this.birdVelocity = 0;
        this.isGameOver = false;

        document.getElementById('pipes-count').textContent = '0';
        document.getElementById('coins-count').textContent = '0';
        document.querySelector('.game-over').classList.add('hidden');
        this.bird.style.top = `${this.birdY}px`;
        this.bird.style.transform = 'rotate(0deg)';
    }

    gameLoop() {
        if (!this.isGameOver) {
            this.updateBird();
            this.updatePipes();
            this.updateCoins();
        }
        requestAnimationFrame(() => this.gameLoop());
    }
}

new Game(); 