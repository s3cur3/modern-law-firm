<?php

require_once "googleFonts.php";

class FontOptionsBuilder {
    private $fontList = array();
    private $fontNames = array();


    function __construct() {
        global $fontsJSON;
        $this->fontList = json_decode($fontsJSON, true);
        $this->fontList = $this->fontList['items'];
    }

    public function getNamesList() {
        if( count($this->fontNames) == 0 ) {
            foreach( $this->fontList as $font ) {
                $plussifiedName = str_replace(' ', '+', $font['family']);
                $this->fontNames[$plussifiedName] = $font['family'];
            }
        }

        return $this->fontNames;
    }

    /**
     * @param string $id The identifier you want to use for this option
     * @param string $std The standard selection
     * @return array The array to append to the Options array
     */
    public function getFontFamilySelect($id, $std="Open+Sans") {
        return array(
            'name' => "Font family",
            'desc' => "Hint: click on this massive drop-down list, then type the first character of the font name you're looking for",
            'id' => $id,
            'std' => $std,
            'type' => "select",
            'options' => $this->getNamesList()
        );
    }

    /**
     * @param string $id The identifier you want to use for this option
     * @param string $std The standard selection
     * @return array The array to append to the Options array
     */
    public function getWeightOption($id, $std="400") {
        return array(
            'name' => "Default font weight",
            'desc' => "Note: you shouldn't ask browsers to use a weight that isn't available; the results aren't pretty.",
            'id' => $id,
            'std' => $std,
            'type' => "select",
            'class' => 'mini',
            'options' => array(
                '100' => "Thin (100)",
                '200' => "Extra-light (200)",
                '300' => "Light (300)",
                '400' => "Normal (400)",
                '500' => "Medium (500)",
                '600' => "Semi-bold (600)",
                '700' => "Bold (700)",
                '800' => "Extra-bold (800)",
                '900' => 'Ultra-bold (900)'
            )
        );
    }

    /**
     * @param string $id The identifier you want to use for this option
     * @param string $std The standard selection
     * @return array The array to append to the Options array
     */
    public function getFallbackOption($id, $std="sans-serif") {
        return array(
            'name' => "Fallback fonts",
            'desc' => "If the selected font isn't available, this comma-separated list will be used instead.",
            'id' => $id,
            'std' => $std,
            'type' => "text"
        );
    }

    public function getFontFamilyVariants($id, $std=null) {
        return array(
            'name' => "Font variants to make available",
            'desc' => "",
            'id' => $id,
            'std' => $std,
            'type' => "multicheck",
            'options' => array(
                '100' => "Thin (100)",
                '100italic' => "Thin (100) italic",
                '200' => "Extra-light (200)",
                '200italic' => "Extra-light (200) italic",
                '300' => "Light (300)",
                '300italic' => "Light (300) italic",
                '400' => "Normal (400)",
                '400italic' => "Normal (400) italic",
                '500' => "Medium (500)",
                '500italic' => "Medium (500) italic",
                '600' => "Semi-bold (600)",
                '600italic' => "Semi-bold (600) italic",
                '700' => "Bold (700)",
                '700italic' => "Bold (700) italic",
                '800' => "Extra-bold (800)",
                '800italic' => "Extra-bold (800) italic",
                '900' => 'Ultra-bold (900)',
                '900italic' => 'Ultra-bold (900) italic'
            )
        );
    }

} 