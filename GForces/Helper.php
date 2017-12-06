<?php
/**
 * Description of Helper
 *
 * @author Piotr Hoppe
 */
class Helper
{
    public static function isSpecFile(string $fileName): bool
    {
        return preg_match('/Spec\.[^\.]*$/', $fileName);
    }
}
