<?php

/*
 * @author cir8
 */

class APIFunctions {

    private $app;
    
    /**
     *
     * @param object $application 
     */
    public function __construct($application){
        $this->app = $application;
    }
    
    /**
     * Pretty much the overwriting of the fopens method
     * additionally it handles the parsing of the returned
     * JSON object, default read mode is 'rb'.
     */
    public function fetchJSONObject($url, $mode = 'rb') {
        $handle = fopen($url, $mode);
        $body = '';
        while (!feof($handle)) {
            $body .= fread($handle, 131072);
        }
        fclose($handle);

        return json_decode($body);
    }

    /**
     * Builds the API URL for passing into the fetcher for the JSON feed.
     * 
     * @params $s, $c, $form
     * @returns string
     */
    public function buildAPIURL($s = '', $c = 'GB', $form = 'json', $startIndex = 1, $maxResults = 25) {
        $APIkey = 'AIzaSyAgkxANYayzTupDm-0JH-e7hgKljqyrx7E';

        $url = 'https://www.googleapis.com/shopping/search/v1/public/products';
        $key = '?key=' . $APIkey;
        $country = '&country=' . $c;
        $query = '&q=' . $s;
        $format = '&alt=' . $form;

        $startIndex = '&startIndex=' . $startIndex;
        $maxResults = '&maxResults=' . $maxResults;

        return $url . $key . $country . $query . $format;
    }

    /**
     * 
     */
    function errorObjectHandler() {
        
    }

    /**
     * Checks images source
     */
    public function parseImages($link) {
        $img_na = $this->app->getDirConfig('imgs').'no_image.jpg';
        if ($this->parseURL($link) <= 202) {
            $img = $link;
        } else {
            $img = $img_na;
        }
        return $img;
    }

    /**
     * Resizes the image to standard ratios
     */
    public function imageResize($obj, $limit) {
        $link = $obj->link;
        $img_link = $this->parseImages($link);
        list($width, $height, $type, $attr) = getimagesize($img_link);
        $img_ratio = $height / $width;
        $img_height = $img_ratio * $limit;
        $img = '<img src="' . $img_link . '" width="' . $limit . 'px" height="' . $img_height . 'px"/>';

        return $img;
    }

    /**
     * Creates an image gallery for the 
     */
    public function createProductGallery($obj) {
        $image_not_found_src = $this->app->getDirConfig('imgs').'no_image.jpg';
        $gallery = '<div class="images">';
        $image_id = 1;
        $thumb_id = 1;

        if (sizeof($obj) == 1) {
            $gallery .= '<ul id="image-view">
                                <li id="' . $image_id . '"><img src="' . $obj->link . '" height="200px" width="200px"/></li>
                            </ul>
                      </div>';
        } elseif (sizeof($obj) > 1) {
            $gallery .= '<ul id="image-view">';
            foreach ($obj as $res) {
                $gallery .= '<li id="' . $image_id . '"><img src="' . $obj->link . '" height="200px" width="200px"/></li>';
                $image_id++;
            }
            $gallery .= '</ul>';
            $gallery .= '<ul id="image-thumbs">';
            foreach ($obj as $res) {
                $gallery .= '<li><a href="#' . $thumb_id . '"><img src="' . $obj->link . '" height="50px" width="50px"/></a></li>';

                $thumb_id++;
            }
            $gallery .= '</ul>';
        } else {
            $gallery .= '<ul id="image-view">
                                <li id="' . $image_id . '"><img src="' . $image_not_found_src . '" height="200px" width="200px"/></li>
                            </ul>
                      </div>';
        }
        $gallery .= '</div>';

        return $gallery;
    }

    public function parseJSONObject($obj) {
        $content = '';
        $query = $_POST['searchquery'];
        $content = '<span class="faded left"> Results for: "' . $query . '" </span>';
        $content .= '<span class="right"><b>' . $obj->startIndex . '</b> to <b>' . $obj->itemsPerPage . '</b> out of <b class="red">' . $obj->totalItems . '</b> items.</span>';
        $content .= '<br/>';
        foreach ($obj->items as $result) {
            $content .= '<div class="item">';
            if (count($result->product->images) == 1) {
                foreach ($result->product->images as $res) {
                    $content .= '<img src="' . $this->parseImages($res->link) . '" height="100px"/>';
                }
            } else {
                foreach ($result->product->images as $res) {
                    $content .= '<img src="' . $this->parseImages($res->link) . '" height="100px"/>';
                    //$content .= $this->imageResize($res, 100);
                }
            }
            $content .= '<h3>' . ApplicationFunctions::shortenText($result->product->title, 60) . '</h3>';
            $content .= '<p>' . ApplicationFunctions::shortenText($result->product->description, 400) . '</p>';
            $content .= '</div>';
        }
        return $content;
    }

    /*
     * Shorten Description field
     */

    public function shortenDescription($s) {
        $desc = '';
        if (strlen($s) > 100) {
            $desc = substr($s, 0, 100);
            $desc .= ' ...  <a href="#">Read More</a>';
        } else {
            $desc = $s;
        }
        return $desc;
    }

    /*
     * Function to check the state of the HTTP request.
     * 
     * @params $s
     * @returns int
     */

    function parseURL($s) {
        $url_header = @get_headers($s);
        if ($url_header[0] == 'HTTP/1.1 202 Accepted') {
            return 202;
        } elseif ($url_header[0] == 'HTTP/1.1 400 Bad Request') {
            return 400;
        } elseif ($url_header[0] == 'HTTP/1.1 401 Unauthorized') {
            return 401;
        } elseif ($url_header[0] == 'HTTP/1.1 403 Forbidden') {
            return 403;
        } elseif ($url_header[0] == 'HTTP/1.1 404 Not Found') {
            return 404;
        } elseif ($url_header[0] == 'HTTP/1.1 500 Internal Server Error') {
            return 500;
        } elseif ($url_header[0] == 'HTTP/1.1 502 Bad Gateway') {
            return 400;
        } elseif ($url_header[0] == 'HTTP/1.1 503 Service Unavailable') {
            return 503;
        } elseif ($url_header[0] == 'HTTP/1.1 504 Gateway Timeout') {
            return 504;
        } elseif ($url_header == NULL) {
            return 1;
        } else {
            return 0;
        }
    }

    /*
     * Checks to see if a URL points to a legitimate web address.
     * 
     * @params s
     * @returns boolean
     */

    function urlExists($s) {
        if (parseURL($s) == 404) {
            return false;
        } else {
            return true;
        }
    }

    /*
     * Check to see if a variable exists within the Object
     * 
     * @params $object, $variable
     * @returns boolean
     */

    function checkReturnedObjectVar($obj, $var) {
        return isset($obj->$var);
    }

    /*
     * 
     */

    public function parseCacheHeader($url) {
        $header_array = http_parse_headers(http_head($url));
        $exists = array_key_exists('Cache-Control', $header_array);

        return $exists ? $header_array['Cache-Control'] : 'no cache instruction';
    }

}
