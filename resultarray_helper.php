<?php

if (! function_exists('add_column_link')) {
    /**
     * Add a column to result array containing links (requires "url_helper")
     *
     * Used to add a new position in the results array, containing links (e.g. "Update" or "Delete" links).
     * The result array is used by the Table Library
     *
     * @param array    $result      A model (query) array result
     * @param string   $indexTitle  Index of new array position
     * @param array    $links       Link (or Links) properties ("href", "title", "param" (dynamic parameter) and "attr")
     * @param string   $separator   How to separate one link from another
     */
    function add_column_link($result, $indexTitle, $links, $separator = '&nbsp')
    {
        if(!is_array($result) || !is_array($links)) {
            return '';
        }

        $formattedLinks = [];
        if(!array_key_exists(0, $links)) {
            $formattedLinks[0] = $links;
        }
        else {
            $formattedLinks = $links;
        }

        for($i = 0; $i < count($result); $i++) {
            $newCellValue = '';

            foreach($formattedLinks as $link) {
                $link['href'] = (substr($link['href'] , -1) == '/') ? $link['href'] : $link['href'] . '/';
                $href = $link['href'] . (isset($link['param']) ? $result[$i][$link['param']] : '');
                $newCellValue .= anchor($href, $link['title'], $link['attr'] ?? '') . $separator;
            }
            $result[$i][$indexTitle] = $newCellValue;
        }

        return $result;
    }
}
