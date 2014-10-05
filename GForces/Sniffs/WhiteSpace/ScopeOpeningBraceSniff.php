<?php
class GForces_Sniffs_WhiteSpace_ScopeOpeningBraceSniff implements PHP_CodeSniffer_Sniff
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
        if (!isset($tokens[$stackPtr]['scope_opener'])) return;
        $opener = $tokens[$stackPtr]['scope_opener'];
        $nextContent = $phpcsFile->findNext(T_WHITESPACE, ($opener + 1), null, true);
        if ($tokens[$nextContent]['line'] - $tokens[$opener]['line'] > 1) {
            $phpcsFile->addError('%s body must begin in the first line after opening brace.', $nextContent, 'OpeningBrace', [$tokens[$stackPtr]['content']]);
        }
    }
}
