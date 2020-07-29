<?php
namespace App\Repositories;

use App\Models\BlogCategory as Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BlogCategoryRepository
 *
 * @package App\Repositories
 */

class BlogCategoryRepository extends CoreRepository
{
    /**
     * @return Model
     */

    protected function getModelClass()
    {
        return Model::class;
    }


    /**
     * Получить модель для редактирования в админке
     *
     * @param int $id
     *
     * @return Model
     */

    public function getEdit($id)
    {
        return $this->startCondition()->find($id);
    }

    /**
     * Получить список категорий для вывода в выпадающем списке
     *
     * @return Collection
     */
    public function getForComboBox()
    {
        $columns = implode(', ', [
            'id',
            'CONCAT (id, ". ", title) AS title_combobox',
        ]);

        $result = $this
            ->startCondition()
            ->selectRaw($columns)
            ->toBase()
            ->get();


        return $result;
    }

    /**
     * Получить категорию для вывода пагинатора
     * @param int|null $perPage
     * @return LengthAwarePaginator
     */
    public function getAllWithPaginate($perPage = null)
    {
        $columns = ['id', 'title', 'parent_id'];

        $result = $this
            ->startCondition()
            ->select($columns)
            ->paginate($perPage);

        return $result;
    }
}