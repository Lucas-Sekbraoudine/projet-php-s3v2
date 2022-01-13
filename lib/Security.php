<?php
class Security {

    private static $seed = 'lhItpRyecI';

	public static function hacher($texte_en_clair) {
        $concat = self::$seed . $texte_en_clair;
		$texte_hache = hash('sha256', $concat);
		return $texte_hache;
	}
}
?>