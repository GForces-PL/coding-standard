<?php

class GForces_Sniffs_ControlStructures_MultiLineStatementsWithoutBracesSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Registers the token types that this sniff wishes to listen to.
     * @return array
     */
    public function register()
    {
        return [T_TRY, T_CATCH, T_DO, T_WHILE, T_FOR, T_IF, T_FOREACH, T_ELSE, T_ELSEIF];
    }

    /**
     * Process the tokens that this sniff is listening for.
     * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
     * @param int $stackPtr The position in the stack where
     *                                        the token was found.
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if (isset($tokens[$stackPtr]['scope_opener'])) {
            return;
        }

        $start = (isset($tokens[$stackPtr]['parenthesis_closer']) ? $tokens[$stackPtr]['parenthesis_closer'] : $stackPtr) + 1;

        if ($tokens[$start]['code'] != T_WHITESPACE) {
            $error = 'Single line "%s" must have a space after parenthesis.';
            $phpcsFile->addError($error, $start, 'SingleLineExpressionMustHaveASpaceAfterParenthesisExpression', array(strtoupper($tokens[$stackPtr]['content'])));
        }

        if ($tokens[$start]['code'] == T_WHITESPACE && strlen($tokens[$start]['content']) > 1) {
            $error = 'Single line "%s" must have exactly one space after parenthesis. %s found.';
            $phpcsFile->addError($error, $start, 'SingleLineExpressionMustHaveASpaceAfterParenthesisExpression', array(strtoupper($tokens[$stackPtr]['content']), strlen($tokens[$start]['content'])));
        }

        if ($tokens[$start]['code'] == T_WHITESPACE && strlen($tokens[$start]['content']) == 0) {
            $error = 'Multi-line "%s" must have braces. Add braces or convert it to single line.';
            $phpcsFile->addError($error, $start, 'SingleLineExpressionMustHaveASpaceAfterParenthesisExpression', array(strtoupper($tokens[$stackPtr]['content'])));
        }
    }
}
