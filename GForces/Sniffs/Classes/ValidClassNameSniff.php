<?php

class GForces_Sniffs_Classes_ValidClassNameSniff extends Squiz_Sniffs_Classes_ValidClassNameSniff
{
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        if (strpos($phpcsFile->getFilename(), '/protected/migrations/') !== false) {
            return;
        }
        return parent::process($phpcsFile, $stackPtr);
    }
}
