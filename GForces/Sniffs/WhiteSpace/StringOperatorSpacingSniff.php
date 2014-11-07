<?php

class GForces_Sniffs_WhiteSpace_StringOperatorSpacingSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return [T_STRING_CONCAT, T_CONCAT_EQUAL];
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

        if ($tokens[$stackPtr + 1]['code'] != T_WHITESPACE || ($tokens[$stackPtr + 1]['code'] == T_WHITESPACE && strlen($tokens[$stackPtr + 1]['content']) != 1)) {
            $phpcsFile->addError('Expected one space after concatenation operator.', $stackPtr);
        }

        $position = $stackPtr - 1;
        while ($tokens[$position]['code'] == T_WHITESPACE) {
            $position--;
        }

        if ($position == $stackPtr - 1) {
            $phpcsFile->addError('Missing space before concatenation operator', $stackPtr);
            return;
        }

        if ($tokens[$stackPtr]['line'] - $tokens[$position]['line'] > 1) {
            $phpcsFile->addError('Only one EOL character before concatenation operator is allowed.', $stackPtr);
        }

        if ($tokens[$stackPtr]['line'] == $tokens[$position]['line'] && strlen($tokens[$stackPtr - 1]['content']) != 1) {
            $phpcsFile->addError('Expected one space before concatenation operator.', $stackPtr);
        }
    }
}
