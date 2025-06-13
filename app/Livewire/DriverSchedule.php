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
        'selectedDate' => 'required|date',
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

        Driver::create([
            'name' => $this->name,
            'date' => $this->selectedDate,
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
        $start = Carbon::parse('2024-06-30');
        $end = $start->copy()->addWeeks(6);

        $dates = collect();
        while ($start <= $end) {
            if ($start->isWeekday()) {
                $dates->push($start->copy());
            }
            $start->addDay()->locale('nl');
        }

        return $dates;
    }

    public function render()
    {
        $dates = $this->getAvailableDates();

        // Load all drivers whose date matches any of the generated Carbon dates
        $drivers = Driver::whereBetween('date', [
            $dates->first()->copy()->startOfDay(),
            $dates->last()->copy()->endOfDay(),
        ])->get();

        // Map drivers by 'Y-m-d' for direct access
        $driverMap = [];
        foreach ($drivers as $driver) {
            $key = Carbon::parse($driver->date)->format('Y-m-d');
            $driverMap[$key] = $driver;
        }

        // Create date-to-driver schedule
        $schedule = [];
        foreach ($dates as $date) {
            $key = $date->format('Y-m-d');
            $schedule[$key] = $driverMap[$key] ?? null;
        }

        return view('livewire.driver-schedule', [
            'schedule' => $schedule,
            'availableDates' => $dates->filter(function ($date) use ($drivers) {
                return ! isset($drivers[$date->format('Y-m-d')]);
            }),
            'dates' => $dates,
        ]);
    }
}
