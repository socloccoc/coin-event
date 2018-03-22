<?php

namespace App\Repository\Contracts;

interface RepositoryInterface
{
    public function all($columns = ['*']);
    public function first($columns = ['*']);
    public function firstByField($field, $value, $columns = ['*']);
    public function find($id, $columns = ['*']);
    public function firstWhere(array $where, $columns = ['*']);
    /**
     * Find data by field and value
     *
     * @param       $field
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findByField($field, $value = null, $columns = ['*']);

    /*
    * Save a new entity in repository
    *
    * @throws ValidatorException
    *
    * @param array $attributes
    *
    * @return mixed
    */
    public function create(array $attributes);
    /**
     * Update a entity in repository by id
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     */
    public function update(array $attributes, $id);
    /**
     * Delete a entity in repository by id
     *
     * @param $id
     *
     * @return int
     */
    public function delete($id);

    public function findWhere(array $where, $take, $skip, $order = null, $orderby = null, $columns = ['*']);
    public function countWhere(array $where, $columns = ['*']);
}
