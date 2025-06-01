
<div class="custom-modal-backdrop" id="customBackdrop{{ $iteration }}"></div>
<div class="custom-modal" id="customModal{{ $iteration }}" style="display: none;">
    <div class="custom-modal-dialog custom-modal-wide">
        <div class="custom-modal-content">
            <div class="custom-modal-header">
                <div class="d-flex align-items-center">
                    <div class="icon-wrapper-modal">
                        <i class="fa fa-edit"></i>
                    </div>
                    <h5 class="custom-modal-title ms-3">
                        Edit Peminjaman Ruangan
                    </h5>
                </div>
                <button type="button" class="custom-modal-close" data-close-modal="customModal{{ $iteration }}">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            
            <form action="{{ route('mahasiswa.cart.keranjang_ruangan.update', $key) }}" method="POST" id="editForm{{ $iteration }}">
                @csrf
                @method('PUT')

                
                
                <div class="custom-modal-body">
                    <!-- Baris 1: Room Info & Date Selection -->
                    <div class="row g-4 mb-4">
                        <!-- Room Info Section -->
                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="info-header">
                                    <i class="fa fa-building text-primary me-2"></i>
                                    <h6 class="mb-0">{{ $item['nama_ruangan'] }}</h6>
                                </div>
                                <div class="info-badges">
                                    <span class="info-badge">
                                        <i class="fa fa-map-marker me-1"></i> {{ $item['lokasi'] }}
                                    </span>
                                    <span class="info-badge">
                                        <i class="fa fa-users me-1"></i> {{ $item['kapasitas'] ?? 'N/A' }} orang
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Date Selection -->
                        <div class="col-md-6">
                            <div class="form-group-compact">
                                <label for="tanggal_booking{{ $iteration }}" class="form-label-compact">
                                    <i class="fa fa-calendar me-2"></i>Tanggal Booking
                                </label>
                                <input type="date" 
                                       class="form-control-compact" 
                                       id="tanggal_booking{{ $iteration }}" 
                                       name="tanggal_booking" 
                                       value="{{ $item['tanggal_booking'] }}" 
                                       required>
                                <div class="form-help-compact">Pilih tanggal untuk melihat slot tersedia</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Baris 2: Loading State & Time Slots -->
                    <div class="row g-4 mb-4">
                        <div class="col-12">
                            <!-- Loading State -->
                            <div id="loadingSlots{{ $iteration }}" class="loading-compact" style="display: none;">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <span class="text-muted">Memuat slot waktu...</span>
                                </div>
                            </div>
                            
                            <!-- Time Slots Section -->
                            <div class="form-group-compact">
                                <label class="form-label-compact">
                                    <i class="fa fa-clock me-2"></i>Pilih Slot Waktu
                                </label>
                                <div id="timeSlots{{ $iteration }}" class="time-slots-container">
                                    <div class="empty-slots-state">
                                        <i class="fa fa-calendar-o fa-lg text-muted mb-2"></i>
                                        <p class="text-muted mb-0 small">Pilih tanggal untuk melihat slot tersedia</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4">
                        <!-- Current Selection -->
                        <div class="col-md-6">
                            <div class="current-selection-card">
                                <div class="selection-header">
                                    <div class="selection-icon">
                                        <i class="fa fa-clock text-white"></i>
                                    </div>
                                    <div class="selection-info">
                                        <strong class="selection-title">Waktu Terpilih</strong>
                                        <div class="selection-time">
                                            <span class="time-badge">
                                                {{ date('H:i', strtotime($item['waktu_mulai'])) }} - 
                                                {{ date('H:i', strtotime($item['waktu_selesai'])) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Current Slots Detail -->
                        <div class="col-md-6">
                            @if(isset($item['selected_slots']) && is_array($item['selected_slots']) && count($item['selected_slots']) > 0)
                                <div class="slots-detail-card">
                                    <label class="form-label-compact mb-2">Detail Slot Saat Ini</label>
                                    <div class="slots-container">
                                        @foreach($item['selected_slots'] as $slot)
                                            <span class="slot-tag">
                                                <i class="fa fa-clock me-1"></i>
                                                {{ $slot['start'] }} - {{ $slot['end'] }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Hidden Inputs -->
                    <input type="hidden" name="waktu_mulai" id="waktu_mulai{{ $iteration }}" value="{{ date('H:i', strtotime($item['waktu_mulai'])) }}">
                    <input type="hidden" name="waktu_selesai" id="waktu_selesai{{ $iteration }}" value="{{ date('H:i', strtotime($item['waktu_selesai'])) }}">
                    <input type="hidden" name="selected_slots_json" id="selected_slots_json{{ $iteration }}" value="">
                    
                    <!-- Time Range Summary Hidden -->
                    <div id="timeRangeSummary{{ $iteration }}" style="display: none;"></div>
                </div>
                
                <div class="custom-modal-footer">
                    <button type="button" class="btn-modal btn-modal-secondary" data-close-modal="customModal{{ $iteration }}">
                        <i class="fa fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn-modal btn-modal-primary" id="submitBtn{{ $iteration }}">
                        <i class="fa fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>

.custom-modal-wide {
    max-width: 850px !important;
    width: 95% !important;
}

.custom-modal-wide .custom-modal-content {
    max-height: 80vh !important;
}

.custom-modal-wide .custom-modal-body {
    max-height: 55vh !important;
    padding: 1.5rem !important;
}


.form-group-compact {
    margin-bottom: 1rem;
}

.form-label-compact {
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    font-size: 0.9rem;
}

.form-control-compact {
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 0.5rem 0.75rem;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: #ffffff;
    width: 100%;
}

.form-control-compact:focus {
    border-color: #1e293b;
    box-shadow: 0 0 0 3px rgba(30, 41, 59, 0.1);
    outline: none;
}

.form-help-compact {
    color: #6b7280;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}


.info-card {
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1rem;
    height: 100%;
}

.info-header {
    display: flex;
    align-items: center;
    margin-bottom: 0.75rem;
}

.info-header h6 {
    color: #1e293b;
    font-weight: 600;
}

.info-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.info-badge {
    background: rgba(30, 41, 59, 0.1);
    color: #475569;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    border: 1px solid rgba(30, 41, 59, 0.15);
}


.current-selection-card {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    border-radius: 12px;
    padding: 1rem;
    color: white;
    height: 100%;
}

.selection-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.selection-icon {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.selection-title {
    font-size: 0.9rem;
    opacity: 0.9;
    display: block;
}

.selection-time {
    margin-top: 0.5rem;
}

.time-badge {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    border: 1px solid rgba(255, 255, 255, 0.3);
}


.slots-detail-card {
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1rem;
    height: 100%;
}

.slots-container {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    max-height: 80px;
    overflow-y: auto;
}

.slot-tag {
    background: linear-gradient(135deg, #1e293b, #334155);
    color: white;
    padding: 0.25rem 0.6rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    flex-shrink: 0;
}


.time-slots-container {
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1rem;
    min-height: 120px;
    max-height: 200px;
    overflow-y: auto;
    

}

.time-slots-container::-webkit-scrollbar {
    display: none;
}

.time-slots-container::-webkit-scrollbar-track {
    background: #f8fafc;
    border-radius: 3px;
}

.time-slots-container::-webkit-scrollbar-thumb {
    background: #94a3b8;
    border-radius: 3px;
}

.empty-slots-state {
    text-align: center;
    padding: 2rem 1rem;
}


.loading-compact {
    padding: 1rem;
    border-radius: 8px;
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    margin-bottom: 1rem;
}


.btn-modal {
    padding: 0.625rem 1.25rem;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    cursor: pointer;
}

.btn-modal-primary {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(30, 41, 59, 0.3);
}

.btn-modal-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(30, 41, 59, 0.4);
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
}

.btn-modal-secondary {
    background: #f8fafc;
    color: #64748b;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.btn-modal-secondary:hover {
    background: #e2e8f0;
    color: #475569;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}


@media (max-width: 1024px) {
    .custom-modal-wide {
        max-width: 95% !important;
        width: 95% !important;
    }
}

@media (max-width: 768px) {
    .custom-modal-wide {
        max-width: 98% !important;
        width: 98% !important;
    }
    
    .custom-modal-wide .custom-modal-body {
        padding: 1rem !important;
        max-height: 65vh !important;
    }
    
    .current-selection-card,
    .slots-detail-card,
    .info-card {
        margin-bottom: 1rem;
    }
    
    .selection-header {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .slots-container {
        max-height: 60px;
    }
    
    .time-slots-container {
        min-height: 100px;
        max-height: 150px;
    }
    
    .btn-modal {
        width: 100%;
        justify-content: center;
        margin-bottom: 0.5rem;
    }
    
    .custom-modal-footer {
        flex-direction: column;
        gap: 0.5rem;
    }
}

@media (max-width: 576px) {
    .custom-modal-wide {
        max-width: 100% !important;
        width: 100% !important;
        margin: 0.5rem !important;
    }
    
    .custom-modal-wide .custom-modal-content {
        max-height: 90vh !important;
    }
    
    .custom-modal-wide .custom-modal-body {
        max-height: 70vh !important;
    }
    
    .info-badges {
        flex-direction: column;
    }
    
    .info-badge {
        text-align: center;
    }
}


.custom-modal-wide .custom-modal-content {
    animation: modalSlideIn 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: scale(0.95) translateY(-20px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}


.custom-modal-body::-webkit-scrollbar {
    width: 8px;
}

.custom-modal-body::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

.custom-modal-body::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #1e293b, #334155);
    border-radius: 4px;
}

.custom-modal-body::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(180deg, #0f172a, #1e293b);
}

.slots-header {
    margin-bottom: 1.5rem;
}

.slots-legend {
    background: #f8fafc;
    padding: 1rem;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #374151;
}

.legend-color {
    width: 16px;
    height: 16px;
    border-radius: 4px;
    display: inline-block;
}

.slots-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 0.75rem;
    max-height: 300px;
    overflow-y: hidden;
    padding: 0.5rem;
    background: #f8fafc;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.slot-wrapper {
    position: relative;
}

.time-slot {
    background: #ffffff;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 0.75rem;
    text-align: center;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    font-weight: 500;
    position: relative;
    overflow: hidden;
}

.time-slot:hover:not(.booked):not(.proses) {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.time-slot.selected {
    animation: selectPulse 0.3s ease-out;
}

.time-slot.tersedia:hover {
    border-color: #3b82f6;
    background-color: #eff6ff;
}

.slot-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
}

.slot-time {
    font-size: 0.875rem;
    font-weight: 600;
}

.status-icon {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    font-size: 0.75rem;
}

.btn-disabled {
    opacity: 0.6;
    cursor: not-allowed;
}


@keyframes selectPulse {
    0% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.4);
    }
    50% {
        transform: scale(1.05);
        box-shadow: 0 0 0 10px rgba(13, 110, 253, 0.1);
    }
    100% {
        transform: scale(1.02);
        box-shadow: 0 0 0 0 rgba(13, 110, 253, 0);
    }
}


.time-slot.range-start {
    border-top-left-radius: 12px;
    border-bottom-left-radius: 12px;
}

.time-slot.range-end {
    border-top-right-radius: 12px;
    border-bottom-right-radius: 12px;
}

.time-slot.range-middle {
    border-radius: 4px;
}


@media (max-width: 768px) {
    .slots-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 0.5rem;
        max-height: 250px;
    }
    
    .time-slot {
        padding: 0.5rem;
    }
    
    .slot-time {
        font-size: 0.8rem;
    }
}

@media (max-width: 576px) {
    .slots-grid {
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    }
    
    .slots-legend {
        flex-direction: column;
        gap: 0.5rem;
    }
}

</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Custom Modal Manager
    const modalId = 'customModal{{ $iteration }}';
    const backdropId = 'customBackdrop{{ $iteration }}';
    
    class CustomModalManager{{ $iteration }} {
        constructor() {
            this.modal = document.getElementById(modalId);
            this.backdrop = document.getElementById(backdropId);
            this.isOpen = false;
            this.init();
        }
        
        init() {
            // Close button handlers
            document.querySelectorAll('[data-close-modal="' + modalId + '"]').forEach(btn => {
                btn.addEventListener('click', () => this.hide());
            });
            
            // Backdrop click handler
            if (this.backdrop) {
                this.backdrop.addEventListener('click', () => this.hide());
            }
            
            // Escape key handler
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.isOpen) {
                    this.hide();
                }
            });
        }
        
        show() {
            if (this.modal && this.backdrop) {
                this.isOpen = true;
                document.body.classList.add('custom-modal-open');
                document.documentElement.style.overflow = 'hidden';
                
                // Show backdrop first
                this.backdrop.classList.add('show');
                
                // Then show modal with slight delay
                setTimeout(() => {
                    this.modal.style.display = 'flex';
                    this.modal.classList.add('show');
                    
                    // Load initial time slots if date is already selected
                    const datePicker = document.getElementById('tanggal_booking{{ $iteration }}');
                    if (datePicker && datePicker.value) {
                        timeSlotSelector{{ $iteration }}.loadTimeSlots(datePicker.value);
                    }
                }, 10);
                
                // Add scroll detection for modal body
                const modalBody = this.modal.querySelector('.custom-modal-body');
                if (modalBody) {
                    this.checkScrollable(modalBody);
                    modalBody.addEventListener('scroll', () => this.checkScrollable(modalBody));
                }
                
                console.log('Custom modal {{ $iteration }} opened');
            }
        }
        
        hide() {
            if (this.modal && this.backdrop) {
                this.modal.classList.remove('show');
                this.backdrop.classList.remove('show');
                
                setTimeout(() => {
                    this.modal.style.display = 'none';
                    document.body.classList.remove('custom-modal-open');
                    document.documentElement.style.overflow = '';
                    this.isOpen = false;
                    
                    // Clear time slot selections when modal closes
                    if (timeSlotSelector{{ $iteration }}) {
                        timeSlotSelector{{ $iteration }}.clearSelections();
                    }
                }, 300);
                
                console.log('Custom modal {{ $iteration }} closed');
            }
        }
        
        checkScrollable(element) {
            if (element.scrollHeight > element.clientHeight) {
                element.classList.add('has-scroll');
            } else {
                element.classList.remove('has-scroll');
            }
        }
    }
    
    // Make it globally accessible
    window['CustomModalManager{{ $iteration }}'] = new CustomModalManager{{ $iteration }}();
    
    // Initialize Time Slot Selector with enhanced configuration
    const datePicker{{ $iteration }} = document.getElementById('tanggal_booking{{ $iteration }}');
    const timeSlotSelector{{ $iteration }} = new TimeSlotSelector({
        containerId: 'timeSlots{{ $iteration }}',
        loadingId: 'loadingSlots{{ $iteration }}',
        startTimeInputId: 'waktu_mulai{{ $iteration }}',
        endTimeInputId: 'waktu_selesai{{ $iteration }}',
        slotsJsonInputId: 'selected_slots_json{{ $iteration }}',
        summaryId: 'timeRangeSummary{{ $iteration }}',
        submitButtonId: 'submitBtn{{ $iteration }}',
        initialSlots: @json($item['selected_slots'] ?? []),
        ruanganId: {{ $item['id'] }}
    });
    
    // Date picker change handler
    datePicker{{ $iteration }}.addEventListener('change', function() {
        const selectedDate = this.value;
        if (selectedDate) {
            // Validate date is not in the past
            const today = new Date();
            const selected = new Date(selectedDate);
            
            if (selected < today.setHours(0,0,0,0)) {
                this.value = '';
                alert('Tidak dapat memilih tanggal yang sudah lewat!');
                return;
            }
            
            timeSlotSelector{{ $iteration }}.loadTimeSlots(selectedDate);
        }
    });
    
    // Form submission handler with enhanced validation
    const form = document.getElementById('editForm{{ $iteration }}');
    const submitBtn = document.getElementById('submitBtn{{ $iteration }}');

    form.addEventListener('submit', function(e) {
        
        const selectedSlotsJson = document.getElementById('selected_slots_json{{ $iteration }}');
        
        // Validate that slots are selected
        if (!selectedSlotsJson.value || selectedSlotsJson.value === '[]') {
            e.preventDefault();
            alert('Harap pilih minimal satu slot waktu!');
            return;
        }
        
        // Show loading state
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i>Menyimpan...';
            submitBtn.disabled = true;
            submitBtn.classList.add('loading');
        }

        
    });
    
    // Add keyboard shortcuts for time slot selection
    document.addEventListener('keydown', function(e) {
        if (!window['CustomModalManager{{ $iteration }}'].isOpen) return;
        
        if (e.ctrlKey || e.metaKey) {
            switch(e.key) {
                case 'a':
                    e.preventDefault();
                    timeSlotSelector{{ $iteration }}.selectAllAvailable();
                    break;
                case 'Backspace':
                case 'Delete':
                    e.preventDefault();
                    timeSlotSelector{{ $iteration }}.clearSelections();
                    break;
            }
        }
    });
    
    // Add date picker enhancement
    if (datePicker{{ $iteration }}) {
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        datePicker{{ $iteration }}.min = today;
        
        // Set maximum date to 30 days from today
        const maxDate = new Date();
        maxDate.setDate(maxDate.getDate() + 30);
        datePicker{{ $iteration }}.max = maxDate.toISOString().split('T')[0];
    }
    
    console.log('Enhanced TimeSlotSelector {{ $iteration }} initialized with smart selection');
});
</script>
@endpush