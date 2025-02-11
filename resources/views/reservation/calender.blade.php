@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Kalender Reservasi</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            var calendarEvent = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEvent, {
                initialView : 'dayGridMonth',
                locale : 'id',
                headerToolbar : {
                    left : 'prev,next,today',
                    center : 'title',
                    right : 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText : {
                    today : 'Hari Ini',
                    month : 'Bulan',
                    week : 'Minggu',
                    day : 'Hari'
                },
                buttonIcons : {
                    prev: 'arrow-left-square-fill',
                    next: 'arrow-right-square-fill',
                },
                events : "{{ route('calendar.events') }}",
                eventDidMount: function(info) {
                    // Pastikan warna diterapkan
                    if (info.event.backgroundColor) {
                        info.el.style.backgroundColor = info.event.backgroundColor;
                        info.el.style.borderColor = info.event.borderColor;
                    }
                }

            });

            calendar.render();
        })
    </script>
@endpush
