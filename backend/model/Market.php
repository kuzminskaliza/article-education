<?php
namespace backend\model;

class Market
{

    const STORAGE_PATH = __DIR__ . '/../../data/market.json';
    private $id;
    private $status;
    private $title;
    private $description;
    private $company;

    private array $errors = [];


    public function getAll(): array
    {
        $jsonData = file_get_contents(self::STORAGE_PATH);
        $arrayData = json_decode($jsonData, true);
        $collection = [];

        foreach ($arrayData as $data) {
            $market = new self();
            $market->id = $data['id'];
            $market->status = $data['status'];
            $market->title = $data['title'];
            $market->description = $data['description'];
            $market->company = $data['company'];

            $collection[] = $market;
        }

        return $collection;

    }

    public function validate(): bool
    {

        if (strlen($this->title) < 10 || strlen($this->title) > 100) {
            $this->errors['title'] = 'Некоректний тайтл';
        }


//        $this->errors['status'] = 'Некоректний статус';

        return empty($this->errors);
    }

    public function create(array $data): bool
    {
        $jsonData = file_get_contents(self::STORAGE_PATH);
        $dataArray = json_decode($jsonData, true);

        $this->id = count($dataArray) + 1;
        $this->status = $data['status'];
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->company = $data['company'];

        return $this->validate() && $this->save();

    }

    public function update(int $id, array $data): bool
    {
       $market = $this->findById($id);


        $this->status = $data['status'];
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->company = $data['company'];

        return $this->validate() && $this->save();

    }

    public function save(): bool
    {
        $jsonData = file_get_contents(self::STORAGE_PATH);
        $dataArray = json_decode($jsonData, true);

        $dataArray[] = [
            'id' => $this->id,
            'status' => $this->status,
            'title' => $this->title,
            'description' => $this->description,
            'company' => $this->company,
        ];

        file_put_contents(self::STORAGE_PATH, json_encode($dataArray, JSON_PRETTY_PRINT));

        return true;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getError(string $attribute): mixed
    {
        return $this->errors[$attribute];
    }

    public function hasError(string $attribute): bool
    {
        return array_key_exists($attribute, $this->errors);
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }


    public function getStatus(): ?string
    {
        return $this->status;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }



    public function getCompany(): ?string
    {
        return $this->company;
    }


}