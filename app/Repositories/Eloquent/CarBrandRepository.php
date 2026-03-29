<?php

namespace App\Repositories\Eloquent;

use App\Models\CarBrand;
use App\Repositories\Contracts\CarBrandRepositoryInterface;

class CarBrandRepository implements CarBrandRepositoryInterface {
    public function all() {
        return CarBrand::latest()->get();
    }

    public function find( $id ) {
        return CarBrand::findOrFail( $id );
    }

    public function store( array $data ) {
        return CarBrand::create( $data );
    }

    public function update( $id, array $data ) {
        $brand = $this->find( $id );
        $brand->update( $data );

        return $brand;
    }

    public function delete( $id ) {
        return CarBrand::destroy( $id );
    }
}