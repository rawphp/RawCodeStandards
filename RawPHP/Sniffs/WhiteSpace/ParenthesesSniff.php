<?php

/**
 * ParenthesesSniff.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Matthew Turland <matt@ishouldbecoding.com>
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   CVS: $Id$
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * Throws errors if spaces are used improperly around constructs, 
 * parentheses, and some operators.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Matthew Turland <matt@ishouldbecoding.com>
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: @release_version@
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class RawPHP_Sniffs_WhiteSpace_ParenthesesSniff
    implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
            T_IF,
            T_ELSE,
            T_ELSEIF,
            T_SWITCH,
            T_WHILE,
            T_FOR,
            T_FOREACH,
            T_OPEN_PARENTHESIS,
            T_CLOSE_PARENTHESIS,
        );
    }

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile All the tokens found in the 
     *        document
     * @param int $stackPtr Position of the current token in the stack passed 
     *        in $tokens
     * @return void
     */
    public function process( PHP_CodeSniffer_File $phpcsFile, $stackPtr )
    {
        $tokens = $phpcsFile->getTokens();

        switch ($tokens[ $stackPtr ][ 'type' ])
        {
            case T_IF:
            case T_ELSEIF:
            case T_SWITCH:
            case T_WHILE:
            case T_FOR:
            case T_FOREACH:
            case T_OPEN_PARENTHESIS:
                if ( $tokens[ $stackPtr + 1 ][ 'type' ] !== T_WHITESPACE &&
                    ($tokens[ $stackPtr + 1 ][ 'content' ] !== '\n' && $tokens[ $stackPtr
                    + 1 ] !== T_CLOSE_PARENTHESIS) )
                {
                    $error = 'Need a space after the opening parentheses';
                    $phpcsFile->addError( $error, $stackPtr );
                }
                break;

            case T_CLOSE_PARENTHESIS:
                if ( $tokens[ $stackPtr - 1 ][ 'content' ] != ' ' )
                {
                    $error = 'Need a space before the closing parentheses';
                    $phpcsFile->addError( $error, $stackPtr );
                }
                break;
            default:
                break;
        }
    }

}