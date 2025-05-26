
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
        
        this.container = document.getElementById(this.containerId);
        this.loadingIndicator = document.getElementById(this.loadingId);
        this.startTimeInput = document.getElementById(this.startTimeInputId);
        this.endTimeInput = document.getElementById(this.endTimeInputId);
        this.slotsJsonInput = document.getElementById(this.slotsJsonInputId);
        this.summaryElement = document.getElementById(this.summaryId);
        this.submitButton = document.getElementById(this.submitButtonId);
        
        this.selectedSlots = [...this.initialSlots];
    }
    
    loadTimeSlots(date) {
        if (!this.container || !this.loadingIndicator) return;
        

        this.loadingIndicator.style.display = 'block';
        this.container.innerHTML = '';
        

        fetch(`/mahasiswa/jadwal/timeslots?id_ruangan=${this.ruanganId}&tanggal=${date}`)
            .then(response => response.json())
            .then(slots => this.renderTimeSlots(slots))
            .catch(error => {
                this.loadingIndicator.style.display = 'none';
                this.container.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-circle me-2"></i>
                        Gagal memuat slot waktu. Silakan coba lagi nanti.
                    </div>
                `;
                console.error('Error fetching time slots:', error);
            });
    }
    
    renderTimeSlots(slots) {
        this.loadingIndicator.style.display = 'none';
        
        if (slots.length === 0) {
            this.container.innerHTML = `
                <div class="alert alert-warning">
                    <i class="fa fa-exclamation-circle me-2"></i>
                    Tidak ada slot waktu tersedia untuk tanggal ini
                </div>
            `;
            return;
        }
        

        this.container.innerHTML = `
            <div class="alert alert-info mb-4">
                <i class="fa fa-info-circle me-2"></i>
                Pilih beberapa slot waktu berurutan untuk membuat peminjaman
            </div>
            <div class="d-flex flex-wrap gap-3 mb-4 justify-content-center">
                <div class="d-flex align-items-center">
                    <span style="background-color: #d1e7dd; width: 16px; height: 16px; display: inline-block; border-radius: 4px; margin-right: 8px;"></span>
                    <span>Tersedia</span>
                </div>
                <div class="d-flex align-items-center">
                    <span style="background-color: #fff3cd; width: 16px; height: 16px; display: inline-block; border-radius: 4px; margin-right: 8px;"></span>
                    <span>Dalam Proses</span>
                </div>
                <div class="d-flex align-items-center">
                    <span style="background-color: #f8d7da; width: 16px; height: 16px; display: inline-block; border-radius: 4px; margin-right: 8px;"></span>
                    <span>Sudah Dipesan</span>
                </div>
            </div>
            <div class="row" id="slotsList-${this.containerId}"></div>
        `;
        
        const slotsList = document.getElementById(`slotsList-${this.containerId}`);
        if (!slotsList) return;
        

        slots.forEach(slot => {
            const slotElement = document.createElement('div');
            slotElement.className = 'col-md-3 col-sm-6 mb-3';
            
            const slotInner = document.createElement('div');
            slotInner.className = 'time-slot';
            slotInner.dataset.start = slot.start;
            slotInner.dataset.end = slot.end;
            slotInner.dataset.status = slot.status;
            

            if (slot.status === 'proses') {
                slotInner.classList.add('proses');
                slotInner.style.backgroundColor = '#fff3cd';
                slotInner.style.borderColor = '#ffecb5';
                slotInner.style.color = '#664d03';
                slotInner.style.cursor = 'not-allowed';
            } else if (slot.status === 'booked') {
                slotInner.classList.add('booked');
                slotInner.style.backgroundColor = '#f8d7da';
                slotInner.style.borderColor = '#f5c2c7';
                slotInner.style.color = '#842029';
                slotInner.style.cursor = 'not-allowed';
            } else {
                slotInner.classList.add('tersedia');
            }
            
            slotInner.innerHTML = `
                <i class="fa fa-clock-o me-2"></i>
                ${slot.start} - ${slot.end}
            `;
            

            const isSelected = this.selectedSlots.some(s => 
                s.start === slot.start && s.end === slot.end);
                
            if (isSelected && slot.status === 'tersedia') {
                slotInner.classList.add('selected');
                slotInner.style.backgroundColor = '#cfe2ff';
                slotInner.style.borderColor = '#9ec5fe';
                slotInner.style.boxShadow = '0 0 0 0.25rem rgba(13, 110, 253, 0.25)';
                slotInner.style.color = '#0d6efd';
                slotInner.style.fontWeight = 'bold';
            }
            

            if (slot.status === 'tersedia') {
                slotInner.addEventListener('click', () => this.toggleSlotSelection(slotInner, slot));
            } else {

                const statusIcon = document.createElement('span');
                statusIcon.className = 'position-absolute top-0 end-0 p-1';
                statusIcon.innerHTML = `<i class="fa fa-${slot.status === 'proses' ? 'clock-o' : 'lock'}" style="font-size: 0.8rem;"></i>`;
                slotInner.style.position = 'relative';
                slotInner.appendChild(statusIcon);
            }
            
            slotElement.appendChild(slotInner);
            slotsList.appendChild(slotElement);
        });

        this.updateTimeRange();
    }
    
    toggleSlotSelection(slotElement, slot) {

        if (slotElement.dataset.status !== 'tersedia') return;
        
        slotElement.classList.toggle('selected');
        
        if (slotElement.classList.contains('selected')) {

            slotElement.style.backgroundColor = '#cfe2ff';
            slotElement.style.borderColor = '#9ec5fe';
            slotElement.style.boxShadow = '0 0 0 0.25rem rgba(13, 110, 253, 0.25)';
            slotElement.style.color = '#0d6efd';
            slotElement.style.fontWeight = 'bold';
            
            this.selectedSlots.push({
                start: slot.start,
                end: slot.end
            });
        } else {

            slotElement.style.backgroundColor = '#f8f9fa';
            slotElement.style.borderColor = '#dee2e6';
            slotElement.style.boxShadow = 'none';
            slotElement.style.color = '';
            slotElement.style.fontWeight = '';
            
            const index = this.selectedSlots.findIndex(s => 
                s.start === slot.start && s.end === slot.end);
            if (index !== -1) {
                this.selectedSlots.splice(index, 1);
            }
        }
        
        this.updateTimeRange();
    }
    
    updateTimeRange() {
        if (this.selectedSlots.length > 0) {

            const sortedSlots = [...this.selectedSlots].sort((a, b) => 
                a.start.localeCompare(b.start));
                

            let isContiguous = true;
            for (let i = 0; i < sortedSlots.length - 1; i++) {
                if (sortedSlots[i].end !== sortedSlots[i + 1].start) {
                    isContiguous = false;
                    break;
                }
            }
            
            if (isContiguous) {

                this.startTimeInput.value = sortedSlots[0].start;
                this.endTimeInput.value = sortedSlots[sortedSlots.length - 1].end;
                this.slotsJsonInput.value = JSON.stringify(sortedSlots);
                

                if (this.submitButton) {
                    this.submitButton.disabled = false;
                }
                

                if (this.summaryElement) {
                    this.summaryElement.innerHTML = `
                        <div class="alert alert-success">
                            <strong>Waktu terpilih:</strong> ${sortedSlots[0].start} - ${sortedSlots[sortedSlots.length - 1].end}
                        </div>
                    `;
                }
            } else {
                if (this.submitButton) {
                    this.submitButton.disabled = true;
                }
                
                if (this.summaryElement) {
                    this.summaryElement.innerHTML = `
                        <div class="alert alert-danger">
                            <strong>Error:</strong> Slot waktu harus berurutan!
                        </div>
                    `;
                }
            }
        } else {
            if (this.submitButton) {
                this.submitButton.disabled = true;
            }
            
            if (this.summaryElement) {
                this.summaryElement.innerHTML = `
                    <div class="alert alert-warning">
                        <strong>Perhatian:</strong> Belum ada slot waktu yang dipilih
                    </div>
                `;
            }
        }
    }
}


window.TimeSlotSelector = TimeSlotSelector;