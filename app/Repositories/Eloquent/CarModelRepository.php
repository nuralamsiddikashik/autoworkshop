<?php

namespace App\Repositories\Eloquent;

use App\Models\CarModel;
use App\Repositories\Contracts\CarModelRepositoryInterface;

class CarModelRepository implements CarModelRepositoryInterface {
    public function all() {
        return CarModel::with( 'brand' )->latest()->get();
    }

    public function find( $id ) {
        return CarModel::findOrFail( $id );
    }

    public function store( array $data ) {
        return CarModel::create( $data );
    }

    public function update( $id, array $data ) {
        $model = $this->find( $id );
        $model->update( $data );

        return $model;
    }

    public function delete( $id ) {
        return CarModel::destroy( $id );
    }
}