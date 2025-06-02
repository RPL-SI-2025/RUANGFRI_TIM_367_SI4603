
/**
 * TimeSlotSelector - Reusable time slot selection component
 * 
 * @param {Object} config Configuration options
 * @param {String} config.containerId Container element ID for time slots
 * @param {String} config.loadingId Loading indicator element ID
 * @param {String} config.startTimeInputId Input element ID for start time
 * @param {String} config.endTimeInputId Input element ID for end time
 * @param {String} config.slotsJsonInputId Input element ID for selected slots JSON
 * @param {String} config.summaryId Summary display element ID
 * @param {String} config.submitButtonId Submit button element ID
 * @param {Array} config.initialSlots Initial selected slots array
 * @param {Number} config.ruanganId Ruangan ID for fetching slots
 */
/**
 * TimeSlotSelector - Reusable time slot selection component
 */
/**
 * TimeSlotSelector - Reusable time slot selection component with smart selection
 */
class TimeSlotSelector {
    constructor(config) {
        this.containerId = config.containerId;
        this.loadingId = config.loadingId;
        this.startTimeInputId = config.startTimeInputId;
        this.endTimeInputId = config.endTimeInputId;
        this.slotsJsonInputId = config.slotsJsonInputId;
        this.summaryId = config.summaryId;
        this.submitButtonId = config.submitButtonId;
        this.initialSlots = config.initialSlots || [];
        this.ruanganId = config.ruanganId;
        
        // DOM elements
        this.container = document.getElementById(this.containerId);
        this.loadingIndicator = document.getElementById(this.loadingId);
        this.startTimeInput = document.getElementById(this.startTimeInputId);
        this.endTimeInput = document.getElementById(this.endTimeInputId);
        this.slotsJsonInput = document.getElementById(this.slotsJsonInputId);
        this.summaryElement = document.getElementById(this.summaryId);
        this.submitButton = document.getElementById(this.submitButtonId);
        
        // State management
        this.selectedSlots = [...this.initialSlots];
        this.availableSlots = [];
        this.isShiftPressed = false;
        this.lastSelectedIndex = -1;
        
        // Initialize keyboard listeners for smart selection
        this.initKeyboardListeners();
    }
    
    initKeyboardListeners() {
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Shift') {
                this.isShiftPressed = true;
            }
        });
        
        document.addEventListener('keyup', (e) => {
            if (e.key === 'Shift') {
                this.isShiftPressed = false;
            }
        });
    }
    
    loadTimeSlots(date) {
        if (!this.container || !this.loadingIndicator) return;
        
        // Show loading state
        this.showLoading();
        
        // Fetch time slots
        fetch(`/mahasiswa/jadwal/timeslots?id_ruangan=${this.ruanganId}&tanggal=${date}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(slots => {
                this.availableSlots = slots;
                this.renderTimeSlots(slots);
            })
            .catch(error => {
                this.hideLoading();
                this.showError('Gagal memuat slot waktu. Silakan coba lagi nanti.');
                console.error('Error fetching time slots:', error);
            });
    }
    
    showLoading() {
        if (this.loadingIndicator) {
            this.loadingIndicator.style.display = 'block';
        }
        if (this.container) {
            this.container.innerHTML = '';
        }
    }
    
    hideLoading() {
        if (this.loadingIndicator) {
            this.loadingIndicator.style.display = 'none';
        }
    }
    
    showError(message) {
        if (this.container) {
            this.container.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fa fa-exclamation-circle me-2"></i>
                    ${message}
                    <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="this.parentElement.parentElement.querySelector('input[type=date]').dispatchEvent(new Event('change'))">
                        <i class="fa fa-refresh me-1"></i> Coba Lagi
                    </button>
                </div>
            `;
        }
    }
    
    renderTimeSlots(slots) {
        this.hideLoading();
        
        if (slots.length === 0) {
            this.container.innerHTML = `
                <div class="alert alert-warning">
                    <i class="fa fa-exclamation-circle me-2"></i>
                    Tidak ada slot waktu tersedia untuk tanggal ini
                </div>
            `;
            return;
        }
        
        // Create container with legend and smart selection info
        this.container.innerHTML = `
            <div class="slots-header mb-4">
                <div class="alert alert-info mb-3">
                    <i class="fa fa-info-circle me-2"></i>
                    <strong>Smart Selection:</strong> Klik slot pertama, lalu Shift+Klik slot terakhir untuk memilih range. 
                    Atau klik individual slot untuk memilih satu per satu.
                </div>
                <div class="slots-legend d-flex flex-wrap gap-3 justify-content-center">
                    <div class="legend-item">
                        <span class="legend-color bg-success"></span>
                        <span>Tersedia</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color bg-warning"></span>
                        <span>Dalam Proses</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color bg-danger"></span>
                        <span>Sudah Dipesan</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color bg-primary"></span>
                        <span>Dipilih</span>
                    </div>
                </div>
            </div>
            <div class="slots-grid" id="slotsList-${this.containerId}"></div>
        `;
        
        const slotsList = document.getElementById(`slotsList-${this.containerId}`);
        if (!slotsList) return;
        
        // Render individual slots
        slots.forEach((slot, index) => {
            const slotElement = this.createSlotElement(slot, index);
            slotsList.appendChild(slotElement);
        });
        
        // Update initial state
        this.updateTimeRange();
    }
    
    createSlotElement(slot, index) {
        const slotWrapper = document.createElement('div');
        slotWrapper.className = 'slot-wrapper';
        
        const slotElement = document.createElement('div');
        slotElement.className = 'time-slot';
        slotElement.dataset.start = slot.start;
        slotElement.dataset.end = slot.end;
        slotElement.dataset.status = slot.status;
        slotElement.dataset.index = index;
        
        // Set slot appearance based on status
        this.setSlotAppearance(slotElement, slot);
        
        // Add slot content
        slotElement.innerHTML = `
            <div class="slot-content">
                <i class="fa fa-clock-o me-2"></i>
                <span class="slot-time">${slot.start} - ${slot.end}</span>
                ${this.getStatusIcon(slot.status)}
            </div>
        `;
        
        // Check if slot is initially selected
        const isSelected = this.selectedSlots.some(s => 
            s.start === slot.start && s.end === slot.end);
            
        if (isSelected && slot.status === 'tersedia') {
            slotElement.classList.add('selected');
            this.setSelectedAppearance(slotElement);
        }
        
        // Add click listener for available slots
        if (slot.status === 'tersedia') {
            slotElement.addEventListener('click', (e) => this.handleSlotClick(e, slot, index));
            slotElement.style.cursor = 'pointer';
        }
        
        slotWrapper.appendChild(slotElement);
        return slotWrapper;
    }
    
    setSlotAppearance(element, slot) {
        element.classList.remove('tersedia', 'proses', 'booked', 'selected');
        
        if (slot.status === 'proses') {
            element.classList.add('proses');
            element.style.backgroundColor = '#fff3cd';
            element.style.borderColor = '#ffecb5';
            element.style.color = '#664d03';
            element.style.cursor = 'not-allowed';
        } else if (slot.status === 'booked') {
            element.classList.add('booked');
            element.style.backgroundColor = '#f8d7da';
            element.style.borderColor = '#f5c2c7';
            element.style.color = '#842029';
            element.style.cursor = 'not-allowed';
        } else {
            element.classList.add('tersedia');
            element.style.backgroundColor = '#d1e7dd';
            element.style.borderColor = '#badbcc';
            element.style.color = '#0f5132';
        }
    }
    
    setSelectedAppearance(element) {
        element.style.backgroundColor = '#cfe2ff';
        element.style.borderColor = '#9ec5fe';
        element.style.boxShadow = '0 0 0 0.25rem rgba(13, 110, 253, 0.25)';
        element.style.color = '#0d6efd';
        element.style.fontWeight = 'bold';
        element.style.transform = 'scale(1.02)';
    }
    
    resetSlotAppearance(element, slot) {
        element.classList.remove('selected');
        this.setSlotAppearance(element, slot);
        element.style.fontWeight = '';
        element.style.transform = '';
        element.style.boxShadow = '';
    }
    
    getStatusIcon(status) {
        if (status === 'proses') {
            return '<i class="fa fa-clock-o status-icon text-warning"></i>';
        } else if (status === 'booked') {
            return '<i class="fa fa-lock status-icon text-danger"></i>';
        }
        return '';
    }
    
    handleSlotClick(event, slot, index) {
        if (slot.status !== 'tersedia') return;
        
        if (this.isShiftPressed && this.lastSelectedIndex !== -1) {
            // Smart range selection
            this.selectRange(this.lastSelectedIndex, index);
        } else {
            // Single slot toggle
            this.toggleSingleSlot(event.target.closest('.time-slot'), slot, index);
        }
        
        this.lastSelectedIndex = index;
        this.updateTimeRange();
    }
    
    selectRange(startIndex, endIndex) {
        const minIndex = Math.min(startIndex, endIndex);
        const maxIndex = Math.max(startIndex, endIndex);
        
        // Clear current selection
        this.clearAllSelections();
        
        // Select range of available slots
        for (let i = minIndex; i <= maxIndex; i++) {
            const slot = this.availableSlots[i];
            if (slot && slot.status === 'tersedia') {
                const slotElement = document.querySelector(`[data-index="${i}"]`);
                if (slotElement) {
                    this.addSlotToSelection(slotElement, slot);
                }
            }
        }
    }
    
    toggleSingleSlot(slotElement, slot, index) {
        const isSelected = slotElement.classList.contains('selected');
        
        if (isSelected) {
            this.removeSlotFromSelection(slotElement, slot);
        } else {
            this.addSlotToSelection(slotElement, slot);
        }
    }
    
    addSlotToSelection(slotElement, slot) {
        if (!slotElement.classList.contains('selected')) {
            slotElement.classList.add('selected');
            this.setSelectedAppearance(slotElement);
            
            // Add to selectedSlots if not already present
            const exists = this.selectedSlots.some(s => 
                s.start === slot.start && s.end === slot.end);
            if (!exists) {
                this.selectedSlots.push({
                    start: slot.start,
                    end: slot.end
                });
            }
        }
    }
    
    removeSlotFromSelection(slotElement, slot) {
        if (slotElement.classList.contains('selected')) {
            this.resetSlotAppearance(slotElement, slot);
            
            // Remove from selectedSlots
            const index = this.selectedSlots.findIndex(s => 
                s.start === slot.start && s.end === slot.end);
            if (index !== -1) {
                this.selectedSlots.splice(index, 1);
            }
        }
    }
    
    clearAllSelections() {
        this.selectedSlots = [];
        document.querySelectorAll('.time-slot.selected').forEach(element => {
            const index = parseInt(element.dataset.index);
            const slot = this.availableSlots[index];
            if (slot) {
                this.resetSlotAppearance(element, slot);
            }
        });
    }
    
    updateTimeRange() {
        if (this.selectedSlots.length > 0) {
            // Sort selected slots by start time
            const sortedSlots = [...this.selectedSlots].sort((a, b) => 
                a.start.localeCompare(b.start));
            
            // Check if slots are contiguous
            const isContiguous = this.checkContiguity(sortedSlots);
            
            if (isContiguous) {
                // Update form inputs
                if (this.startTimeInput) this.startTimeInput.value = sortedSlots[0].start;
                if (this.endTimeInput) this.endTimeInput.value = sortedSlots[sortedSlots.length - 1].end;
                if (this.slotsJsonInput) this.slotsJsonInput.value = JSON.stringify(sortedSlots);
                
                // Enable submit button
                if (this.submitButton) {
                    this.submitButton.disabled = false;
                    this.submitButton.classList.remove('btn-disabled');
                }
                
                // Show success summary
                this.showSuccessSummary(sortedSlots);
            } else {
                // Disable submit and show error
                if (this.submitButton) {
                    this.submitButton.disabled = true;
                    this.submitButton.classList.add('btn-disabled');
                }
                this.showErrorSummary('Slot waktu harus berurutan tanpa jeda!');
            }
        } else {
            // No slots selected
            if (this.submitButton) {
                this.submitButton.disabled = true;
                this.submitButton.classList.add('btn-disabled');
            }
            this.showWarningSummary('Belum ada slot waktu yang dipilih');
        }
    }
    
    checkContiguity(sortedSlots) {
        for (let i = 0; i < sortedSlots.length - 1; i++) {
            if (sortedSlots[i].end !== sortedSlots[i + 1].start) {
                return false;
            }
        }
        return true;
    }
    
    showSuccessSummary(sortedSlots) {
        if (this.summaryElement) {
            const duration = this.calculateDuration(sortedSlots[0].start, sortedSlots[sortedSlots.length - 1].end);
            this.summaryElement.innerHTML = `
                <div class="alert alert-success">
                    <i class="fa fa-check-circle me-2"></i>
                    <strong>Waktu terpilih:</strong> ${sortedSlots[0].start} - ${sortedSlots[sortedSlots.length - 1].end}
                    <small class="d-block mt-1">Durasi: ${duration} | ${sortedSlots.length} slot</small>
                </div>
            `;
        }
    }
    
    showErrorSummary(message) {
        if (this.summaryElement) {
            this.summaryElement.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fa fa-exclamation-triangle me-2"></i>
                    <strong>Error:</strong> ${message}
                    <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="this.closest('.time-slot-selector').querySelector('.clear-selection')?.click()">
                        <i class="fa fa-times me-1"></i> Bersihkan
                    </button>
                </div>
            `;
        }
    }
    
    showWarningSummary(message) {
        if (this.summaryElement) {
            this.summaryElement.innerHTML = `
                <div class="alert alert-warning">
                    <i class="fa fa-exclamation-triangle me-2"></i>
                    <strong>Perhatian:</strong> ${message}
                </div>
            `;
        }
    }
    
    calculateDuration(startTime, endTime) {
        const start = new Date(`2000-01-01 ${startTime}`);
        const end = new Date(`2000-01-01 ${endTime}`);
        const diffMs = end - start;
        const diffHours = Math.floor(diffMs / (1000 * 60 * 60));
        const diffMinutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));
        
        if (diffHours > 0 && diffMinutes > 0) {
            return `${diffHours} jam ${diffMinutes} menit`;
        } else if (diffHours > 0) {
            return `${diffHours} jam`;
        } else {
            return `${diffMinutes} menit`;
        }
    }
    
    // Public method to clear selections
    clearSelections() {
        this.clearAllSelections();
        this.lastSelectedIndex = -1;
        this.updateTimeRange();
    }
    
    // Public method to select all available slots
    selectAllAvailable() {
        this.clearAllSelections();
        
        this.availableSlots.forEach((slot, index) => {
            if (slot.status === 'tersedia') {
                const slotElement = document.querySelector(`[data-index="${index}"]`);
                if (slotElement) {
                    this.addSlotToSelection(slotElement, slot);
                }
            }
        });
        
        this.updateTimeRange();
    }
}

// Make TimeSlotSelector available globally
window.TimeSlotSelector = TimeSlotSelector;