<?php
if (!function_exists('spk_icon')) {
    /**
     * Return an inline SVG icon string by name.
     * @param string $name
     * @param array $attrs Additional attributes (class => value)
     * @return string
     */
    function spk_icon(string $name, array $attrs = []): string
    {
        $icons = [
            'chart' => '<path d="M3 13h4v8H3v-8zm6-6h4v14h-4V7zm6 4h4v10h-4V11z"/>',
            'bookmark' => '<path d="M3 6h18v2H3V6zm0 5h12v2H3v-2zm0 5h8v2H3v-2z"/>',
            'box' => '<path d="M3 7v10a2 2 0 0 0 2 2h14V7H3zm2-4h14a2 2 0 0 1 2 2v1H3V5a2 2 0 0 1 2-2z"/>',
            'gear' => '<path d="M19.14 12.936a7.953 7.953 0 0 0 0-1.872l2.036-1.58a0.5 0.5 0 0 0 .12-0.64l-1.926-3.33a0.5 0.5 0 0 0-.6-0.22l-2.4.96a8.12 8.12 0 0 0-1.62-0.94l-0.36-2.52A0.5 0.5 0 0 0 13.9 2h-3.8a0.5 0.5 0 0 0-.5.42l-0.36 2.52c-0.58.24-1.12.54-1.62.94l-2.4-.96a0.5 0.5 0 0 0-.6.22L2.7 8.844a0.5 0.5 0 0 0 .12.64l2.036 1.58c-.06.3-0.1.6-0.1.92s0.04.62.1.92L2.82 14.8a0.5 0.5 0 0 0-.12.64l1.926 3.33c0.15.26.47.36.74.26l2.4-.96c0.5.4 1.04.7 1.62.94l0.36 2.52c0.06.28.3.48.58.48h3.8c0.28 0 0.52-0.2.58-0.48l0.36-2.52c0.58-0.24 1.12-0.54 1.62-0.94l2.4.96c0.27.11.59 0 0.74-0.26l1.926-3.33a0.5 0.5 0 0 0-.12-0.64l-2.036-1.58zM12 15.5A3.5 3.5 0 1 1 12 8.5a3.5 3.5 0 0 1 0 7z"/>',
            'trophy' => '<path d="M12 2l2.9 6.26L22 9.27l-5 4.87L18.18 22 12 18.56 5.82 22 7 14.14l-5-4.87 7.1-1.01L12 2z"/>',
            'home' => '<path d="M3 11.5L12 4l9 7.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1v-8.5z"/>',
            'user' => '<path d="M12 12a5 5 0 1 0-0.001-10.001A5 5 0 0 0 12 12zm0 2c-4 0-7 3-7 6v1h14v-1c0-3-3-6-7-6z"/>',
            'logout' => '<path d="M16 13v-2H7V8l-5 4 5 4v-3zM20 3h-8v2h8v14h-8v2h8a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2z"/>'
        ];

        $svgAttrs = ['width' => '20', 'height' => '20', 'viewBox' => '0 0 24 24', 'xmlns' => 'http://www.w3.org/2000/svg', 'style' => 'margin-right:8px;vertical-align:middle;fill:currentColor'];
        // merge additional attrs
        foreach ($attrs as $k => $v) {
            $svgAttrs[$k] = $v;
        }

        $attrString = '';
        foreach ($svgAttrs as $k => $v) {
            $attrString .= ' ' . $k . '="' . htmlspecialchars($v) . '"';
        }

        if (!array_key_exists($name, $icons)) {
            return '';
        }

        return '<svg' . $attrString . ' role="img" aria-hidden="true">' . $icons[$name] . '</svg>';
    }
}
