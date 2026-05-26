<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ClientList extends Component
{
    use WithPagination;
    use \Livewire\WithFileUploads;

    public $search = '';
    public $importFile;

    public function rules()
    {
        return [
            'importFile' => 'required|file|mimes:xlsx,xls,csv',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        session()->flash('message', 'Client deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $client = Client::findOrFail($id);
        $client->status = $client->status === 'active' ? 'inactive' : 'active';
        $client->save();
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ClientsExport, 'clients.xlsx');
    }

    public function import()
    {
        $this->validate();

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\ClientsImport, $this->importFile);
            session()->flash('message', 'Clients imported successfully.');
            $this->reset('importFile');
            $this->dispatch('file-uploaded'); // Optional: cleanup input
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $messages = [];
            foreach ($failures as $failure) {
                $messages[] = 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            session()->flash('error', 'Import failed: ' . implode(' | ', $messages));
        } catch (\Exception $e) {
            session()->flash('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $clients = Client::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('company_name', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.client-list', [
            'clients' => $clients,
        ]);
    }
}
