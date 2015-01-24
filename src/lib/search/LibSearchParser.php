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
 * @package net.buiz
 */
class LibSearchParser
{
/*////////////////////////////////////////////////////////////////////////////*/
// attribute
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $rawTokens = [];

  /**
   * @var array
   */
  protected $operators = array(
    '+',
    '-',
    //'!',
    '>',
    '<',
    '>=',
    '<=',
    '=',
    '#',
    '@',
  );

  /**
   * @var array
   */
  public $stringTokens = [];

  /**
   * @var array
   */
  public $numberTokens = [];

  /**
   * @var array
   */
  public $intTokens = [];

  /**
   * @var array
   */
  public $tags = [];

  /**
   * @var array
   */
  public $users = [];

  /**
   * @var array
   */
  public $dates = [];

/*////////////////////////////////////////////////////////////////////////////*/
// init methodes
/*////////////////////////////////////////////////////////////////////////////*/


  /**
   * @param string $searchString
   */
  public function analyse( $searchString )
  {

    /* string
hans wurst #test "#test nochwas" @dominik
     */

    $this->rawTokens = explode(' ', $searchString);

    $lastValue = '';

    foreach ( $this->rawTokens as $token ) {

      $token = trim($token);

      if( '' === $token )
        continue;

      // indentify if we have an operator
      $fC = $token[0];
      $op = null;
      $value = '';

      if (isset($token[1])) {

        if($this->isOperator($fC)) {
          if($this->isOperator($fC.$token[1])) {
            $op = $fC.$token[1];
          } else {
            $op = $fC;
          }
        }

      } else if ($this->isOperator($fC)) {
        $op = $fC;
      }

      if ($op) {
        $value = substr($token, strlen($op));
      } else {
        $value = $token;
      }

      if( $op ) {

        if ( '@' === $op ) {
          $this->users[] = $value;
        } else if( '#' === $op ) {
          $this->tags[] = $value;
        } else {

          if (ctype_digit($value)) {
            $this->intTokens[] = array($op,$value);
          } else if( is_numeric($value) ) {
            $this->numberTokens[] = array($op,$value);
          } else if (preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $value)) {
            $this->dates[] = array($op,$value);
          } else {
            $this->stringTokens[] = array($op,$value);
          }
        }

      } else {

        if (ctype_digit($value)) {
          $this->intTokens[] = $value;
        } else if( is_numeric($value) ) {
          $this->numberTokens[] = $value;
        } else if (preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $value)) {
          $this->dates[] = $value;
        } else {
          $this->stringTokens[] = $value; // operator ignorieren?
        }

      }

    }


  }//end public function analyse */


  /**
   * Check ob der string ein Operator ist
   * @param string $string
   * @return boolean
   */
  protected function isOperator( $string )
  {

    return in_array($string, $this->operators);

  }//end protected function isOperator */


} // end class LibSearchParser

