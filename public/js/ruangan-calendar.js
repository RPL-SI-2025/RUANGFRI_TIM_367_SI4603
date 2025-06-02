/**
 * RuanganCalendar - A class to manage ruangan booking calendar and time slots
 */
class RuanganCalendar {
    constructor(options) {

        this.ruanganId = options.ruanganId;
        this.csrfToken = options.csrfToken;
        this.cartUrl = options.cartUrl;
        this.addToCartUrl = options.addToCartUrl;
        this.timeSlotsUrl = options.timeSlotsUrl;
        this.jadwalUrl = options.jadwalUrl;
        

        this.calendarEl = document.getElementById('full-calendar');
        this.timeslotsContainer = document.getElementById('timeslots-container');
        this.calendarContainer = document.getElementById('calendar-container');
        this.timeslotsList = document.getElementById('timeslots-list');
        this.selectedDateDisplay = document.getElementById('selected-date');
        this.backToCalendarBtn = document.getElementById('back-to-calendar');
        

        this.calendar = null;
        this.jadwalData = [];
        this.selectedSlots = [];
        

        this.initEvents();
    }
    
    initEvents() {

        if (this.backToCalendarBtn) {
            this.backToCalendarBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.timeslotsContainer.style.display = 'none';
                this.calendarContainer.style.display = 'block';
            });
        }
        

        this.fetchJadwalData();
    }
    
    fetchJadwalData() {
        const that = this;
        

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': this.csrfToken
            }
        });
        

        const loadingIndicator = document.createElement('div');
        loadingIndicator.className = 'text-center my-3';
        loadingIndicator.id = 'calendar-loading';
        loadingIndicator.innerHTML = `
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Memuat jadwal...</p>
        `;
        this.calendarContainer.prepend(loadingIndicator);
        

        $.ajax({
            url: this.jadwalUrl + '/' + this.ruanganId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                that.jadwalData = data;
                document.getElementById('calendar-loading')?.remove();
                that.initializeCalendar();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching jadwal data:', error);
                console.log('Response:', xhr.responseText);
                console.log('Requested URL:', that.jadwalUrl + '/' + that.ruanganId);
                
                document.getElementById('calendar-loading')?.remove();
                

                const errorAlert = document.createElement('div');
                errorAlert.className = 'alert alert-warning';
                errorAlert.innerHTML = `
                    <i class="fa fa-exclamation-triangle me-2"></i>
                    Gagal memuat data jadwal. Silakan coba lagi nanti.
                    <button type="button" class="btn btn-sm btn-outline-secondary ms-2" id="retry-fetch">
                        <i class="fa fa-refresh me-1"></i> Coba Lagi
                    </button>
                `;
                that.calendarContainer.prepend(errorAlert);
                

                that.jadwalData = [];
                that.initializeCalendar();
                
                
                document.getElementById('retry-fetch')?.addEventListener('click', function(e) {
                    e.preventDefault();
                    errorAlert.remove();
                    that.fetchJadwalData();
                });
            }
        });
    }
    
    initializeCalendar() {
        const that = this;
        
        if (this.calendar) {
            this.calendar.destroy();
        }
        

        const dateStatusMap = {};
        

        this.jadwalData.forEach(dayData => {
            dateStatusMap[dayData.date] = dayData.status;
        });
        
        this.calendar = new FullCalendar.Calendar(this.calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            },
            initialView: 'dayGridMonth',
            locale: "id",
            firstDay: 1,
            dayMaxEvents: true,
            

            dayCellDidMount: function(info) {
                const y = info.date.getFullYear();
                const m = String(info.date.getMonth() + 1).padStart(2, '0');
                const d = String(info.date.getDate()).padStart(2, '0');
                const dateStr = `${y}-${m}-${d}`;
                const status = dateStatusMap[dateStr];
                

                info.el.classList.add('fc-custom-cell');
                
                if (!status) {

                    info.el.classList.add('fc-day-disabled');
                } else if (status === 'tersedia') {
                    info.el.classList.add('tersedia');
                    info.el.style.cursor = 'pointer';
                } else if (status === 'proses') {
                    info.el.classList.add('proses');
                    info.el.style.cursor = 'pointer';
                } else if (status === 'booked') {
                    info.el.classList.add('booked');
                    info.el.style.cursor = 'not-allowed';
                } else if (status === 'partially-available') {
                    info.el.classList.add('proses');
                    info.el.style.cursor = 'pointer';
                }
            },
            
            dateClick: function(info) {
                const dateStr = info.dateStr;
                const dayData = that.jadwalData.find(item => item.date === dateStr);
                

                if (dayData && dayData.available_count > 0) {
                    that.showTimeSlots(dateStr);
                }
            }
        });
        
        this.calendar.render();
    }
    
    showTimeSlots(date) {
        const that = this;

        this.selectedSlots = [];
        

        this.timeslotsList.innerHTML = `
            <div class="col-12 text-center py-3">
                <div class="spinner-border spinner-border-sm text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-muted mt-2 mb-0">Memuat slot waktu tersedia...</p>
            </div>
        `;
        

        const displayDate = new Date(date).toLocaleDateString('id-ID', { 
            weekday: 'long', 
            day: 'numeric', 
            month: 'long', 
            year: 'numeric' 
        });
        
        this.selectedDateDisplay.textContent = `: ${displayDate}`;
        

        this.calendarContainer.style.display = 'none';
        this.timeslotsContainer.style.display = 'block';
        

        $.ajax({
            url: this.timeSlotsUrl,
            type: 'GET',
            data: {
                id_ruangan: this.ruanganId,
                tanggal: date
            },
            dataType: 'json',
            success: function(slots) {
                that.renderTimeSlots(slots, date);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching time slots:', error);
                that.timeslotsList.innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-danger">
                            <i class="fa fa-exclamation-circle me-2"></i> 
                            Gagal memuat slot waktu. Silakan coba lagi nanti.
                            <button type="button" class="btn btn-sm btn-outline-secondary ms-2" id="retry-timeslots">
                                <i class="fa fa-refresh me-1"></i> Coba Lagi
                            </button>
                        </div>
                    </div>
                `;
                
                document.getElementById('retry-timeslots')?.addEventListener('click', function(e) {
                    e.preventDefault();
                    that.showTimeSlots(date);
                });
            }
        });
    }
    


renderTimeSlots(slots, date) {
    const that = this;
    this.timeslotsList.innerHTML = '';
    
    if (slots.length === 0) {
        this.timeslotsList.innerHTML = `
            <div class="col-12 text-center py-4">
                <p class="text-muted mb-0">Tidak ada slot waktu tersedia untuk tanggal ini</p>
            </div>
        `;
    } 
    else {

        this.timeslotsList.innerHTML = `
            <div class="alert alert-info">
                <i class="fa fa-info-circle me-2"></i>
                Pilih beberapa slot waktu berurutan yang tersedia untuk membuat peminjaman
            </div>
            <div class="row" id="timeSlot-list-container"></div>
        `;
        
        const slotsContainer = this.timeslotsList.querySelector('#timeSlot-list-container');
        
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
            

            if (slot.status === 'tersedia') {
                slotInner.addEventListener('click', function() {
                    this.classList.toggle('selected');
                    
                    if (this.classList.contains('selected')) {
                        this.style.backgroundColor = '#cfe2ff';
                        this.style.borderColor = '#9ec5fe';
                        this.style.boxShadow = '0 0 0 0.25rem rgba(13, 110, 253, 0.25)';
                        this.style.color = '#0d6efd';
                        this.style.fontWeight = 'bold';
                        
                        that.selectedSlots.push({
                            start: slot.start,
                            end: slot.end
                        });
                    } else {

                        this.style.backgroundColor = '#d1e7dd';
                        this.style.borderColor = '#badbcc';
                        this.style.boxShadow = 'none';
                        this.style.color = '#0f5132';
                        this.style.fontWeight = '';
                        
                        const index = that.selectedSlots.findIndex(s => 
                            s.start === slot.start && s.end === slot.end);
                        if (index !== -1) {
                            that.selectedSlots.splice(index, 1);
                        }
                    }
                    

                    that.updateBookingButton();
                });
            } else {

                const statusIcon = document.createElement('span');
                statusIcon.className = 'position-absolute top-0 end-0 p-1';
                statusIcon.innerHTML = `<i class="fa fa-${slot.status === 'proses' ? 'clock-o' : 'lock'}" style="font-size: 0.8rem;"></i>`;
                slotInner.style.position = 'relative';
                slotInner.appendChild(statusIcon);
            }
            
            slotElement.appendChild(slotInner);
            slotsContainer.appendChild(slotElement);
        });
        

        const bookingBtnContainer = document.createElement('div');
        bookingBtnContainer.className = 'col-12 mt-3';
        bookingBtnContainer.innerHTML = `
            <button id="book-selected-slots" class="btn btn-primary" disabled>
                <i class="fa fa-shopping-cart me-2"></i>
                Tambahkan ke Keranjang
            </button>
        `;
        slotsContainer.appendChild(bookingBtnContainer);
        

        document.getElementById('book-selected-slots').addEventListener('click', function() {
            if (that.selectedSlots.length > 0) {

                that.selectedSlots.sort((a, b) => a.start.localeCompare(b.start));
                

                const startTime = that.selectedSlots[0].start;
                const endTime = that.selectedSlots[that.selectedSlots.length - 1].end;
                

                that.addToCart(date, startTime, endTime);
            }
        });
    }
}
    
    updateBookingButton() {
        const bookButton = document.getElementById('book-selected-slots');
        if (!bookButton) return;
        
        if (this.selectedSlots && this.selectedSlots.length > 0) {

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
                bookButton.removeAttribute('disabled');
                bookButton.innerHTML = `
                    <i class="fa fa-shopping-cart me-2"></i>
                    Tambahkan ${sortedSlots[0].start} - ${sortedSlots[sortedSlots.length - 1].end} ke Keranjang
                `;
            } else {
                bookButton.setAttribute('disabled', 'disabled');
                bookButton.innerHTML = `
                    <i class="fa fa-exclamation-triangle me-2"></i>
                    Pilih slot waktu berurutan
                `;
            }
        } else {
            bookButton.setAttribute('disabled', 'disabled');
            bookButton.innerHTML = `
                <i class="fa fa-shopping-cart me-2"></i>
                Tambahkan ke Keranjang
            `;
        }
    }
    
    addToCart(date, startTime, endTime) {
        const that = this;

        const formData = new FormData();
        formData.append('_token', this.csrfToken);
        formData.append('id_ruangan', this.ruanganId);
        formData.append('tanggal_booking', date);
        formData.append('waktu_mulai', startTime);
        formData.append('waktu_selesai', endTime);
        

        if (this.selectedSlots && this.selectedSlots.length > 0) {
            const selectedTimes = this.selectedSlots.map(slot => ({
                start: slot.start,
                end: slot.end
            }));
            formData.append('selected_slots', JSON.stringify(selectedTimes));
        }
        

        const loadingOverlay = document.createElement('div');
        loadingOverlay.style.position = 'fixed';
        loadingOverlay.style.top = '0';
        loadingOverlay.style.left = '0';
        loadingOverlay.style.width = '100%';
        loadingOverlay.style.height = '100%';
        loadingOverlay.style.backgroundColor = 'rgba(255,255,255,0.7)';
        loadingOverlay.style.display = 'flex';
        loadingOverlay.style.justifyContent = 'center';
        loadingOverlay.style.alignItems = 'center';
        loadingOverlay.style.zIndex = '9999';
        loadingOverlay.innerHTML = `
            <div class="text-center">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2">Menambahkan ke keranjang...</p>
            </div>
        `;
        document.body.appendChild(loadingOverlay);
        

        $.ajax({
            url: this.addToCartUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                window.location.href = that.cartUrl;
            },
            error: function(xhr, status, error) {
                document.body.removeChild(loadingOverlay);
                console.error('Error details:', xhr.responseText);
                alert('Gagal menambahkan ke keranjang: ' + (xhr.responseJSON?.message || 'Silakan coba lagi.'));
            }
        });
    }
}


window.RuanganCalendar = RuanganCalendar;