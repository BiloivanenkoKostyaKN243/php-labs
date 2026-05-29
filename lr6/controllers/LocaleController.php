<?php
class LocaleController extends PageController {
    public function action_switch(): void {
        Lang::set((string)$this->request->get('lang', 'uk'));
        $back = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        header('Location: ' . $back);
        exit;
    }
}
