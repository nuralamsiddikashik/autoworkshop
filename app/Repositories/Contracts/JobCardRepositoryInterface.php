<?php

namespace App\Repositories\Contracts;

interface JobCardRepositoryInterface {
    public function create( array $data );
    public function getAll();
    public function findByReceiveNo( string $receiveNo );
    public function findByJobNo( string $jobNo );
}
