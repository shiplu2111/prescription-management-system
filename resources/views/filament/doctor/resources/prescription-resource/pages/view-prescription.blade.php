<x-filament-panels::page>
    <style>
        .main_div {
            min-width: 800px;
            min-height:220mm;
            margin: 0 auto;
            padding: 10px;
            height: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .p_header {
            width: 100%;
            margin: 0 auto;
            padding: 30px;
            flex : 1;
            flex-direction: row;
            padding-bottom: 30px;
            border-bottom: 1px solid #000;
        }
        .p_sidebar {
            border-right: 2px solid #000;
            min-height: 600px;
            height: 100%;
        }
        .p_main_content {
            /* border-left: 1px solid #000; */
            min-height: 600px;
            height: 100%;
        }

    </style>
    <div class="mx-auto mt-10  p-8 main_div " >
        <div class="flex items-center justify-between p_header pb-10">
            <div class="flex items-start justify-start flex-col">
               <h4 class="text-2xl font-bold text-gray-800"> {{ $record->doctor->name }}</h4>
               <p>{{ $record->doctor->email }}</p>
            </div>
            <div>
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="h-16 w-auto" />
            </div>
            <div class="flex items-start justify-start flex-col">
               <h4 class="text-2xl font-bold text-gray-800"> {{ $record->doctor->name }}</h4>
               <p>{{ $record->doctor->email }}</p>
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
              <p>BP: {{ $record->vitalSign->bp_higher }}/{{ $record->vitalSign->bp_lower }}</p>
              <p>Pulse rate: {{ $record->vitalSign->pulse_rate }}</p>
              <p>Respiratory Rate: {{ $record->vitalSign->respiration_rate }}</p>
              <p>Heart Rate: {{ $record->vitalSign->hart_rate }}</p>
              <p>O2 Saturation: {{ $record->vitalSign->oxygen_saturation }}</p>
              <p>Temparature: {{ $record->vitalSign->temperature }}°  {{ $record->vitalSign->temperature_type }}</p>
              <p>Weight: {{ $record->vitalSign->weight }} {{ $record->vitalSign->weight_type }} </p>
              <p>Height:  {{ $record->vitalSign->height }} {{ $record->vitalSign->height_type }}</p>
              <p>BMI: {{ $record->vitalSign->bmi }}</p>
              <p>BSA: {{ $record->vitalSign->bsa }}</p>
              <p>BMI Status: {{ $record->vitalSign->bmi_status }}</p>
              <p>OFC: {{ $record->vitalSign->ofc }}</p>
              <p>FHR: {{ $record->vitalSign->fhr }}</p>
              <p>LMP: {{ $record->vitalSign->lpm_date }}</p>


            </div>
            <div style="padding-top: 20px">
                <h2  class="font-bold text-lg">Complaint</h2>
                @foreach ($record->complaint as $item)

              <p> ◉ {{ $item['complaint_name'] }}</p>
                @endforeach
            </div>


            <div style="padding-top: 20px">
                <h2  class="font-bold text-lg">Investigation</h2>
                @foreach ($record->investigavion as $item)

              <p> ◉ {{ $item['investigavion_name'] }}</p>
                @endforeach
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
                    <p>{{$item['duration']}}</p>
                </div>
            </div>
            @php
                $i++;
            @endphp
            @endforeach

            </div>
            <div style="padding-top: 50px">
                <h2  class="font-bold text-lg">Advice</h2>
                @foreach ($record->advice as $item)

              <p> ◉ {{ $item['advice'] }}</p>
                @endforeach
            </div>
        </div>
    </div>
    {{-- {{ dd($record) }} --}}
</x-filament-panels::page>
