<?php
class GForces_Sniffs_Scope_MethodScopeSniff extends Squiz_Sniffs_Scope_MethodScopeSniff
{
    /**
     * Processes the tokens within the scope.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being processed.
     * @param int                  $stackPtr  The position where this token was
     *                                        found.
     * @param int                  $currScope The position of the current scope.
     *
     * @return void
     */
    protected function processTokenWithinScope(PHP_CodeSniffer_File $phpcsFile, $stackPtr, $currScope)
    {
        if (GForces_Helper::isSpecFile($phpcsFile->getFilename())) {
            return;
        }
        parent::processTokenWithinScope($phpcsFile, $stackPtr, $currScope);
    }
}
