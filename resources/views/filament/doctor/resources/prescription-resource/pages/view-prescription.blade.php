<x-filament-panels::page>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const printButton = document.querySelector('.print-button');
    if (printButton) {
        printButton.addEventListener('click', function () {
            const originalTitle = document.title;
            document.title = "Prescription - {{ $record->patient_name }} - {{ $record->date }}";
            window.print();
            setTimeout(() => {
                document.title = originalTitle;
            }, 1000); // allow print dialog to open before reverting
        });
    }
});
</script>
<script>
    const chambers = @json($chambers);
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const chamberDropdown = document.querySelector('select[name="chamber_dropdown"]');

    chamberDropdown.addEventListener('change', function() {
        const selectedId = this.value;
        const chamber = chambers.find(c => c.id == selectedId);

        if (chamber) {
            document.getElementById('chamberName').textContent = chamber.name;
            document.getElementById('chamberAddress').textContent = chamber.address;
            document.getElementById('chamberPhone').textContent = chamber.phone;
            document.getElementById('chamberOpening').textContent = chamber.opening_time;
            document.getElementById('chamberClosing').textContent = chamber.closing_time;
            document.getElementById('chamberEmail').textContent = chamber.email;
        }
    });
});
</script>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('toggleHeader').addEventListener('click', function () {
                const header = document.getElementById('headerSection');
                header.classList.toggle('hidden');
            });
        });
    </script>
    @endpush
    <style>
        .main_div {
            width: 800px;
            min-height:160mm;
            margin: 0 auto;
            padding: 10px;
            height: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .p_header_container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-direction: column;
            width: 100%;
            padding-bottom: 20px;

            border-bottom: 1px solid #000;
        }
        .p_header {
            width: 100%;
            margin: 0;
            padding-left: 30px;
            padding-right: 10px;
            flex : 1;
            flex-direction: row;
            padding-bottom: 30px;
        }
        .p_sidebar {
            border-right: 2px solid #000;
            min-height: 630px;
            height: 100%;
        }
        .p_main_content {
            /* border-left: 1px solid #000; */
            min-height: 600px;
            height: 100%;
        }
        .print-button {
            background-color: #1d1491;
            color: white;
            padding: 5px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .print-button:hover {
            background-color: #2419c0;
        }

        @media print {
            body * {
                visibility: hidden;
            }
            #printableArea, #printableArea * {
                visibility: visible;

            }
            #printableArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                min-height: 160mm;
                padding: 10px;
                box-shadow: 0 0 0 0 !important;
            }
            .print-button {
                display: none !important;
            }

        }

    </style>
    <div>
        {{-- {{ dd($advices) }} --}}
    <div class="mx-auto mt-10 p-8 flex items-center justify-between gap-4">
        <div class="flex items-center justify-between gap-2 ">
        <button class="print-button fi-sidebar">
            Print
        </button>
         <button class="print-button" id="toggleHeader" >
                    Hide / Show Header
          </button>

          </div>
          <div>
            <select name="chamber_dropdown" class="border-2 border-black rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-500" style="width: 200px;">
                <option value="">Select Chamber</option>
                @foreach ($chambers as $chamber)
                    <option value="{{ $chamber->id }}">{{ $chamber->name }}</option>
                @endforeach
            </select>
          </div>
    </div>
    <div class="mx-auto mt-10  p-8 main_div " id="printableArea">
        <div class="flex items-center justify-between p_header_container" style="min-height: 250px;" >
           <div class="flex items-center justify-between p_header pb-10" id="headerSection">
            <div class="flex items-start justify-start flex-col" style="max-width: 300px;">
               <h4 class="text-2xl font-bold text-gray-800"> {{ $record->doctor->name }}</h4>

                {{-- <p>{{ $profile->specialization }}</p> --}}
                <p>{{ $profile->degree }}</p>
                <p>{{ $profile->institution }}</p>
                <p>{{ $profile->experience }}</p>
                <p>{{ $profile->designation }}</p>
                <p>{{ $profile->university }}</p>
               <p>Date :{{ $record->date }}</p>
               <p>{{ $record->doctor->email }}</p>
            </div>
            <div>
                <img src="{{ asset('images/logo2.png') }}" alt="Logo" class="h-16 w-auto" />
            </div>
            <div class="flex items-end justify-end flex-col" style="text-align: right; max-width: 300px;">
           <div class="flex items-end justify-end flex-col" id="headerChamberSection" style="text-align: right; max-width: 300px;">
    <h4 class="text-2xl font-bold text-gray-800" id="chamberName">{{ $record->chamber->name }}</h4>
    <p id="chamberAddress">{{ $record->chamber->address }}</p>
    <p id="chamberPhone">{{ $record->chamber->phone }}</p>
    <p><span id="chamberOpening">{{ $record->chamber->opening_time }}</span> - <span id="chamberClosing">{{ $record->chamber->closing_time }}</span></p>
    <p id="chamberEmail">{{ $record->chamber->email }}</p>
</div>
            </div>
            </div>
        </div>
        <div class="flex items-center justify-between flex-grow" style="border-bottom: 1px solid #000 ; padding-left:30px; gap:20px; ">
            <div class="flex items-start justify-start flex-col">
                <div class="flex items-center">
                   <span class="text-sm font-bold text-gray-800"> Name: </span>
                   &nbsp;
                    <h6 class="text-sm text-gray-800"> {{ $record->patient_name }}</h6>
               </div>
               <div class="flex items-center">
                   <span class="text-sm font-bold text-gray-800"> Age: </span>
                   &nbsp;
                    <h6 class="text-sm text-gray-800"> {{ $record->patient_age }}</h6>
               </div>
               {{-- <p>{{ $record->patent->email }}</p> --}}
            </div>

            <div class="flex items-start justify-start flex-col">
                <div class="flex items-center">
                   <span class="text-sm font-bold text-gray-800"> Mobile: </span>
                   &nbsp;
                    <h6 class="text-sm text-gray-800"> {{ $record->patient_mobile }}</h6>
               </div>
               <div class="flex items-center">
                   <span class="text-sm font-bold text-gray-800"> Sex: </span>
                   &nbsp;
                    <h6 class="text-sm text-gray-800 capitalize"> {{ $record->patient_gender }}</h6>
               </div>
               {{-- <p>{{ $record->patent->email }}</p> --}}
            </div>

            <div class="flex items-start justify-start flex-col" style="max-width: 350px; text-align: start">
                <div class="flex items-center">
                   <span class="text-sm font-bold text-gray-800"> Address: </span>
                   &nbsp;
                    <h6 class="text-sm text-gray-800"> {{ $record->patient_address }}</h6>
               </div>

            </div>

        </div>

        <div  class="flex" style=" padding-inline:30px;  ">
        <div class=" p_sidebar " style="width: 30%;">
            <div style="padding-top: 10px">
              <h2 class="font-bold text-lg">Vital Sign</h2>
              @if ($record->vitalSign->bp_higher != null && $record->vitalSign->bp_lower != null)
              <p>BP: {{ $record->vitalSign->bp_higher }}/{{ $record->vitalSign->bp_lower }}</p>
              @endif
              @if ($record->vitalSign->pulse_rate != null)
              <p>Pulse rate: {{ $record->vitalSign->pulse_rate }}</p>

              @endif
              @if ($record->vitalSign->respiration_rate != null)

              <p>Respiratory Rate: {{ $record->vitalSign->respiration_rate }}</p>
              @endif
              {{-- ff  --}}
              @if ($record->vitalSign->hart_rate != null)
              <p>Heart Rate: {{ $record->vitalSign->hart_rate }}</p>
              @endif
              @if ($record->vitalSign->oxygen_saturation != null)
              <p>O2 Saturation: {{ $record->vitalSign->oxygen_saturation }}</p>
              @endif
              @if ($record->vitalSign->temperature != null)
              <p>Temparature: {{ $record->vitalSign->temperature }}°  {{ $record->vitalSign->temperature_type }}</p>
              @endif
              @if ($record->vitalSign->weight != null && $record->vitalSign->weight_type != null)
              <p>Weight: {{ $record->vitalSign->weight }} {{ $record->vitalSign->weight_type }} </p>
              @endif
              @if ($record->vitalSign->height != null && $record->vitalSign->height_type != null)
              <p>Height:  {{ $record->vitalSign->height }} {{ $record->vitalSign->height_type }}</p>
              @endif
              @if ($record->vitalSign->bmi != null)
              <p>BMI: {{ $record->vitalSign->bmi }}</p>
              @endif
              @if ($record->vitalSign->bsa != null)
              <p>BSA: {{ $record->vitalSign->bsa }}</p>
              @endif
              @if ($record->vitalSign->bmi_status != null)
              <p>BMI Status: {{ $record->vitalSign->bmi_status }}</p>
              @endif
              @if ($record->vitalSign->ofc != null)
              <p>OFC: {{ $record->vitalSign->ofc }}</p>
              @endif
              @if ($record->vitalSign->fhr != null)
              <p>FHR: {{ $record->vitalSign->fhr }}</p>
              @endif
              @if ($record->vitalSign->lpm_date != null)
              <p>LMP: {{ $record->vitalSign->lpm_date }}</p>
                @endif

            </div>
            <div style="padding-top: 20px">
                <h2  class="font-bold text-lg">Complaint</h2>
                @foreach ($record->complaint as $item)

              <p> ◉ {{ $item['complaint_name'] }}</p>
                @endforeach
            </div>


            <div style="padding-top: 20px">
                <h2  class="font-bold text-lg">Investigation</h2>
                @foreach ($record->investigation as $item)

              <p> ◉ {{ $item['investigation_name'] }}</p>
                @endforeach
            </div>
            <div style="padding-top: 20px">
                <h2  class="font-bold text-lg">Next Visit</h2>
                <p>Date :{{ $record->next_visit_date }}</p>
                <p>Fee :{{ $record->next_visit_fee }}</p>
            </div>





        </div>
        <div class=" p_main_content " style="width: 100%; padding-inline:20px">
            <div style="margin-top: 20px">
            <span class="text-3xl font-bold text-gray-800" style=" margin-top: 20px">
            ℞
            </span>
            </div>
            <div class="flex flex-col" style="margin-top: 20px">
                @php
                $i=1;
            @endphp
            @foreach ($record->prescription_medicines as $item)

             <div class="flex items-center justify-between" style="padding-top: 10px">

                <div>
                    <div class="flex items-start font-semibold">
                  {{ $i }}. &nbsp;<p> {{$item['medicine_name']}}</p>
                  </div>
                   <div class="flex items-center">
                   <p style="padding-left: 20px"> {{$item['dose']}} </p>
                   <p style="padding-left: 20px"> ({{$item['use_time']}})</p>
                   </div>
                </div>
                <div>
                    <p></p>
                    <p> {{$item['duration']}}</p>
                </div>
            </div>
            @php
                $i++;
            @endphp
            @endforeach
            @if ($record->advice != null)
</div>
                <div style="padding-top: 50px">
                <h2  class="font-bold text-lg">Advice</h2>
                @foreach ($record->advice as $item)

              <p> ◉ {{ $item['advice_name'] }}</p>


                @endforeach
            </div>
            @endif


        </div>
    </div>
    </div>
    {{-- {{ dd($record) }} --}}
</x-filament-panels::page>
