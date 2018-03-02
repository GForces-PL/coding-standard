<?php
/**
 * Description of Helper
 *
 * @author Piotr Hoppe
 */
class GForces_Helper
{
    public static function isSpecFile(string $fileName): bool
    {
        return preg_match('/Spec\.php$/', $fileName);
    }
}
