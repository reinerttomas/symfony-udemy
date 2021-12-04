<?php
declare(strict_types=1);

namespace App\Controller\Traits;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @mixin AbstractController
 */
trait FlashTrait
{
    protected function addFlashSuccess(string $message): void
    {
        $this->addFlash('success', $message);
    }

    protected function addFlashWarning(string $message): void
    {
        $this->addFlash('warning', $message);
    }

    protected function addFlashError(string $message): void
    {
        $this->addFlash('danger', $message);
    }
}
