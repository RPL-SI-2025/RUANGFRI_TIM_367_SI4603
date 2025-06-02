
<div class="modal fade" id="editModal{{ $iteration }}" tabindex="-1" aria-labelledby="editModalLabel{{ $iteration }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $iteration }}">Edit Peminjaman Ruangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('mahasiswa.cart.keranjang_ruangan.update', $key) }}" method="POST" id="editForm{{ $iteration }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tanggal_booking{{ $iteration }}" class="form-label">Tanggal Booking</label>
                        <input type="date" class="form-control date-picker" id="tanggal_booking{{ $iteration }}" 
                            name="tanggal_booking" value="{{ $item['tanggal_booking'] }}" required>
                        <small class="form-text text-muted">Pilih tanggal untuk melihat slot waktu tersedia</small>
                    </div>
                    
                    <div id="loadingSlots{{ $iteration }}" style="display: none;" class="text-center my-3">
                        <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                        <p class="mt-2 text-muted">Memuat slot waktu tersedia...</p>
                    </div>
                    
                    <div id="timeSlots{{ $iteration }}" class="mt-4">
                        <p class="text-muted">Pilih tanggal terlebih dahulu untuk melihat slot waktu tersedia</p>
                    </div>
                    
                    <input type="hidden" name="waktu_mulai" id="waktu_mulai{{ $iteration }}" value="{{ date('H:i', strtotime($item['waktu_mulai'])) }}">
                    <input type="hidden" name="waktu_selesai" id="waktu_selesai{{ $iteration }}" value="{{ date('H:i', strtotime($item['waktu_selesai'])) }}">
                    <input type="hidden" name="selected_slots_json" id="selected_slots_json{{ $iteration }}" value="">
                    
                    <div class="mt-3" id="timeRangeSummary{{ $iteration }}">
                        <div class="alert alert-info">
                            <strong>Waktu terpilih:</strong> {{ date('H:i', strtotime($item['waktu_mulai'])) }} - {{ date('H:i', strtotime($item['waktu_selesai'])) }}
                        </div>
                    </div>
                    
                    @if(isset($item['selected_slots']) && is_array($item['selected_slots']) && count($item['selected_slots']) > 0)
                        <div class="mb-3">
                            <label class="form-label">Detail Slot Waktu Saat Ini</label>
                            <div class="p-3 bg-light rounded">
                                @foreach($item['selected_slots'] as $slot)
                                    <span class="badge bg-light text-dark border me-1 mb-1">
                                        {{ $slot['start'] }} - {{ $slot['end'] }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn{{ $iteration }}">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')

@endpush

@push('scripts')
<script src="{{ asset('js/timeslot-selector.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
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
    

    datePicker{{ $iteration }}.addEventListener('change', function() {
        timeSlotSelector{{ $iteration }}.loadTimeSlots(this.value);
    });
});
</script>

@endpush