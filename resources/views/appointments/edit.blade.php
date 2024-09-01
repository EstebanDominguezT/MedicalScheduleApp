@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Appointment') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('appointments.update', $appointment->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="patient_id" class="form-label required">Patient</label>
                                <select name="patient_id" id="patient_id"
                                        class="form-select @error('patient_id') is-invalid @enderror {{ (auth()->user()->hasRole('administrator')) ? '': 'readonly-select' }}" required>
                                    <option value="">Select Patient</option>
                                    @foreach ($patients as $patient)
                                        <option value="{{ $patient->id }}" {{ (auth()->user()->id == $patient->user_id) ? 'selected': '' }}>{{ $patient->user->person->full_name() }}</option>
                                    @endforeach
                                </select>
                                @error('patient_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="doctor_id" class="form-label required">Doctor</label>
                                <select name="doctor_id" id="doctor_id"
                                        class="form-select @error('doctor_id') is-invalid @enderror" required>
                                    <option value="">Select Doctor</option>
                                    @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->id }}"
                                                @if (old('doctor_id', $appointment->doctor_id) == $doctor->id) selected @endif>{{ $doctor->user->person->full_name() }}</option>
                                    @endforeach
                                </select>
                                @error('doctor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="appointment_date" class="form-label required">Date</label>
                                <input type="date" name="appointment_date" id="appointment_date"
                                       class="form-control @error('appointment_date') is-invalid @enderror"
                                       value="{{ old('appointment_date', \Carbon\Carbon::parse($appointment->start_datetime)->format('Y-m-d')) }}"
                                       required>
                                @error('appointment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Calendario para seleccionar la hora -->
                            <div class="mb-3">
                                <label class="form-label required">Available Times</label>
                                <div id="calendar" style="max-width: 100%; margin-bottom: 20px;"></div>
                            </div>

                            <input type="hidden" name="start_datetime" id="start_datetime"
                                   value="{{ old('start_datetime', $appointment->start_datetime) }}">
                            <input type="hidden" name="end_datetime" id="end_datetime"
                                   value="{{ old('end_datetime', $appointment->end_datetime) }}">

                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery (cargar primero) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>

    <script>
        $(document).ready(function() {
            var selectedEvent = null;
            var calendar = null;

            function fetchEvents(doctorId, date) {
                return $.ajax({
                    url: '/appointment/available-hours',
                    method: 'GET',
                    data: {
                        doctor_id: doctorId,
                        date: date,
                        appointment_id: '{{ $appointment->id }}'  // ID de la cita existente
                    }
                });
            }

            function initializeCalendar(events, selectedDate) {
                var calendarEl = document.getElementById('calendar');
                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'timeGridDay',
                    initialDate: selectedDate,
                    allDaySlot: false,
                    events: events,
                    editable: true,  // Habilitar la edición de eventos
                    selectable: true,
                    selectOverlap: false,
                    eventOverlap: false,
                    select: function(info) {
                        if (selectedEvent) {
                            selectedEvent.setProp('backgroundColor', 'green');
                            selectedEvent.setProp('title', 'Disponible');
                            selectedEvent.setProp('borderColor', 'green');
                        }

                        setDateTime(info.startStr, info.endStr);
                        var newEvent = {
                            title: 'Seleccionado',
                            start: info.startStr,
                            end: info.endStr,
                            backgroundColor: 'red',
                            borderColor: 'red'
                        };
                        selectedEvent = calendar.addEvent(newEvent);
                    },
                    eventClick: function(info) {
                        if (info.event.title !== 'Ocupado' && info.event.title !== 'Almuerzo') {
                            if (selectedEvent) {
                                selectedEvent.setProp('backgroundColor', 'green');
                                selectedEvent.setProp('title', 'Disponible');
                                selectedEvent.setProp('borderColor', 'green');
                            }

                            setDateTime(info.event.startStr, info.event.endStr);
                            info.event.setProp('backgroundColor', '#007bff');
                            info.event.setProp('borderColor', '#007bff');
                            info.event.setProp('title', 'Seleccionado');
                            selectedEvent = info.event;
                        }
                    },
                    eventDrop: function(info) {
                        // Manejar el movimiento del evento seleccionado
                        if (selectedEvent && selectedEvent.id === info.event.id) {
                            setDateTime(info.event.startStr, info.event.endStr);
                        }
                    },
                    eventDidMount: function(info) {
                        // Si el evento es el seleccionado desde el backend, configúralo correctamente
                        if (info.event.title === 'Seleccionado') {
                            selectedEvent = info.event;
                            info.event.setProp('backgroundColor', '#007bff');
                            info.event.setProp('borderColor', '#007bff');
                        }
                    }
                });

                calendar.render();
            }

            function setDateTime(start, end) {
                $('#start_datetime').val(start);
                $('#end_datetime').val(end);
            }

            $('#doctor_id, #appointment_date').on('change', function() {
                var doctorId = $('#doctor_id').val();
                var date = $('#appointment_date').val();

                if (doctorId && date) {
                    fetchEvents(doctorId, date).done(function(events) {
                        initializeCalendar(events, date);
                    });
                }
            });

            // Trigger inicial para cargar el calendario con los eventos
            $('#doctor_id').trigger('change');
        });

    </script>
@endsection