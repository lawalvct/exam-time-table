<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examination Timetable Report</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }
        .header h2 {
            margin: 5px 0 0;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .header h3 {
            margin: 5px 0 0;
            font-size: 14px;
            font-weight: bold;
        }
        .table-container {
            margin-bottom: 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
        }
        .text-center {
            text-align: center;
        }
        /* Print Specifics */
        @media print {
            body {
                padding: 0;
            }
            .page-break {
                page-break-after: always;
            }
            .no-print {
                display: none;
            }
        }
        .print-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #008751;
            color: white;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            border: none;
        }
        .print-btn:hover {
            background-color: #00683d;
        }
    </style>
</head>
<body>

    <div class="no-print" style="text-align: center;">
        <button class="print-btn" onclick="window.print()">Print Timetable</button>
    </div>

    @if($timetablesBySlot->isEmpty())
        <div class="header">
            <h2>No Timetable Records Found</h2>
            <p>Please adjust your filters or generate a timetable.</p>
        </div>
    @else
        @php $dayCounter = 1; @endphp
        @foreach($timetablesBySlot as $slotId => $timetables)
            @php
                $slot = $timetables->first()->timeSlot;
                $dateStr = \Carbon\Carbon::parse($slot->date)->format('l, jS F Y');
                $timeStr = \Carbon\Carbon::parse($slot->start_time)->format('g:i A') . ' - ' . \Carbon\Carbon::parse($slot->end_time)->format('g:i A');
                
                // Determine Morning/Afternoon session text roughly based on start time
                $startHour = (int) \Carbon\Carbon::parse($slot->start_time)->format('H');
                $sessionName = $startHour < 12 ? 'MORNING SESSION' : 'AFTERNOON SESSION';
            @endphp

            <div class="table-container page-break">
                <div class="header">
                    <h1>ABRAHAM ADESANYA POLYTECHNIC, IJEBU-IGBO, OGUN STATE</h1>
                    <h2>{{ strtoupper($semesterLabel) }} EXAMINATION, {{ $sessionLabel }} ACADEMIC SESSION</h2>
                    <h3>SITTING ARRANGEMENT (DAY {{ $dayCounter++ }}) {{ strtoupper($dateStr) }}, {{ $sessionName }} ({{ $timeStr }})</h3>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th width="20%">COURSE CODE</th>
                            <th width="20%">VENUE</th>
                            <th width="35%">MATRIC Nos</th>
                            <th width="10%" class="text-center">Total</th>
                            <th width="15%">INVIGILATORS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($timetables as $entry)
                            <tr>
                                <td>
                                    <strong>{{ $entry->course->code }}</strong><br>
                                    <span style="font-size: 10px;">({{ $entry->course->department->code }} {{ $entry->course->level->name }})</span>
                                </td>
                                <td>{{ $entry->hall->name }}</td>
                                <td>{{ $entry->matric_range ?? '.........................................' }}</td>
                                <td class="text-center">{{ $entry->student_count }}</td>
                                <td>{{ optional($entry->invigilator)->name ?? '...........................' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    @endif

</body>
</html>