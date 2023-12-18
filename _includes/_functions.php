<?php
// ---------------------------------------------------------
// ***** FUNCTIONS FOR SECURITY
// ---------------------------------------------------------

/**
 * Function for generate token 
 *
 * @return void
 */
function generateToken ():void {
  if(!isset($_SESSION['myToken'])|| !isset($_SESSION['tokenExpire'])|| $_SESSION['tokenExpire'] < time() ) {
    $_SESSION['myToken'] = md5(uniqid(mt_rand(), true));
    $_SESSION['tokenExpire'] =  time() +  30 * 60;
  }};
  
  // ---------------------------------------------------------

  /**
 * Check for CSRF with referer and token
 * Redirect to the given page in case of error
 *
 * @param string $url The page to redirect
 * @return void
 */
function checkCSRF($data): void
{
    if (!isset($_SERVER['HTTP_REFERER']) || !str_contains($_SERVER['HTTP_REFERER'], 'http://localhost/mediafork')) {
        echo json_encode([
          'result' => false,
          'error' => 'ERROR REFFERER'. $_SERVER['HTTP_REFERER']
        ]);
        exit;
    } else if (
        !isset($_SESSION['token']) || !isset($data['token'])
        || $data['token'] !== $_SESSION['token']
        || $_SESSION['tokenExpire'] < time()
    ) {

      echo json_encode([
        'result' => false,
        'error' => 'ERROR TOKEN'
      ]);
}
}

/**
 * Function to check url and token on query syn
 *
 * @param string $url
 * @return void
 */
function checkCSRFSyn(): void
{
    if (!isset($_SERVER['HTTP_REFERER']) || !str_contains($_SERVER['HTTP_REFERER'], 'localhost/mediafork')) {
        $_SESSION['error'] = 'error_referer';
        header('Location: index.php');
        exit;
    } else if (!isset($_SESSION['token']) || !isset($_REQUEST['token']) || $_REQUEST['token'] !== $_SESSION['token'] || $_SESSION['tokenExpire'] < time()) {
        $_SESSION['error'] = 'error_token';
        header('Location: index.php');
        exit;
    }
};



// ---------------------------------------------------------

/**
 * Apply treatment on given array to prevent XSS fault.
 * 
 * @param array &$array
 */
function checkXSS(array &$array): void
{
  foreach ($array as $key => $value) {
    if (!is_array($value)) $array[$key] = strip_tags($value);
    else {
      foreach ($value as $key2 => $value2) {
        $value[$key2] = strip_tags($value2);
      }
    }
  }
}

// ---------------------------------------------------------
// ***** FUNCTIONS FOR GENERATE LINKS / PAGES
// ---------------------------------------------------------

/**
 * Return current page 
 *
 * @return string
 */
function getCurrentPage(): string
{
  return   basename($_SERVER['SCRIPT_NAME']);
}

// ---------------------------------------------------------

/**
 * Get array from data for current page data
 *
 * @param array $pages
 * @return array
 */
function getCurrentPageData(array $pages): ?array
{
  
  return current(array_filter($pages, fn ($p) => $p['file'] === getCurrentPage()));
}

// ---------------------------------------------------------

/**
 * Return html tags for strip JS
 *
 * @param array $links
 * @return string
 */
function generateHtmlScriptJs(array $links): string {
  $html = '';
  foreach ($links as $link) {
    
    $html .= '<script src="' . $link .'"></script>';
  }
  return $html;
}

// ---------------------------------------------------------

/**
 * Return html tags for links css
 *
 * @param array $links
 * @return string
 */
function generateHtmlLinkCss (array $links): string {
  $html = '';
  foreach ($links as $link) {
    
    $html .= '<link rel="stylesheet" href="' . $link .'">';
  }
  return $html;
}

// ---------------------------------------------------------
