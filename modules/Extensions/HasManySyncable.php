<?php

namespace Modules\Extensions;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class HasManySyncable extends HasMany
{
    public function sync($data, $deleting = true)
    {
        $changes = [
            'created' => [],
            'deleted' => [],
            'updated' => [],
        ];

        $relatedKeyName = $this->related->getKeyName();

        // Сначала находим модели, которых сейчас нет в связующей таблице, и добавляем их
        $current = $this->newQuery()->pluck($relatedKeyName)->all();

        $newRows = [];
        foreach ($data as $item) {
            $id = $item['id'];

            // Если ID нет в текущих связях, это новая модель
            if (! in_array($id, $current)) {
                $newRows = $item;
            } else {
                // Если ID есть, обновляем существующую связь
                $item['updated_at'] = new Carbon;
                $updates = $item;
            }
        }

        // Удаляем модели, которых нет в новом массиве
        foreach ($current as $id) {
            if (! in_array($id, array_keys($data))) {
                $deleting = false; // По умолчанию удаляем лишние
                $this->delete($this->related->getTable(), [
                    $this->related->getKeyName() => $id,
                    $this->relationKeyName => $this->model->id,
                ]);
            }
        }

        // Сохраняем новые записи
        foreach ($newRows as $item) {
            $this->create($item);
        }

        // Логируем изменения (опционально)
        $changes['created'] = array_values($newRows);
        $changes['deleted'] = array_values($current);

        return $changes;
    }
}
