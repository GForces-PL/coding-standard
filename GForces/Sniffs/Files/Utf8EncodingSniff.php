<?php

class GForces_Sniffs_Files_Utf8EncodingSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * A list of tokenizers this sniff supports.
     * @var array
     */
    public $supportedTokenizers = ['PHP'];

    /**
     * Returns the token types that this sniff is interested in.
     * @return array(int)
     */
    public function register()
    {
        return array(T_OPEN_TAG);
    }

    /**
     * Processes this test, when one of its tokens is encountered.
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int $stackPtr The position of the current token
     *                                        in the stack passed in $tokens.
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        // check the first open tag.
        if ($stackPtr !== 0) {
            if ($phpcsFile->findPrevious(T_OPEN_TAG, ($stackPtr - 1)) !== false) return;
        }

        $filePath = $phpcsFile->getFilename();
        $fileContent = file_get_contents($filePath);
        $encoding = mb_detect_encoding($fileContent, 'UTF-8, ASCII, ISO-8859-1');

        if ($encoding !== 'UTF-8') {
            if ($encoding) {
                $phpcsFile->addError('File must use only UTF-8 encoding. but %s found', $stackPtr, 'FileIsNotUTF8Encoded', [$encoding]);
            } else {
                $phpcsFile->addError('File must use only UTF-8 encoding.', 0);
            }
        }
    }
}
