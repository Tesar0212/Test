<?php

namespace App\Services\Profile\DTO;

use Illuminate\Http\UploadedFile;

class ProfileUpdateDTO
{
    public $name;
    public $email;
    public $job;
    public $company;
    public $phone;
    public $mobile;
    public $country;
    public $avatar;

    public function __construct(
        string $name,
        string $email,
        $job = null,
        $company = null,
        $phone = null,
        $mobile = null,
        $country = null,
        UploadedFile $avatar = null
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->job = $job;
        $this->company = $company;
        $this->phone = $phone;
        $this->mobile = $mobile;
        $this->country = $country;
        $this->avatar = $avatar;
    }

    public static function fromArray(array $data, UploadedFile $avatar = null): self
    {
        return new self(
            $data['name'],
            $data['email'],
            $data['job'] ?? null,
            $data['company'] ?? null,
            $data['phone'] ?? null,
            $data['mobile'] ?? null,
            $data['country'] ?? null,
            $avatar
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'job' => $this->job,
            'company' => $this->company,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'country' => $this->country,
        ];
    }
}
