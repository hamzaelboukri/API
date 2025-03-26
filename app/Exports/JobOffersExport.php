<?php
namespace App\Exports;

use App\Models\job_offer;
use App\Models\JobOffer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JobOffersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return job_offer::with(['user', 'category'])->get()->map(function ($jobOffer) {
            return [
                'Title' => $jobOffer->title,
                'Description' => $jobOffer->description,
                'Company' => $jobOffer->company,
                'Location' => $jobOffer->location,
                'Salary' => $jobOffer->salary,
                'Contact Email' => $jobOffer->contact_email,
                'Category' => $jobOffer->category ? $jobOffer->category->name : '',
                'Created At' => $jobOffer->created_at->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Title',
            'Description',
            'Company',
            'Location',
            'Salary',
            'Contact Email',
            'Category',
            'Created At',
        ];
    }
}