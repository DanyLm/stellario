<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Controller;

class IdocController extends Controller
{
    /**
     * idoc
     *
     * @return string
     */
    public function idoc(): string
    {
        $info = view('vendor.idoc.partials.info')->render();
        $content = '';

        foreach ($this->models() as $model) {
            $content .= $this->makeDocumentationTable(app("App\Models\\$model")) . "\n";
        }

        $view = view('vendor.idoc.partials.models', ['content' => $content])->render();

        return "$info \n $view";
    }

    /**
     * models
     *
     * @return array
     */
    private function models(): array
    {
        $folderPath = app_path('Models');
        $fileNames = [];
        $files = glob($folderPath . '/*.php');
        foreach ($files as $file) {
            $fileNames[] = pathinfo($file, PATHINFO_FILENAME);
        }

        return $fileNames;
    }

    /**
     * makeDocumentationTable
     *
     * @param  Model $model
     * @return string
     */
    private function makeDocumentationTable(Model $model): string
    {
        $tableName = $model->getTable();
        $databaseName = $model->getConnection()->getDatabaseName();
        $connectionName = $model->getConnectionName();
        $columns = Schema::connection($connectionName)->getColumnListing($tableName);
        $columnTypes = [];

        // Get foreign keys
        $foreignKeys = [];
        $foreignKeysInfo = $model->getConnection()->getDoctrineSchemaManager()->listTableForeignKeys($tableName);

        foreach ($foreignKeysInfo as $foreignKeyInfo) {
            /** @var ForeignKeyConstraint $foreignKeyInfo */
            $localColumns = $foreignKeyInfo->getLocalColumns();
            $foreignTable = $foreignKeyInfo->getForeignTableName();
            foreach ($localColumns as $localColumn) {
                $foreignKeys[$localColumn] = $foreignTable;
            }
        }

        $relatedModels = [];
        foreach ($foreignKeysInfo as $foreignKeyInfo) {
            /** @var ForeignKeyConstraint $foreignKeyInfo */
            $localColumns = $foreignKeyInfo->getLocalColumns();
            $foreignTable = $foreignKeyInfo->getForeignTableName();
            $relatedModel = '-';

            // Retrieve the related model based on the foreign table name
            foreach ($this->models() as $m) {
                $m = app("App\Models\\$m");
                if ($m->getTable() === $foreignTable) {
                    $relatedModel = (new \ReflectionClass($m))->getShortName();
                    break;
                }
            }
            $relatedModels[$foreignTable] = $relatedModel;

            foreach ($localColumns as $localColumn) {
                $foreignKeys[$localColumn] = $foreignTable;
            }
        }

        // Get column details
        $columnDetails = $model->getConnection()->getDoctrineSchemaManager()->listTableColumns($tableName);
        foreach ($columnDetails as $columnDetail) {
            $columnName = $columnDetail->getName();
            $columnType = $columnDetail->getType()->getName();
            $columnSize = '-';
            $columnNullable = $columnDetail->getNotnull() ? 'Non' : 'Oui';
            $columnDefault = '-';
            $relatedTable = isset($foreignKeys[$columnName]) ? $foreignKeys[$columnName] : '-';
            $relatedModel = isset($foreignKeys[$columnName]) ? $relatedModels[$foreignKeys[$columnName]] : '-';

            try {
                $columnSize = $columnDetail->getLength();
            } catch (\Throwable $exception) {
                $columnSize = '-';
            }

            try {
                $columnDefault = $columnDetail->getDefault() !== null ? $columnDetail->getDefault() : '-';
            } catch (\Throwable $exception) {
                $columnDefault = '-';
            }

            $columnTypes[$columnName] = [
                'type' => $columnType,
                'size' => $columnSize,
                'nullable' => $columnNullable,
                'default' => $columnDefault,
                'related_table' => $relatedTable,
                'related_model' => $relatedModel,
            ];
        }

        $header = '| Colonne | Type | Taile | Null | Défaut | Clé étrangère | Table associée | Modèle associé |';
        $separator = '| --- | --- | --- | --- | --- | --- | --- | --- |';
        $rows = '';
        $modelName = explode("\\", get_class($model));
        $modelName = $modelName[count($modelName) - 1];



        foreach ($columns as $column) {
            $columnType = $columnTypes[$column]['type'];
            $columnSize = $columnTypes[$column]['size'];
            $nullable = $columnTypes[$column]['nullable'];
            $default = $columnTypes[$column]['default'];
            $foreignKey = isset($foreignKeys[$column]) ? 'Oui' : 'Non';
            $relatedTable = $columnTypes[$column]['related_table'];
            $relatedModel = $columnTypes[$column]['related_model'];

            if ($relatedModel != '-') {
                $format = [
                    "[$relatedModel](#section/Modeles/$relatedModel-($relatedTable))",
                    "[$relatedTable](#section/Modeles/$relatedModel-($relatedTable))"
                ];

                $relatedModel = $format[0];
                $relatedTable = $format[1];
            }

            $rows .= '| ' . $column . ' | ' . $columnType . ' | ' . $columnSize . ' | ' . $nullable . ' | ' . $default . ' | ' . $foreignKey . ' | ' . $relatedTable . ' | ' . $relatedModel . ' |' . "\n";
        }

        $table = "## " . $modelName . " (" . $tableName  . ")\n";
        $table .= "```" . get_class($model) . "::class``` ";
        $table .= " --- ```$databaseName.$tableName``` " . "\n\n";
        $table .= $header . "\n" . $separator . "\n" . $rows;

        return $table;
    }
}
