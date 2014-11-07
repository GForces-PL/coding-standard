<?php

class GForces_Sniffs_WhiteSpace_ObjectOperatorSpacingSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_OBJECT_OPERATOR);
    }

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token
     *                                        in the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        if ($tokens[($stackPtr - 1)]['code'] == T_WHITESPACE) {
            if ($tokens[($stackPtr - 2)]['code'] != T_WHITESPACE) {
                $error = 'Space found before object operator';
                $phpcsFile->addError($error, $stackPtr, 'Before');
            } else {
                if ($tokens[($stackPtr - 3)]['code'] == T_WHITESPACE) {
                    $error = 'Only one EOL character before object operator is allowed.';
                    $phpcsFile->addError($error, $stackPtr, 'Before');
                }
            }
        }

        if ($tokens[($stackPtr + 1)]['code'] == T_WHITESPACE) {
            $error = 'Space found after object operator';
            $phpcsFile->addError($error, $stackPtr, 'After');
        }
    }
}