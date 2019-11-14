<?php
namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * Get All
     *
     * @return mixed
     */
    public function getAll();

    /**
     * Find
     *
     * @param integer $id
     * @return mixed
     */
    public function find($id);

    /**
     * Create
     *
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update
     *
     * @param integer $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, array $attributes);

   /**
    * Delete
    *
    * @param integer $id
    * @return void
    */
    public function delete($id);

        /**
     * Update Or create
     *
     * @param array $conditional
     * @param array $attributes
     * @return mixed
     */
    public function updateOrCreate(array $conditional, array $attributes = []);


    /**
     * findWith
     *
     * @param  mixed $id
     * @param  mixed $with
     *
     * @return void
     */
    public function findWith($id, $with = []);

    /**
     * Get With
     *
     * @param  mixed $with
     *
     * @return void
     */
    public function getWith($with = []);

    /**
     * Get Where
     *
     * @param Array $attributes
     * @return mixed
     */
    public function getWhere($attributes);
}
