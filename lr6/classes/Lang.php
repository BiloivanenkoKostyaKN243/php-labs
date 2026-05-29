<?php
class Lang {
    private static array $messages = [];
    public static function current(): string { return $_SESSION['locale'] ?? 'uk'; }
    public static function set(string $locale): void { $_SESSION['locale'] = in_array($locale, ['uk','en'], true) ? $locale : 'uk'; }
    public static function get(string $key, array $replace = []): string {
        $locale = self::current();
        if (!isset(self::$messages[$locale])) {
            $file = ROOT_DIR . '/resources/lang/' . $locale . '/messages.php';
            self::$messages[$locale] = file_exists($file) ? require $file : [];
        }
        $text = self::$messages[$locale][$key] ?? $key;
        foreach ($replace as $name => $value) {
            $text = str_replace(':' . $name, (string)$value, $text);
        }
        return $text;
    }
}
function __(string $key, array $replace = []): string { return Lang::get($key, $replace); }
