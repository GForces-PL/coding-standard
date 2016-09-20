<?php

class GForces_Sniffs_Arrays_SquareBracketArraysSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     * @return array
     */
    public function register()
    {
        return [T_ARRAY];
    }

    /**
     * Processes this sniff, when one of its tokens is encountered.
     * @param PHP_CodeSniffer_File $phpcsFile The current file being checked.
     * @param int $stackPtr The position of the current token in the
     *                                        stack passed in $tokens.
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $phpcsFile->addError('array should be declared with square brackets', $stackPtr, 'SquareBracketArrays');
    }
}
