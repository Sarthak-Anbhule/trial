/**
 * CIY - Cook It Yourself
 * Interactive Cooking Mode Controller & Step Countdown Timer
 */

class CookingModeManager {
    constructor() {
        this.currentStep = 0;
        this.steps = [];
        this.timerInterval = null;
        this.timeLeft = 0;
        this.isTimerRunning = false;
        
        this.init();
    }

    init() {
        document.addEventListener('click', (e) => {
            const startBtn = e.target.closest('#btnStartCooking');
            if (startBtn) {
                e.preventDefault();
                this.launchModal();
            }
        });

        // Modal Controls
        document.addEventListener('click', (e) => {
            if (e.target.closest('#cookNextStep')) this.nextStep();
            if (e.target.closest('#cookPrevStep')) this.prevStep();
            if (e.target.closest('#cookToggleTimer')) this.toggleTimer();
            if (e.target.closest('#cookResetTimer')) this.resetTimer();
        });
    }

    launchModal() {
        const rawSteps = window.CIY_RECIPE_STEPS || [];
        if (rawSteps.length === 0) {
            showToast('No step instructions available for cooking mode.', 'error');
            return;
        }

        this.steps = rawSteps;
        this.currentStep = 0;

        const modalEl = document.getElementById('cookingModeModal');
        if (modalEl) {
            const bsModal = new bootstrap.Modal(modalEl);
            bsModal.show();
            this.renderStep();
        }
    }

    renderStep() {
        const modalEl = document.getElementById('cookingModeModal');
        const langStep = modalEl ? modalEl.dataset.langStep || 'Step' : 'Step';
        const langNext = modalEl ? modalEl.dataset.langNext || 'Next Step →' : 'Next Step →';
        const langFinish = modalEl ? modalEl.dataset.langFinish || 'Finish Cooking 🎉' : 'Finish Cooking 🎉';

        const step = this.steps[this.currentStep];
        if (!step) return;

        document.getElementById('cookStepCounter').textContent = `${langStep} ${this.currentStep + 1} / ${this.steps.length}`;
        document.getElementById('cookStepTitle').textContent = step.title || `${langStep} ${this.currentStep + 1}`;
        document.getElementById('cookStepInstruction').textContent = step.instruction;

        const progressPercent = ((this.currentStep + 1) / this.steps.length) * 100;
        document.getElementById('cookProgressBar').style.width = `${progressPercent}%`;

        // Update Timer
        this.stopTimer();
        this.timeLeft = (step.time_minutes || 5) * 60;
        this.updateTimerDisplay();

        // Control buttons state
        document.getElementById('cookPrevStep').disabled = (this.currentStep === 0);
        document.getElementById('cookNextStep').textContent = (this.currentStep === this.steps.length - 1) ? langFinish : langNext;
    }

    nextStep() {
        const modalEl = document.getElementById('cookingModeModal');
        const langCompleted = modalEl ? modalEl.dataset.langCompleted || 'Bon Appétit! Cooking Completed!' : 'Bon Appétit! Cooking Completed!';
        if (this.currentStep < this.steps.length - 1) {
            this.currentStep++;
            this.renderStep();
        } else {
            showToast(langCompleted);
            const bsModal = bootstrap.Modal.getInstance(modalEl);
            if (bsModal) bsModal.hide();
        }
    }

    prevStep() {
        if (this.currentStep > 0) {
            this.currentStep--;
            this.renderStep();
        }
    }

    toggleTimer() {
        if (this.isTimerRunning) {
            this.stopTimer();
        } else {
            this.startTimer();
        }
    }

    startTimer() {
        if (this.timeLeft <= 0) return;
        this.isTimerRunning = true;
        const modalEl = document.getElementById('cookingModeModal');
        const langPause = modalEl ? modalEl.dataset.langPause || 'Pause Timer' : 'Pause Timer';
        const toggleBtn = document.getElementById('cookToggleTimer');
        if (toggleBtn) toggleBtn.innerHTML = `<i class="fa-solid fa-pause me-1"></i> ${langPause}`;

        this.timerInterval = setInterval(() => {
            this.timeLeft--;
            this.updateTimerDisplay();

            if (this.timeLeft <= 0) {
                this.stopTimer();
                this.playAlarmSound();
                showToast('Timer Finished! Step ready!', 'success');
            }
        }, 1000);
    }

    stopTimer() {
        this.isTimerRunning = false;
        clearInterval(this.timerInterval);
        const modalEl = document.getElementById('cookingModeModal');
        const langStart = modalEl ? modalEl.dataset.langStart || 'Start Timer' : 'Start Timer';
        const toggleBtn = document.getElementById('cookToggleTimer');
        if (toggleBtn) toggleBtn.innerHTML = `<i class="fa-solid fa-play me-1"></i> ${langStart}`;
    }

    resetTimer() {
        this.stopTimer();
        const step = this.steps[this.currentStep];
        this.timeLeft = (step ? step.time_minutes || 5 : 5) * 60;
        this.updateTimerDisplay();
    }

    updateTimerDisplay() {
        const mins = Math.floor(this.timeLeft / 60);
        const secs = this.timeLeft % 60;
        const display = `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
        const displayEl = document.getElementById('cookTimerDisplay');
        if (displayEl) displayEl.textContent = display;
    }

    playAlarmSound() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const osc = ctx.createOscillator();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(587.33, ctx.currentTime); // D5
            osc.connect(ctx.destination);
            osc.start();
            osc.stop(ctx.currentTime + 0.5);
        } catch (e) {
            console.log('Audio notification trigger fallback');
        }
    }
}

// Instantiate cooking manager
window.cookingManager = new CookingModeManager();
