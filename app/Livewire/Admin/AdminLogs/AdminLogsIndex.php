<?php

namespace App\Livewire\Admin\AdminLogs;

use App\Models\AdminLog;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AdminLogsIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $userFilter = '';
    public $actionFilter = '';
    public $modelTypeFilter = '';
    public $dateFrom = '';
    public $dateTo = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'userFilter' => ['except' => ''],
        'actionFilter' => ['except' => ''],
        'modelTypeFilter' => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingUserFilter()
    {
        $this->resetPage();
    }

    public function updatingActionFilter()
    {
        $this->resetPage();
    }

    public function updatingModelTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingDateFrom()
    {
        $this->resetPage();
    }

    public function updatingDateTo()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'userFilter', 'actionFilter', 'modelTypeFilter', 'dateFrom', 'dateTo']);
    }

    public function export()
    {
        $logs = $this->getFilteredLogsQuery()->get();

        $csv = "ID,User,Action,Model Type,Model ID,Description,Timestamp\n";
        
        foreach ($logs as $log) {
            $csv .= sprintf(
                "%d,%s,%s,%s,%s,\"%s\",%s\n",
                $log->id,
                $log->user->name ?? 'System',
                $log->action,
                $log->model_type ?? '-',
                $log->model_id ?? '-',
                str_replace('"', '""', $log->description ?? ''),
                $log->created_at->format('Y-m-d H:i:s')
            );
        }

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, 'admin-logs-' . now()->format('Y-m-d-His') . '.csv');
    }

    protected function getFilteredLogsQuery()
    {
        $query = AdminLog::with('user');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('action', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('model_type', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function ($q) {
                      $q->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->userFilter) {
            $query->where('user_id', $this->userFilter);
        }

        if ($this->actionFilter) {
            $query->where('action', $this->actionFilter);
        }

        if ($this->modelTypeFilter) {
            $query->where('model_type', $this->modelTypeFilter);
        }

        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        return $query->orderBy('created_at', 'desc');
    }

    public function render()
    {
        $logs = $this->getFilteredLogsQuery()->paginate(25);

        $users = User::orderBy('name')->get();
        
        $actions = AdminLog::select('action')
            ->distinct()
            ->whereNotNull('action')
            ->orderBy('action')
            ->pluck('action');

        $modelTypes = AdminLog::select('model_type')
            ->distinct()
            ->whereNotNull('model_type')
            ->orderBy('model_type')
            ->pluck('model_type');

        return view('livewire.admin.admin-logs.admin-logs-index', [
            'logs' => $logs,
            'users' => $users,
            'actions' => $actions,
            'modelTypes' => $modelTypes,
        ]);
    }
}
