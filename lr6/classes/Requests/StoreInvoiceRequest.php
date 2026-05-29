<?php
class StoreInvoiceRequest {
    public static function validate(array $data): array {
        $errors=[];
        if ((int)($data['user_id'] ?? 0) <= 0) $errors['user_id']='Оберіть користувача.';
        if ((int)($data['product_id'] ?? 0) <= 0) $errors['product_id']='Оберіть товар.';
        if (trim($data['invoice_date'] ?? '') === '') $errors['invoice_date']='Вкажіть дату.';
        if ((int)($data['quantity'] ?? 0) < 1) $errors['quantity']='Кількість має бути не менше 1.';
        return $errors;
    }
}
