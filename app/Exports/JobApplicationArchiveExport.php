<?php

namespace App\Exports;

use App\JobApplication;
use App\Skill;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class JobApplicationArchiveExport implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    use Exportable;

    protected $filters;
    protected $data;

    public function __construct(array $filters, array $data)
    {
        $this->filters = $filters;
        $this->data = $data;
    }

    public function collection()
    {
        $jobApplications = JobApplication::select(
            'job_applications.id',
            'jobs.title',
            'job_applications.full_name',
            'job_locations.location',
            'job_applications.email',
            'job_applications.phone',
            'job_applications.cover_letter',
            'application_status.status',
            'job_applications.created_at'
        )
            ->leftJoin('jobs', 'jobs.id', '=', 'job_applications.job_id')
            ->leftJoin('job_locations', 'job_locations.id', '=', 'jobs.location_id')
            ->leftJoin('application_status', 'application_status.id', '=', 'job_applications.status_id')->onlyTrashed();

        // Filter by skills
        if ($this->filters['skill'] !== 'undefined') {
            $requiredSkill = Skill::select('id', 'name')->where('name', 'LIKE', '%'.strtolower($this->filters['skill']).'%')->first();

            if ($this->filters['skill']) {
                $jobApplications = $jobApplications->whereJsonContains('skills', (string) $requiredSkill->id)->get();
            }
            else {
                $jobApplications = collect([]);
            }
        }
        else {
            $jobApplications = $jobApplications->get();
        }
        $attributes = ['resume_url', 'photo_url'];
        $jobApplications = $jobApplications->makeHidden($attributes);
        
        return $jobApplications;
    }

    public function headings(): array
    {
        return ['ID', 'Job Title', 'Name','Location', 'Email', 'Mobile', 'Cover Letter', 'Status', 'Applied at'];
    }

    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function(BeforeExport $event) {
                $event->writer->getProperties()->setTitle(__('menu.candidateDatabase'))->setDescription(__('modules.applicationArchive.exportFileDescription'))->setCreator('Recruit')->setCompany($this->data['company']);
            },
            AfterSheet::class => function(AfterSheet $event) {
                $styleArray = [
                    'font' => [
                        'bold' => true,
                    ],
                ];
                $event->sheet->getDelegate()->getStyle('A1:H1')->applyFromArray($styleArray);
            },
        ];
    }
}
