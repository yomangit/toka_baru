<?php

namespace App\Livewire\EventReport\PtoReport\Documentation;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Models\DocumentationOfPto;
use App\Models\pto_report;
use Cjmellor\Approval\Models\Approval;

class Create extends Component
{
    use WithFileUploads;
    public $modal, $divider, $file_doc, $reference, $description, $doc_id,$pto_id;

    public function mount($reference, pto_report $id)
    {
        $this->reference = $reference;
        $this->pto_id = $id->id;
    }
    #[On('documentation_pto')]
    public function documentation_pto(DocumentationOfPto $doc)
    {
        $this->modal = "modal-open";
        $this->doc_id = $doc->id;
        if ($this->doc_id) {
            $this->description = $doc->description;
            $this->reference = $doc->reference;
            $this->file_doc = $doc->file_doc;
        }
    }
    public function rules()
    {
        return [
            'description' => 'required',
            'file_doc' => 'required|mimes:jpg,jpeg,png,xlsx,pdf,docx,csv',
        ];
    }
    public function messages()
    {
        return [
            'description.required' => 'Description is required',
            'file_doc.required' => 'File document is required',
            'file_doc.mimes' => 'Only jpg,jpeg,png,xlsx,pdf,docx,csv file types are allowed',
        ];
    }
    public function store()
    {
        $this->validate();
        $file_name = $this->file_doc->getClientOriginalName();
        if ($this->pto_id) {
            $docu = DocumentationOfPto::updateOrCreate(
                ['id' => $this->doc_id],
                [
                    'description' => $this->description,
                    'name_doc' => $file_name,
                    'reference' => $this->reference
                ]
            );
            $source = Approval::where('state', 'pending')->whereIn('new_data->reference', [$this->reference])->get();
            foreach ($source as  $value) {
                Approval::find($value->id)->approve(persist: true);
            }
            $this->reset('modal');
        } else {
            $docu = DocumentationOfPto::updateOrCreate(
                ['id' => $this->doc_id],
                [
                    'description' => $this->description,
                    'name_doc' => $file_name,
                    'reference' => $this->reference
                ]
            );
        }
      
        if ($docu) {
            $this->file_doc->storeAs('public/documents/pto', $file_name);
        }
        if ($this->doc_id) {
            $source = Approval::whereIn('approvalable_id', [$docu->id])->get();
            foreach ($source as  $value) {
                Approval::find($value->id)->approve();
            }
            $this->dispatch(
                'alert',
                [
                    'text' => "Data Updated Successfully!!",
                    'duration' => 3000,
                    'destination' => '/contact',
                    'newWindow' => true,
                    'close' => true,
                    'backgroundColor' => "linear-gradient(to right, #00b09b, #96c93d)",
                ]
            );
        } else {
            $this->dispatch(
                'alert',
                [
                    'text' => "Data added Successfully!!",
                    'duration' => 3000,
                    'destination' => '/contact',
                    'newWindow' => true,
                    'close' => true,
                    'backgroundColor' => "linear-gradient(to right, #00b09b, #96c93d)",
                ]
            );
            $this->reset('description');
            $this->reset('file_doc');
        }

        $this->dispatch('documents_pto_created');
    }
    public function render()
    {
        return view('livewire.event-report.pto-report.documentation.create');
    }

    public function closeModal()
    {
        $this->reset('modal');
    }
}
