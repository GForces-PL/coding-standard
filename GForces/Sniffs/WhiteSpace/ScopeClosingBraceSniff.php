<?php
class GForces_Sniffs_WhiteSpace_ScopeClosingBraceSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     * @return array
     */
    public function register()
    {
        return PHP_CodeSniffer_Tokens::$scopeOpeners;
    }

    /**
     * Processes this test, when one of its tokens is encountered.
     * @param PHP_CodeSniffer_File $phpcsFile All the tokens found in the document.
     * @param int $stackPtr The position of the current token in the
     *                                        stack passed in $tokens.
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        if (!isset($tokens[$stackPtr]['scope_closer'])) return;
        $closeBrace = $tokens[$stackPtr]['scope_closer'];
        $prevContent = $phpcsFile->findPrevious(T_WHITESPACE, ($closeBrace - 1), null, true);
        if ($prevContent !== $tokens[$stackPtr]['scope_opener'] && $tokens[$prevContent]['line'] !== ($tokens[$closeBrace]['line'] - 1)) {
            $error = 'The closing brace for the %s must go on the next line after the body';
            $data = array($tokens[$stackPtr]['content']);
            $phpcsFile->addError($error, $closeBrace, 'CloseBraceAfterBody', $data);
        }
    }
}
