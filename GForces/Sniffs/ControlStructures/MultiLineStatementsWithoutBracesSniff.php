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

        if ($tokens[$start]['code'] == T_WHITESPACE && $tokens[$start]['length'] > 1) {
            $error = 'Single line "%s" must have exactly one space after parenthesis. %s found.';
            $phpcsFile->addError($error, $start, 'SingleLineExpressionMustHaveASpaceAfterParenthesisExpression', array(strtoupper($tokens[$stackPtr]['content']), $tokens[$start]['length']));
        }

        if ($tokens[$start]['code'] == T_WHITESPACE && $tokens[$start]['length'] == 0) {
            $error = 'Multi-line "%s" must have braces. Add braces or convert it to single line.';
            $phpcsFile->addError($error, $start, 'SingleLineExpressionMustHaveASpaceAfterParenthesisExpression', array(strtoupper($tokens[$stackPtr]['content'])));
        }





        return;

        // special trick for "FOR". Exclude 2 internal semicolons
        if ($tokens[$stackPtr]['code'] == T_FOR) {
            $next = $stackPtr;
            for ($i = 0; $i <= 1; $i++) $next = $phpcsFile->findNext([T_SEMICOLON], ($next + 1), null, false, null, false);
            $startPosition = $next + 1;
        }

        //if ($tokens[$stackPtr + 1]['type'] != 'T_WHITESPACE' || strlen($tokens[$stackPtr + 1]['content']) > 1) {
        //    $error = 'Single line ' . $tokens[$stackPtr]['content'] . ' must have a one whitespace before opening parenthesis';
        //    $phpcsFile->addError($error, $stackPtr, 'SingleLineIfMustHaveAWhiteSpace');
        //}

        $bracket = $phpcsFile->findNext([T_OPEN_TAG], $startPosition, null, false, null, true);

        var_dump($tokens[$bracket]);
        return;

        if ($bracket) return;

        if ($next === false) { // this is single line structure.

            // check the whitespace after token


            // find the last close parenthesis in the condition.
            $i = 0;
            $newParenthesis = $stackPtr;
            do {
                $newParenthesis = $phpcsFile->findNext(array(T_OPEN_PARENTHESIS, T_CLOSE_PARENTHESIS), ($newParenthesis + 1));
                $i = ($tokens[$newParenthesis]['type'] == "T_OPEN_PARENTHESIS") ? $i + 1 : $i - 1;
            } while ($i != 0);

            $closeBracket = $newParenthesis;

            // check the new line
            $n = 1;
            $newline = false;

            while ($tokens[$closeBracket + $n]['type'] == 'T_WHITESPACE') {
                $strlen = strlen($tokens[$closeBracket + $n]['content']);
                if ($tokens[$closeBracket + $n]['content'][$strlen - 1] == $phpcsFile->eolChar) {
                    $newline = true;
                    break;
                }
                $n++;
            }

            if ($newline === false) {
                $error = 'Single line "%s" must have an expression started from new line. ';
                $phpcsFile->addError($error, $stackPtr, 'SingleLineExpressionMustHaveANewLineExpression', array(strtoupper($tokens[$stackPtr]['content'])));
            }
        }
    }
}
