<?php

namespace Ophim\Core\Traits\Operations;

use Illuminate\Support\Facades\Route;

trait BulkDeleteOperation
{
    protected function setupBulkDeleteRoutes($segment, $routeName, $controller)
    {
        Route::post($segment.'/bulk-delete', [
            'as'        => $routeName.'.bulkDelete',
            'uses'      => $controller.'@bulkDelete',
            'operation' => 'bulkDelete',
        ]);
    }

    protected function setupBulkDeleteDefaults()
    {
        $this->crud->allowAccess('bulkDelete');

        $this->crud->operation('bulkDelete', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
        });

        $this->crud->operation('list', function () {
            $this->crud->enableBulkActions();
            $this->crud->addButton('bottom', 'bulk_delete', 'view', 'crud::buttons.bulk_delete');
        });
    }

    public function bulkDelete()
    {
        $this->crud->hasAccessOrFail('bulkDelete');
        $entries = request()->input('entries', []);
        $deletedEntries = [];

        foreach ($entries as $key => $id) {
            if ($entry = $this->crud->model->find($id)) {
                $deletedEntries[] = $entry->delete();
            }
        }

        return $deletedEntries;
    }
}
