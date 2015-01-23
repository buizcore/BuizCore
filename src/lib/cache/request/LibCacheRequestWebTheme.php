<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore the business core
* @projectUrl  : http://buizcore.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * @package net.webfrap/cache
 */
class LibCacheRequestWebTheme extends LibCacheRequestCss
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attribute
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * the folder where to cache the assembled css files
   * @var string
   */
  protected $folder = 'cache/web_theme/';

  /**
   * the content type for the header
   * @var string
   */
  protected $contentType = 'text/css';

/*////////////////////////////////////////////////////////////////////////////*/
// Methode
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $list
   */
  public function publishFile($file)
  {

    $map = [];
    include PATH_GW.'/conf/include/web_theme/files.map.php';

    if (!isset($map[$file])  ) {
      header('HTTP/1.0 404 Not Found');

      return;
    }

    ob_start();

    include $map[$file];

    $variables = [];

    if (file_exists(PATH_GW.'conf/conf.style.default.php'))
      include PATH_GW.'conf/conf.style.default.php';

    $tmpVar = [];
    foreach ($variables as $key => $val  )
      $tmpVar['@{'.$key.'}'] = $val;

    $code = ob_get_contents();
    $code = str_replace(array_keys($tmpVar), array_values($tmpVar),  $code   );
    ob_end_clean();

    $codeEtag = md5($code);

    if (!file_exists(PATH_GW.$this->folder.'/file/'))
      SFilesystem::mkdir(PATH_GW.$this->folder.'/file/');

    file_put_contents(PATH_GW.$this->folder.'/file/'.$file.'.plain' ,  $code);
    file_put_contents(PATH_GW.$this->folder.'/file/'.$file.'.plain.md5' ,  $codeEtag);

    $encode = function_exists('gzencode') ? !Log::$levelDebug : false;

    if ($encode) {

      $encoded = gzencode($code);
      $encodedEtag = md5($encoded);

      file_put_contents(PATH_GW.$this->folder.'/file/'.$file.'.gz' ,  $encoded);
      file_put_contents(PATH_GW.$this->folder.'/file/'.$file.'.gz.md5' ,  $encodedEtag);

    }

    if
    (
      isset($_SERVER['HTTP_ACCEPT_ENCODING'])
        && strstr ($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')
        && DEBUG
    )
    {
      // Tell the browser the content is compressed with gzip
      header ("Content-Encoding: gzip");
      $out = $encoded;
      $etag = $encodedEtag;
    } else {
      $out = $code;
      $etag = $codeEtag;
    }

    header('content-type: '. $this->contentType);
    header('ETag: '.$etag);
    header('Content-Length: '.strlen($out));
    header('Expires: Thu, 13 Nov 2179 00:00:00 GMT');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

    echo $out;

  }//end public function publishFile */

  /**
   * @param string $list
   */
  public function publishList($list)
  {

    $theme = Session::status('activ.theme');
    $layoutType = Session::status('default.layout');

   

    $icons = View::$webIcons;
    $images = View::$webImages;

    ob_start();

    include PATH_GW.'conf/include/web_theme/'.$list.'.list.php';

    $code = ob_get_contents();
    //$code = str_replace(array_keys($tmpVar) , array_values($tmpVar),  $code   );
    ob_end_clean();

    //$code = JSMin::minify($code);

    $codeEtag = md5($code);

    if (!file_exists(PATH_GW.$this->folder.'/list/'))
      SFilesystem::mkdir(PATH_GW.$this->folder.'/list/'  );

    file_put_contents(PATH_GW.$this->folder.'/list/'.$list.'.plain' ,  $code);
    file_put_contents(PATH_GW.$this->folder.'/list/'.$list.'.plain.md5' ,  $codeEtag);

    $encode = function_exists('gzencode') ? !DEBUG : false;

    if ($encode) {

      $encoded = gzencode($code);
      $encodedEtag = md5($encoded);

      file_put_contents(PATH_GW.$this->folder.'/list/'.$list.'.gz' ,  $encoded);
      file_put_contents(PATH_GW.$this->folder.'/list/'.$list.'.gz.md5' ,  $encodedEtag);
    }

    if
    (
      isset($_SERVER['HTTP_ACCEPT_ENCODING'])
        && strstr ($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')
        && $encode
    )
    {
      // Tell the browser the content is compressed with gzip
      header ("Content-Encoding: gzip");
      $out = $encoded;
      $etag = $encodedEtag;
    } else {
      $out = $code;
      $etag = $codeEtag;
    }

    header('content-type: '. $this->contentType  );
    header('ETag: '.$etag);
    header('Content-Length: '.strlen($out));
    header('Expires: Thu, 13 Nov 2179 00:00:00 GMT');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

    echo $out;

  }//end public function publishList */

  /**
   * @param string $list
   */
  public function rebuildList($list)
  {

    if (!file_exists(PATH_GW.'/conf/include/css/'.$list.'.list.php'))
      throw new ResourceNotExists_Exception("Css list {$list}");

    //$theme = Session::status('key.theme');
    //$layoutType = Session::status('default.layout');
    $theme = 'default';
    $layoutType = 'full';

    $icons = WEB_ICONS.'icons/classic/';
    $images = WEB_THEME.'themes/classic/images/';

    $files = [];
    $minify = true;

    if (function_exists('gzencode')) {
      $encode = true;
    } else {
      $encode = false;
    }

    Response::collectOutput();
    include PATH_GW.'conf/include/web_theme/'.$list.'.list.php';
    $tmp = Response::getOutput();

    if (file_exists(PATH_GW.'tmp/web_theme/'.$list.'.css')) {
      SFilesystem::delete(PATH_GW.'tmp/web_theme/'.$list.'.css');
      SFilesystem::delete(PATH_GW.'tmp/web_theme/'.$list.'.min.css');
    }

    SFiles::write(PATH_GW.'tmp/web_theme/'.$list.'.css', $tmp);

    system
    (
      'java -jar '.PATH_WGT.'compressor/yuicompressor.jar "'
        .PATH_GW.'tmp/web_theme/'.$list.'.css" --type css --charset utf-8 -o "'
        .PATH_GW.'tmp/web_theme/'.$list.'.min.css"'
    );

    $code = SFiles::read(PATH_GW.'tmp/web_theme/'.$list.'.min.css');

    $codeEtag = md5($code);
    SFiles::write(PATH_GW.$this->folder.'/list/'.$list.'.plain', $code);
    SFiles::write(PATH_GW.$this->folder.'/list/'.$list.'.plain.md5', $codeEtag);

    if ($encode) {
      $encoded = gzencode($code);
      $encodedSize = strlen($encoded);

      SFiles::write(PATH_GW.$this->folder.'/list/'.$list.'.gz' ,  $encoded);
      SFiles::write
      (
        PATH_GW.$this->folder.'/list/'.$list.'.gz.meta' ,
        json_encode(array('etag'=> $codeEtag, 'size' => $encodedSize))
      );
    }

    SFilesystem::delete(PATH_GW.'tmp/web_theme/'.$list.'.css');
    SFilesystem::delete(PATH_GW.'tmp/web_theme/'.$list.'.min.css');

  }//end public function rebuildList */

} // end class LibCacheRequestCss
