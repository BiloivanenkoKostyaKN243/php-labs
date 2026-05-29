<?php
class StoreUserRequest {
    public static function validate(array $data, bool $passwordRequired = true): array {
        $errors=[];
        if (trim($data['name'] ?? '') === '') $errors['name']='ПІБ є обов’язковим.';
        if (!filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL)) $errors['email']='Вкажіть коректний email.';
        if ($passwordRequired && strlen($data['password'] ?? '') < 5) $errors['password']='Пароль має містити щонайменше 5 символів.';
        if (($data['age'] ?? '') !== '' && (!is_numeric($data['age']) || (int)$data['age'] < 1)) $errors['age']='Вік має бути додатним числом.';
        if (!in_array(($data['role'] ?? 'user'), ['admin','user','pilot','viewer'], true)) $errors['role']='Некоректна роль.';
        return $errors;
    }
}
