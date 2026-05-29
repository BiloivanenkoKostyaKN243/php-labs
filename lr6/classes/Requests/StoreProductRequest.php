<?php
class StoreProductRequest {
    public static function validate(array $data, array $file = []): array {
        $errors=[];
        $categories = ['Apparel','Accessories','Collectible','Desk Gear','Digital Bonus'];
        if (trim($data['name'] ?? '') === '') $errors['name']='Назва мерчу є обов’язковою.';
        if (!in_array(($data['category'] ?? ''), $categories, true)) $errors['category']='Оберіть категорію мерчу зі списку.';
        if (!is_numeric($data['price'] ?? null) || (float)$data['price'] < 0) $errors['price']='Ціна повинна бути невід’ємним числом.';
        if (strlen(trim($data['description'] ?? '')) > 1000) $errors['description']='Опис до 1000 символів.';
        if (!empty($file['tmp_name'])) {
            $info = @getimagesize($file['tmp_name']);
            if (!$info) $errors['image']='Файл має бути зображенням.';
            elseif ($info[0] < 100 || $info[1] < 100) $errors['image']='Мінімальний розмір зображення — 100×100.';
        }
        return $errors;
    }
}
