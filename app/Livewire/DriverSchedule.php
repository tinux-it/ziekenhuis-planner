<?php

namespace App\Livewire;

use App\Models\Driver;
use Carbon\Carbon;
use Livewire\Component;

class DriverSchedule extends Component
{
    public $name = '';

    public $selectedDate = '';

    public $editingDriverId = null;

    public $editingName = '';

    protected $rules = [
        'name' => 'required|min:2',
        'selectedDate' => 'required|date_format:d-m-Y H:i',
    ];

    protected $messages = [
        'name.required' => 'Vul alstublieft uw naam in.',
        'name.min' => 'De naam moet minimaal 2 tekens bevatten.',
        'selectedDate.required' => 'Selecteer alstublieft een datum.',
        'selectedDate.date' => 'De geselecteerde datum is ongeldig.',
    ];

    public function mount()
    {
        $this->selectedDate = '';
    }

    public function save()
    {
        $this->validate();

        if (Driver::where('date', Carbon::createFromFormat('d-m-Y H:i', $this->selectedDate)->format('Y-m-d H:i'))->exists()) {
            $this->addError('selectedDate', 'Deze datum is al toegewezen.');
            dd($this);

            return;
        }

        Driver::create([
            'name' => $this->name,
            'date' => Carbon::createFromFormat('d-m-Y H:i', $this->selectedDate)->format('Y-m-d H:i'),
        ]);

        $this->reset(['name', 'selectedDate']);
    }

    public function edit($driverId)
    {
        $driver = Driver::findOrFail($driverId);
        $this->editingDriverId = $driverId;
        $this->editingName = $driver->name;
    }

    public function update()
    {
        $this->validate([
            'editingName' => 'required|min:2',
        ]);

        Driver::where('id', $this->editingDriverId)->update([
            'name' => $this->editingName,
        ]);

        $this->reset(['editingDriverId', 'editingName']);
    }

    public function delete(int $id)
    {
        Driver::destroy($id);
    }

    private function getAvailableDates()
    {
        $dateStrings = [
            '2025-07-07 14:00',
            '2025-07-08 12:00',
            '2025-07-09 15:30',
            '2025-07-10 11:00',
            '2025-07-11 09:00',
            '2025-07-14 14:50',
            '2025-07-15 11:50',
            '2025-07-16 14:10',
            '2025-07-17 12:00',
            '2025-07-18 12:10',
            '2025-07-21 15:00',
            '2025-07-22 12:00',
            '2025-07-23 12:40',
            '2025-07-24 11:30',
            '2025-07-25 11:10',
            '2025-07-28 15:30',
            '2025-07-29 11:00',
            '2025-07-30 12:10',
            '2025-07-31 09:30',
            '2025-08-01 08:30',
            '2025-08-04 15:30',
            '2025-08-05 09:00',
            '2025-08-06 09:00',
            '2025-08-07 09:30',
            '2025-08-08 09:00',
            '2025-08-11 09:30',
            '2025-08-12 09:30',
            '2025-08-13 11:00',
            '2025-08-14 09:00',
            '2025-08-15 09:00',
            '2025-08-18 09:00',
            '2025-08-19 09:00',
            '2025-08-20 09:00',
            '2025-08-21 09:30',
        ];

        return collect($dateStrings)->map(fn ($date) => Carbon::parse($date));
    }

    public function render()
    {
        $dates = $this->getAvailableDates();

        // Load all drivers whose date matches any of the generated Carbon dates
        $drivers = Driver::whereBetween('date', [
            $dates->first()->copy()->startOfDay(),
            $dates->last()->copy()->endOfDay(),
        ])->get();
        //        dd($drivers);

        // Map drivers by 'Y-m-d' for direct access
        $driverMap = [];
        foreach ($drivers as $driver) {
            $key = Carbon::parse($driver->date)->format('Y-m-d H:i'); // force format to match
            $driverMap[$key] = $driver;
        }
        //        dd($driverMap);

        // Create date-to-driver schedule
        $schedule = [];
        foreach ($dates as $date) {
            $key = $date->format('Y-m-d H:i');
            $schedule[$key] = $driverMap[$key] ?? null;
        }

        return view('livewire.driver-schedule', [
            'schedule' => $schedule,
            'availableDates' => collect($schedule)
                ->filter(fn ($driver) => is_null($driver))
                ->keys()
                ->map(fn ($dateStr) => Carbon::parse($dateStr)),
            'dates' => $dates,
        ]);
    }
}
