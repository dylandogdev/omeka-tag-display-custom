<php
     function tag_cloud($recordOrTags = null, $link = null, $maxClasses = 9, $tagNumber = false, $tagNumberOrder = null)
{

    if (!$recordOrTags) {
        $tags = array();
    } elseif (is_string($recordOrTags)) {
        $tags = get_current_record($recordOrTags)->Tags;
    } elseif ($recordOrTags instanceof Omeka_Record_AbstractRecord) {
        $tags = $recordOrTags->Tags;
    } else {
        $tags = $recordOrTags;
    }

    if (empty($tags)) {
        return '<p>' . __('No tags are available.') . '</p>';
    }

    //Get the largest value in the tags array
    $largest = 0;
    foreach ($tags as $tag) {
        if ($tag["tagCount"] > $largest) {
            $largest = $tag['tagCount'];
        }
    }
    $html = '<div class="hTagcloud">';
    $html .= '<ul class="popularity">';

    if ($largest < $maxClasses) {
        $maxClasses = $largest;
    }
    
    $usedNavLetters=array();
    
    $specialChars="#$%^&*()+=-[]';,./{}|:<>?~";
    
    $numSymbols="1234567890";

    $specialCharInit=false;
    
    $numSymbolsInit=false;
    

    foreach ($tags as $tag) {
        $size = (int) (($tag['tagCount'] * $maxClasses) / $largest - 1);
        $class = str_repeat('v', $size) . ($size ? '-' : '') . 'popular';
        //here evaluate tag name see if in array of used nav anchors, if ! then generate & style separately
        
        $tagName=$tag['name'];
        $firstLetter=strtoupper($tagName[0]);
        if(!$specialCharInit && strpbrk($specialChars, $firstLetter)) {
            $html .= '<div id="specialChar" class="navAnchor"><span class="navSymbol"></div>'; 
            $specialCharInit=true;
        }elseif(!$numSymbolsInit && strpbrk($numSymbols, $firstLetter)) {
            $html .= '<div id="0-9" class="navAnchor"><span class="navSymbol"></div>'; 
            $numSymbolsInit=true;
        }elseif(!in_array($firstLetter, $usedNavLetters) && !strpbrk($specialChars, $firstLetter) && !strpbrk($numSymbols, $firstLetter)) {
            $html .= '<div id="' . $firstLetter . '" class="navAnchor">' . $firstLetter . '</div>';
            array_push($usedNavLetters, $firstLetter);
        }
        
        $html .= '<li class="' . $class . '">';
        if ($link) {
            $html .= '<a href="' . html_escape(url($link, array('tags' => $tag['name']))) . '">';
        }
        if ($tagNumber && $tagNumberOrder == 'before') {
            $html .= ' <span class="count">'.$tag['tagCount'].'</span> ';
        }
        $html .= html_escape($tag['name']);
        if ($tagNumber && $tagNumberOrder == 'after') {
            $html .= ' <span class="count">'.$tag['tagCount'].'</span> ';
        }
        if ($link) {
            $html .= '</a>';
        }
        $html .= '</li>' . "\n";
    }
    $html .= '</ul></div>';
    
    //prepend navbar element
    
    if($numSymbolsInit) {
        array_unshift($usedNavLetters, "0-9");
    } elseif($specialCharsInit){
        array_unshift($usedNavLetters, "@#");
    }
    
    if($usedNavLetters) {
        $navElements = '<div id="tagNavBar">';
        $navElements .= '<ul>';
        foreach($usedNavLetters as $nav) {
            $navElements .= '<li class="tagsNavLetter">
            <a href="#' . $nav . '">' . $nav . '</a></li>';
        }
        $navElements .= '</ul>';
        $navElements .= '</div>';
    }
    
    
    return $navElements .= $html;
};